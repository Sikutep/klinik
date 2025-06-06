<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <style>
      body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }
      main {
        flex: 1;
      }
      .sidebar {
        min-height: 100vh;
        background-color: #f8f9fa;
        padding-top: 1rem;
      }


    </style>
  </head>
  <body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">KlinikApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 sidebar">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Pasien</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Antrian</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Transaksi</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Rekam Medis</a>
            </li>
          </ul>
        </div>

        {{-- Main Content --}}
        <main class="col-md-10 p-4">
          @yield('content')
        </main>

      </div>
    </div>

    {{-- Footer --}}
    <footer class="bg-light text-center py-3">
      <span class="text-muted">© {{ date('Y') }} KlinikApp. All rights reserved.</span>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  </body>
</html>
