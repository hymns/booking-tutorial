@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Create New Item') }}</div>
                    <div class="card-body">
                        <form class="row g-3" action="{{ route('items.store') }}" method="post">
                            @csrf
                            @include('shared.message')
                            <div class="col-md-12">
                                <label for="type_id" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-control @error('type_id') is-invalid @enderror" name="type_id">
                                    @foreach($types as $row)
                                    <option value="{{ $row->id }}" {{ ($row->id == old('type_id') ? 'selected' : '') }}>{{ $row->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea rows="5" class="form-control @error('name') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
