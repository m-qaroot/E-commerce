@extends('admin.master')

@section('title' , 'Edit Product |' . env('APP_NAME'))

@section('content')

<div class="d-flex justify-content-between align-item-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
    <a class="btn btn-primary" href="{{ route('admin.products.index') }}">All Products</a>
</div>

<form action="{{ route('admin.products.update' , $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}">
    </div>

    <div class="mb-3">
        <label for="image">Inmge</label>
        <input id="img-input" type="file" class="form-control" name="image" id="image">
        <img id="img-item" width="70" height="70" src="{{ asset('uploads/images/products/' . $product->image ) }}" alt="">
    </div>

    <div class="mb-3">
        <label for="description">Write Description</label>
        <textarea name="description" rows="5" class="form-control" >{{ $product->description }}</textarea>
    </div>
    
    <div class="mb-3">
        <label for="price">Cost Price</label>
        <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}"/>
    </div>
    
    <div class="mb-3">
        <label for="sale_price">Sale Price</label>
        <input type="number" name="sale_price" id="sale_price" class="form-control" value="{{ $product->sale_price }}"/>
    </div>
    
    <div class="mb-3">
        <label for="quntity">Quantity</label>
        <input type="number" name="quntity" id="quntity" class="form-control" value="{{ $product->quntity }}"/>
    </div>

    <div class="mb-3">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="" disabled selected>--selected--</option>
            @foreach ($categories as $item)
                <option {{ $product->category_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div> 

    <button class="btn btn-info px-5">Update</button>
        
</form>


@endsection


@section('scripts')
<script>
   document.querySelector('#img-item').onclick = function(){
       document.querySelector('#img-input').click();
    }

    document.getElementById('img-input').onchange = function (evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;
    
    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            document.getElementById('img-item').src = fr.result;
        }
        fr.readAsDataURL(files[0]);
    }
    
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
}
</script>
@stop 