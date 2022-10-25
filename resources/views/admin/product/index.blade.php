@extends('admin.master')

@section('title' , 'All Products |' . env('APP_NAME'))

@section('styles')
<style>
    .table th , .table td {
        vertical-align: middle;
    }
</style>
@stop

@section('content')

<div class="d-flex justify-content-between align-item-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">All Products</h1>
    <a class="btn btn-secondary" href="{{ route('admin.products.create') }}">Add New Product</a>
</div>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">{{ session('msg') }}</div>    
@endif

<table class="table table-hover table-bordered table-striped">

    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Sale Price</th>
        <th>Qty</th>
        <th>Image</th>
        <th>Category</th>
        <th>Created At</th>
        <th>Action</th>
    </tr>

    @foreach ($products as $product)
    <tr>
        <td>{{ $product->id }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->description}}</td>
        <td><img width="100" height="100" src="{{ asset('uploads/images/products/' . $product->image ) }}" alt=""></td>
        <td>{{ $product->price}}</td>
        <td>{{ $product->sale_price}}</td>
        <td>{{ $product->quntity}}</td>
        <td>{{ $product->category->name }}</td>
        <td>{{ $product->created_at }}</td>
        <td>
            <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit' , $product->id) }}">
                <i class="fas fa-edit"></i>
            </a>

            <form class="d-inline" action="{{ route('admin.products.destroy' , $product->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Are You Sure ?')">
                <i class="fas fa-trash"></i>
            </button>
            </form> 
        </td>
    </tr>
        
    @endforeach

</table>

<div class="d-flex mt-5 justify-content-center align-items-center">
    {{ $products->links() }}
</div>
@endsection
