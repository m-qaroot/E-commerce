@extends('site.master')
@section('title' , 'Cart' . ' | ' . env('APP_NAME'))

@section('content')

@php
    use App\Models\Cart;
@endphp
<body>
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{ route('site.index') }}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
                {{-- @if (session('msg'))
                    <div class="alert alert-{{ session('type') }}">{{ session('msg') }}</div>    
                @endif --}}
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Cart Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">            
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $total = 0;
                            $subTotal = 0;
                            $carts = Cart::with('product')->where('user_id' , Auth::id())->get();
                        @endphp
                        @foreach ($carts as $cart)
                        @php
                            $total += $cart->price * $cart->qty;
                            $subTotal += $total;
                        @endphp
                        <tr>
                                <td class="align-middle"><img src="{{ asset('uploads/images/products/' . $cart->product->image) }}" alt="" style="width: 50px;"> {{ $cart->product->name }}</td>
                                <td class="align-middle">${{ $cart->price }}</td>
                                <td class="align-middle">
                                    {{ $cart->qty }}
                                </td>
                                <td class="align-middle">${{ number_format($total,2) }}</td>
                                <td class="align-middle">
                                    <form action="{{ route('remove_cart' , $cart->id) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">{{ number_format($subTotal,2) }}</h5>
                        </div>
                        <button class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->


@stop
