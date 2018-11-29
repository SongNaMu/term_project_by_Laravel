<!doctype html>
<html>
  <head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    @yield('head')
    <?php
    $message = session('message');
    if(isset($message)){
    ?>
    <script>
      alert("<?=$message?>");
    </script>
    <?php
  }
  session()->forget('message');
    ?>
  </head>
  <body>
    <header>
      <?php
        $id = session('id');
      ?>

      <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
            <h5 class="my-0 mr-md-auto font-weight-normal"><a style="text-decoration:none" href="/board">Song's Board</a></h5>
            <nav class="my-2 my-md-0 mr-md-3">
              <a class="p-2 text-dark" href="#">Features</a>
              <a class="p-2 text-dark" href="#">Enterprise</a>
              <a class="p-2 text-dark" href="#">Support</a>
              <a class="p-2 text-dark" href="#">Pricing</a>
            </nav>
      <?php if(isset($id)){ ?>
            <a class="btn btn-lutline-primary" href="/logout">Logout</a>
      <?php }else{ ?>
      			<a class="btn btn-outline-primary" href="/register">Sign Up</a>
            <a class="btn btn-outline-primary" href="/login">Login</a>
      <?php } ?>
          </div>
    </header>

    @yield('content')
    @yield('footer')
  </body>
</html>
