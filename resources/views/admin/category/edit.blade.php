@extends('admin.master')

@section('title' , 'Edit Category |' . env('APP_NAME'))

@section('content')

<div class="d-flex justify-content-between align-item-center mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
    <a class="btn btn-primary" href="{{ route('admin.categories.index') }}">All Categories</a>
</div>

<form action="{{ route('admin.categories.update' , $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="mb-3">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}">
    </div>

    <div class="mb-3">
        <label for="image">Inmge</label>
        <input id="img-input" type="file" class="form-control" name="image" id="image">
        <img id="img-item" width="70" height="70" src="{{ asset('uploads/images/' . $category->image ) }}" alt="">
    </div>

    <div class="mb-3">
        <label for="parent_id">Parent</label>
        <select name="parent_id" id="parent_id" class="form-control">
            <option value="" disabled selected>--selected--</option>
            @foreach ($categories as $item)
                <option {{ $category->parent_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
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