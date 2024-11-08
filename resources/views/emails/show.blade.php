@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('View Email Template') }}</div>
                    <div class="card-body">
                        <form class="row g-3" action="#" method="get">
                            @include('shared.message')
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name: </label>
                                <span>{{ $email->name }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="form-label">Subject: </label>
                                <span>{{ $email->subject }}</span>
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="form-label">Body:</label>
                                <p>{{ $email->body }}</p>
                            </div>

                            <div class="col-12">
                                <a href="{{ route('emails.index') }}" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
