@extends('layouts.default')
@section('title', 'Amar Dokan - Cart')
@section('content');
<main class="container" style="max-width: 900px">
    @if(session("error"))
        <div class="alert alert-error">
            {{session("error")}}
        </div>
    @endif

    <section>
        <div class="row">
            @foreach($cartItems as $cart)
                <div class="col-12">
                    <div class="card mb-3" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{$cart->image}}" class="img-fluid rounded-start" alt="...">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="{{route("product.details", $cart->slug)}}">{{$cart->title}}</a></h5>
                                    <p class="card-text">Price: ${{$cart->price}} | #{{$cart->quantity}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{$cartItems->links()}}
        </div>

        <div>
            <a class="btn btn-primary" href="{{route('checkout.show')}}">Checkout</a>
        </div>
    </section>
</main>
@endsection
