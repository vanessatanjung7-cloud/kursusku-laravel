<nav class="navbar navbar-expand-xl bg-dark navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">KursusKu</a>

        <button class="navbar-toggler ms-auto" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Buka navigasi">
            <span aria-hidden="true">&#9776;</span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('home')]) href="{{ route('home') }}"
                       @if (request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('courses.catalog')]) href="{{ route('courses.catalog') }}"
                       @if (request()->routeIs('courses.catalog')) aria-current="page" @endif>Daftar Kursus</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('courses.index', 'courses.show', 'courses.edit')]) href="{{ route('courses.index') }}"
                       @if (request()->routeIs('courses.index', 'courses.show', 'courses.edit')) aria-current="page" @endif>Kelola Kursus</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('courses.create')]) href="{{ route('courses.create') }}"
                       @if (request()->routeIs('courses.create')) aria-current="page" @endif>Tambah Kursus</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('participants.*')]) href="{{ route('participants.index') }}"
                       @if (request()->routeIs('participants.*')) aria-current="page" @endif>Peserta</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('enrollments.create')]) href="{{ route('enrollments.create') }}"
                       @if (request()->routeIs('enrollments.create')) aria-current="page" @endif>Tambah Enrollment</a>
                </li>
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('enrollments.index')]) href="{{ route('enrollments.index') }}"
                       @if (request()->routeIs('enrollments.index')) aria-current="page" @endif>Laporan Enrollment</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
