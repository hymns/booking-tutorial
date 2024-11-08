@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create New Booking') }}</div>
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('bookings.store') }}" method="post">
                            @csrf
                            @include('shared.message')
                            <div class="col-md-12">
                                <label for="item_id" class="form-label">Item <span class="text-danger">*</span></label>
                                <select name="item_id" id="item_id" class="form-control" required>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ ucfirst($item->type->name) }})</option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" />
                                @error('start_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="end_date" class="form-label">Return Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" />
                                @error('end_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="item_id">Select Item</label>
        <select name="item_id" id="item_id" class="form-control" required>
            @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->name }} ({{ ucfirst($item->type) }})</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="start_time">Start Time</label>
        <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="end_time">End Time</label>
        <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Submit Booking</button>
</form> --}}