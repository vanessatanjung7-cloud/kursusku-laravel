<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            KursusKu
        </a>

        <button class="navbar-toggler ms-auto" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Buka navigasi">
            <span aria-hidden="true">☰</span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('courses.index') }}">Kursus</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('enrollments.index') }}">
                        Enrollment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('enrollments.create') }}">
                        Tambah Enrollment
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
