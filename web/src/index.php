<?php  
  include('../config.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">HP Challenge</a>
    </nav>

    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-xs-12">

          <?php
            if($_GET['sent'] == 1) {
            ?>
              <div class="alert alert-success" role="alert">
                <?php echo "Login successful!"; ?>
              </div>
            <?php
            } else if($_GET['sent'] == 2) {
            ?>
              <div class="alert alert-warning" role="alert">
                <?php echo "Username and password do not match"; ?>
              </div>
            <?php
            }
          ?>

          <div class="card">
            <div class="card-header">
              Login with your account
            </div>
            <div class="card-body">

              <form action="<?php echo API_LOGIN_URL; ?>" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="text" name="username" class="form-control" id="usernameInput" aria-describedby="emailHelp" placeholder="Enter username">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group text-right">
                  <a href="forgot.php" class="">Forgot your password?</a>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>