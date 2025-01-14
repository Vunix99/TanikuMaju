<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">

        <a class="navbar-brand ms-5" href="/beranda">
            <img src="{{ asset('images/logo.svg') }}" style="width: 100px;" alt="TanikuMaju" class="ms-3">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('beranda') ? 'active' : '' }}" href="/beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kalkulasi') ? 'active' : '' }}" href="/kalkulasi">Kalkulasi Tani</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('artikel') ? 'active' : '' }}" href="/artikel">Artikel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('diskusi') || Request::is('diskusi/chat/*') ? 'active' : '' }}" href="/diskusi">Forum Diskusi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('chatai') ? 'active' : '' }}" href="/chatai">Chat Ai</a>
                </li>
            </ul>


            <ul class="navbar-nav me-5 d-none d-md-block">
                <li class="nav-item">
                    <a href="/profil" >
                        <img src="{{ asset('images/profile.png') }}" alt="Profile" style="object-fit: cover; width: 40px; height: 40px; border-radius: 50%;" id="fotoProfil">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>