<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{asset("assets/img/logo.png")}}" height="50px" width="70px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route("home")}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("cart.show")}}">Cart</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{route("logout")}}">Logout</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
