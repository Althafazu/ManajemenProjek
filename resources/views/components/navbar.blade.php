<nav class="navbar bg-body-tertiary shadow-sm">
    <div class="container-fluid justify-content-between">
        <div class="d-flex align-items-left">
            <img src="{{ asset('assets/images/logo.png') }}" alt="logo-polman-astra" class="navbar-brand" style="height: 70px;">
        </div>
        <div class="d-flex ms-auto align-items-center">
            <button class="btn btn-outline-secondary d-xl-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                ☰
            </button>
            
            <div class="text-end">
                @if (auth()->check())
                <p class="fw-bold mx-0 my-0">
                    {{ auth()->user()->name }} ({{ auth()->user()->roleNama }})
                </p>
                @endif
            </div>
        </div>
    </div>
</nav>
