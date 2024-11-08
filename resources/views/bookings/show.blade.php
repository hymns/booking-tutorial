@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('View Booking Details') }}</div>
                    <div class="card-body">
                        <form class="row g-3" action="#" method="get">
                            @include('shared.message')
                            <div class="col-md-12">
                                <label for="id" class="form-label">Status: </label>
                                <span><b>{{ ucwords($booking->status) }}</b></span>
                            </div>
                            <div class="col-md-12">
                                <label for="id" class="form-label">ID: </label>
                                <span>{{ $booking->id }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name: </label>
                                <span>{{ $booking->user->name }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="item" class="form-label">Type: </label>
                                <span>{{ $booking->item->type->name }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="item" class="form-label">Item: </label>
                                <span>{{ $booking->item->name }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="start" class="form-label">Start Date: </label>
                                <span>{{ $booking->start_date }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="return" class="form-label">Return Date: </label>
                                <span>{{ $booking->end_date }}</span>
                            </div>

                            <div class="col-12">
                                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Back</a>
                                @if (in_array($booking->status, ['pending']))
                                <form action="{{ route('bookings.approve', $booking->id) }}" method="post" class="row mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                </form>

                                <form action="{{ route('bookings.reject', $booking->id) }}" method="post" class="row mb-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
