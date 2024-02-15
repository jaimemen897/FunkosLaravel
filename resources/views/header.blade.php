<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img alt="Logo" class="d-inline-block align-text-top" src="{{ asset('images/favicon.png') }}" width="30"
                     height="30">
                Inicio
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('funkos.index') }}">Funkos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category.index') }}">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('funkos.store') }}">Nuevo funko</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    {{ auth()->user()->name ?? 'Invitado' }}
                </span>
            </div>
        </div>
    </nav>
</header>
