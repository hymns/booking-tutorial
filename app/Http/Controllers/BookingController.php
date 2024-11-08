<?php

namespace App\Http\Controllers;

use App\Http\Requests\Booking\StoreRequest;
use App\Http\Requests\Booking\UpdateRequest;
use Illuminate\Database\QueryException;
use App\Models\Booking;
use App\Models\Email;
use App\Models\Item;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        // admin
        if ($user->role->name == 'Admin') {
            $bookings = Booking::with('user', 'item')
                               ->paginate();            
        } 
        
        // user manager
        elseif ($user->role->name == 'Manager') {
            $bookings = Booking::with('user', 'item')
                               ->where('status', 'pending')
                               ->paginate();
        }

        // user staff
        else {
            $bookings = Booking::with('user', 'item')
                               ->where('user_id', auth()->id())
                               ->paginate();
        }

        return view('bookings.list', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = Item::with('type')->get();

        return view('bookings.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        try {
            $overlappingBooking = Booking::where('item_id', $request->item_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                        });
                })
                ->exists();

            if ($overlappingBooking) {
                return redirect()->back()->with('error', 'This item is already booked for the requested time.');
            }

            $booking = Booking::create([
                'user_id' => auth()->id(),
                'item_id' => $request->item_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);
            
            $booking->load('user');

            // get email template
            $email = Email::where('name', 'Pending')->first();

            // send email
            Mail::raw($email->body, function ($mail) use ($booking, $email) {
                $mail->to($booking->user->email)
                     ->subject($email->subject);
            });    

            return redirect()->route('bookings.index')->with('success', 'Booking requested successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        $booking->load('user', 'item', 'item.type');
        
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        $items = Item::with('type')->get();

        return view('bookings.edit', compact('booking', 'items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Booking $booking)
    {
        $validated = $request->validated();

        try {
            $overlappingBooking = Booking::where('item_id', $request->item_id)
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                        ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                        ->orWhere(function ($query) use ($request) {
                            $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                        });
                })
                ->exists();

            if ($overlappingBooking) {
                return redirect()->back()->with('error', 'This item is already booked for the requested time.');
            }

            $booking->update([
                'item_id' => $request->item_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
            ]);

            return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        try {
            $booking->delete();
        } catch(QueryException $e) {
            return redirect()->back()->with('error', $e->errorInfo);
        }
        
        return redirect()->route('bookings.index')->with('success', 'Selected data successfully deleted');
    }

    /**
     * Approve the specified booking from bookings.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'approved';
        $booking->save();

        // get email template
        $email = Email::where('name', 'Approved')->first();

        // send email
        Mail::raw($email->body, function ($mail) use ($booking, $email) {
            $mail->to($booking->user->email)->subject($email->subject);
        });    

        return redirect()->back()->with('success', 'Booking approved.');
    }

    /**
     * Reject the specified booking from bookings.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reject($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->status = 'rejected';
        $booking->save();

        // get email template
        $email = Email::where('name', 'Rejected')->first();

        // send email
        Mail::raw($email->body, function ($mail) use ($booking, $email) {
            $mail->to($booking->user->email)->subject($email->subject);
        });    

        return redirect()->back()->with('success', 'Booking rejected.');
    }
}
