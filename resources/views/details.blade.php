@extends('layouts.default')
@section('title', 'Amar Dokan - Home')
@section('content');
<main class="container" style="max-width: 900px">
    <section>
        @if(session()->has("success"))
            <div class="alert alert-success">
                {{session()->get('success')}}
            </div>
        @endif
        @if(session("error"))
            <div class="alert alert-error">
                {{session("error")}}
            </div>
        @endif

        <img src="{{$product->image}}" width="100%">
        <h1>{{$product->title}}</h1>
        <p>${{$product->price}}</p>
        <p>{{$product->description}}</p>
        <a href="{{route("cart.add", $product->id)}}" class="btn btn-success">Add to Cart</a>
    </section>
</main>
@endsection
