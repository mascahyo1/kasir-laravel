<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kasir</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-3">
            <div class="container">
              <a class="navbar-brand" href="#">Kasir</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/supplier">Supplier</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/barang">Barang</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/barang-opname">Stok Opname</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/pembelian">Pembelian</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/penjualan">Penjualan</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/user">User</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/pengaturan">Pengaturan</a>
                  </li>
                  @if (Auth::check())
                    <li class="nav-item">
                      <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">Logout</button>
                      </form>
                    </li>
                  @endif

                </ul>
              </div>
            </div>
          </nav>
          
        @yield('content')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
              $('.select2, .form-select').select2({
                theme: 'bootstrap-5',
              });
            });
        </script>
    </body>
</html>