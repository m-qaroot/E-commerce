@extends('admin.master')

@section('title' , 'Create Prodcuts |' . env('APP_NAME'))

@section('content')

<div class="d-flex justify-content-between align-item-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Create Prodcuts</h1>
    <a class="btn btn-primary" href="{{ route('admin.products.index') }}">All Prodcuts</a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name">Product Name</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Enter Product Name"/>
    </div>
    
    <div class="mb-3">
        <label for="image">Choose Image</label>
        <input type="file" name="image" id="image" class="form-control"/>
    </div>
    
    <div class="mb-3">
        <label for="description">Write Description</label>
        <textarea name="description" rows="5" class="form-control"></textarea>
    </div>
    
    <div class="mb-3">
        <label for="price">Cost Price</label>
        <input type="number" name="price" id="price" class="form-control"/>
    </div>
    
    <div class="mb-3">
        <label for="sale_price">Sale Price</label>
        <input type="number" name="sale_price" id="sale_price" class="form-control"/>
    </div>
    
    <div class="mb-3">
        <label for="quntity">Quantity</label>
        <input type="number" name="quntity" id="quntity" class="form-control"/>
    </div>

    <div class="mb-3">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="" disabled selected>--Select-</option>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    

    {{-- <div class="mb-3">
        <label for="parent_id">Parent</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="" disabled selected>--selected--</option>
            @foreach ($products as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <button class="btn btn-success px-5">Save</button>
</form>


@endsection
