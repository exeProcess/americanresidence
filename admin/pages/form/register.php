<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Muslims Ummah Admin | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="#">Muslims Ummah Foundation</a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new Admin</p>

      <form action="../../index.html" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" value="Al Ummah" id="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" id="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" id="rePassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="#">terms</a>
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <!-- <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" id="signup">Register</button>
          </div> -->
          <div class="col-12 tab-loading">
          <button type="submit" class="btn btn-primary btn-block" id="signup">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> -->

      <a href="login.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script src="../../plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<script>
  $("#signup").click((e) => {
    e.preventDefault()
    $("#signup").html('<i class="fa fa-sync fa-spin">')
    let data = {
      username: $("#username").val(),
      email: $("#email").val(),
      password: $("#password").val(),
      rePassword: $("#rePassword").val(),
      signup: true
    }
    if(data.username == " " || data.email == " " || data.password == "" || data.rePassword == " "){
      
      toastr.error("All feilds are required")
      setTimeout(() => {
        $("#signup").html('Register')
      }, 500);
      return;
    }
    setTimeout(() => {
      $.ajax({
      url: '../../../Controller/requestHandler.php',
      method: 'POST',
      data: data,
      success: (res) => {
        let result = JSON.parse(res)
        if(result.status == 200){
          // toastr.success('Successful login')
          // $("#signup").html('Register')
          // location.href = "../../index.php"
          let data = {
      email: $("#email").val(),
      password: $("#password").val(),
      login: true
    }
    if(data.email == " " || data.password == ""){
      $("#login").html('Signin')
      toastr.error("All feilds are required")
      return;
    }
    $.ajax({
      url: '../../../Controller/requestHandler.php',
      method: 'POST',
      data: data,
      success: (res) => {
        let result = JSON.parse(res)
        if(result.status == 200){
          toastr.success('Successful login')
          setTimeout(() => {
            $("#login").html('Signin')
          }, 10);
          location.href = "../../index.php"
        }else{
          $("#login").html('Signin')
          toastr.error(result.text)
        }
        // console.log(res);
        
      }
    })
         
        }
        if(result.status == 500){
          
          toastr.error(result.text)
          $("#signup").html('Register')
        }
        
      }
    })
    }, 100);
    
  })
</script>
</body>
</html>
