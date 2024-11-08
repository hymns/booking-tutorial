@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">{{ __('Manage Items') }}</h5>
                        <a href="{{ route('items.create') }}" class="btn btn-primary ms-auto">Add Item</a>
                    </div>
                    <div class="card-body">
                        @include('shared.message')
                        <table class="table responsive">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if ($items->count())
                                @foreach ($items as $row)
                                    <tr>
                                        <th scope="row">{{ $items->firstItem() + $loop->index }}</th>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->type->name }}</td>
                                        <td class="text-center">
                                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                                    </svg>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('items.edit', $row->id) }}">Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('delete-{{ $row->id }}').submit();">Delete</a></li>
                                            </ul>
                                            <form id="delete-{{ $row->id }}" action="{{ route('items.destroy', $row->id) }}" method="post" style="display: none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">- No Record Found -</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>                        
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
