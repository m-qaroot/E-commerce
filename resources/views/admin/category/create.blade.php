@extends('admin.master')

@section('title' , 'Create Categories |' . env('APP_NAME'))

@section('content')

<div class="d-flex justify-content-between align-item-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Categories</h1>
    <a class="btn btn-primary" href="{{ route('admin.categories.index') }}">All Categories</a>
</div>

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Enter The Name">
    </div>

    <div class="mb-3">
        <label for="image">Inmge</label>
        <input type="file" class="form-control" name="image" id="image">
    </div>

    <div class="mb-3">
        <label for="parent_id">Parent</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="" disabled selected>--selected--</option>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success px-5">Save</button>
</form>


@endsection
