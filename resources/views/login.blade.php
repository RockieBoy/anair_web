<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>LOGIN</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('Assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('Assets/css/sb-admin-2.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary d-flex align-items-center min-vh-100">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-8 col-md-9">

        <div class="card o-hidden border-0 shadow-lg">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
                <div class="p-5">
				<div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 10rem;" src="{{asset('Assets/img/logo.jpeg')}}" alt="">
                  </div>
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"><b>PT ADITYA TIRTA ABADI UTAMA</b></h1>
                  </div>

                  <form class="user" method="POST" action="/login">
                    @csrf
                    <div class="form-group">
                      <input type="text" name="username" class="form-control form-control-user" placeholder="Username" required>
                    </div>
					
                    <div class="form-group">
                      <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                    </div>

                    
                    <center>
                      <input type="submit" class="btn btn-primary btn-user btn-block" id="btn_login" value="Sign In" />
                    </center>
                    
                    
                  </form>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('Assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('Assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('Assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('Assetsjs/sb-admin-2.min.js')}}"></script>

</body>

</html>
