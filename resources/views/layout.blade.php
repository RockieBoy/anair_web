<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Aplikasi Rental Kendaraan</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.5.0/css/all.min.css" integrity="sha512-QfDd74mlg8afgSqm3Vq2Q65e9b3xMhJB4GZ9OcHDVy1hZ6pqBJPWWnMsKDXM7NINoKqJANNGBuVRIpIJ5dogfA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ asset('Assets/vendor/fontawesome-free/css/fontawesome.css') }}" rel="stylesheet" type="text/css">

  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.min.js" integrity="sha512-7rusk8kGPFynZWu26OKbTeI+QPoYchtxsmPeBqkHIEXJxeun4yJ4ISYe7C6sz9wdxeE1Gk3VxsIWgCZTc+vX3g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="{{ asset('Assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
  
  <link href="{{ asset('Assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Bagian Pembuka Judul Template -->
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
		<img src="">
        </div>
        <div class="sidebar-brand-text mx-3">Anair</div>
      </a>
	<!-- Bagian Penutup Judul Template -->

      <!-- Divider -->
      <hr class="sidebar-divider my-0">


	      <!-- Bagian Pembuka Menu Template -->
      @if(auth()->user()->role !== 'superadmin')
      <!-- Nav Item - Dashboard -->
      <li class="nav-item {{ request()->is('welcome') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      @endif

      @if(auth()->user()->role === 'superadmin')
      <!-- Admin Only: User Management -->
      <li class="nav-item {{ request()->is('admin*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.index') }}">
          <i class="fas fa-fw fa-users"></i>
          <span>Kelola Pengguna</span></a>
      </li>
      @endif

      @if(auth()->user()->role === 'admin')
      <!-- Admin Operations -->
      <li class="nav-item {{ request()->is('produk*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('produk.index') }}">
          <i class="fas fa-fw fa-table"></i>
          <span>Tambah Produk</span></a>
      </li>

      <li class="nav-item {{ request()->is('stok*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('stok.index') }}">
          <i class="fas fa-fw fa-boxes"></i>
          <span>Stok Barang (Monitoring)</span></a>
      </li>
      @endif

      @if(in_array(auth()->user()->role, ['admin', 'karyawan']))
      <!-- Operational Reports -->
      <li class="nav-item {{ request()->is('laporan_produksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('laporan_produksi.index') }}">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Laporan Produksi</span></a>
      </li>

      <li class="nav-item {{ request()->is('transaksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('transaksi.index') }}">
          <i class="fas fa-fw fa-truck"></i>
          <span>Transaksi (Barang Keluar)</span></a>
      </li>
      @endif

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->


    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Selamat Datang,{{ Auth::user()->name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#" onclick="confirmLogout(event)">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                
              </div>
            </li>
          </ul>
        </nav>

        <div class="container-fluid">

            @yield('content')

        </div>

      </div>
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Aplikasi Rental Kendaraan</span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <!-- Bootstrap core JavaScript-->
  <script src="{{ asset('Assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('Assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{ asset('Assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{ asset('Assets/js/sb-admin-2.min.js') }}"></script>
	
  <script src="{{ asset('Assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('Assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  
  <script src="{{ asset('Assets/js/demo/datatables-demo.js') }}"></script>
	
  <!-- Page level plugins -->
  <script src="{{ asset('Assets/vendor/chart.js/chart.min.js') }}"></script>

  <!-- Page level custom scripts -->
  <script src="{{ asset('Assets/js/demo/chart-area-demo.js') }}"></script>
  <script src="{{ asset('Assets/js/demo/chart-pie-demo.js') }}"></script>

<script src="{{asset('Assets/js/chartjs/Chart.js')}}"></script>
<script>
    function confirmLogout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Siap Untuk Logout?',
            text: "Tekan Logout untuk keluar dari akun Anda",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Logout',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        })
    }
</script>
</body>
</html>
