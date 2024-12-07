@extends('layouts.default')
@section('title', 'Amar Dokan - Home')
@section('content');
    <main class="container" style="max-width: 900px">
        <section>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-12 col-md-6 col-lg-3 ">
                        <div class="card p-2 shadow-sm">
                            <img src="{{$product->image}}" width="100%">
                            <div>
                                <a
                                    style="text-decoration: none; color: #000; font-weight: bold"
                                    href="{{route("product.details", $product->slug)}}">
                                        {{$product->title}}
                                </a> |
                                <span>${{$product->price}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                {{$products->links()}}
            </div>
        </section>
    </main>
@endsection
