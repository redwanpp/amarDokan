@extends('layouts.default')
@section('title', 'Cart')
@section('content');
<main class="container" style="max-width: 900px">
    @if(session()->has("success"))
        <div class="alert alert-success">
            {{session()->get('success')}}
        </div>
    @endif
    <section>
        <div class="text-center">
            <h3 class="text-danger mb-5">Cart is empty</h3>
            <a class="btn btn-primary " href="{{route('home')}}">Add Some Products</a>
        </div>
    </section>
</main>
@endsection
