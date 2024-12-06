@extends("layouts.auth")
<style>
    html,
    body {
        height: 100%;
    }
    .form-signin {
        max-width: 330px;
        padding: 1rem;
    }

    .form-signin .form-floating:focus-within {
        z-index: 2;
    }

    .form-signin input[type="email"] {
        margin-bottom: -10px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-signin input[type="email"] {
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
@section("style")
@endsection

@section("content")
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{route("register.post")}}">
            @csrf
            <img class="mb-4" src="{{asset("assets/img/logo.png")}}" alt=""
                 width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Please signup</h1>

            <div class="form-floating">
                <input name="name" type="text" class="form-control"
                       id="floatingInputName"
                       placeholder="Enter name">
                <label for="floatingInputName">Enter name</label>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-floating">
                <input name="email" type="email" class="form-control"
                       id="floatingInput"
                       placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-floating" style="margin-bottom: 10px">
                <input name="password" type="password" class="form-control"
                       id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
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

            <button class="btn btn-primary w-100 py-2" type="submit">
                Signup
            </button>
            <a href="{{route("login")}}" class="text-center">
                Already have an account?</a>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017-2024</p>
        </form>
    </main>
@endsection
