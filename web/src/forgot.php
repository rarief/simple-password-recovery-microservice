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

    <title>Forgot Password</title>

    <script>
      function buttonPress() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            alert('It works!');
          }
        };
        xmlhttp.open('GET', '<?php echo API_HOME_URL ?>', true);
        xmlhttp.send();
      }
    </script>
  </head>
  <body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">HP Challenge</a>
    </nav>

    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-xs-12">

          <a href="/" class="btn btn-link">< Back</a>

          <?php
            if($_GET['sent'] == 1) {
            ?>
              <div class="alert alert-success" role="alert">
                <?php echo "Your password has been sent to your email."; ?>
              </div>
            <?php
            } else if($_GET['sent'] == 2) {
            ?>
              <div class="alert alert-warning" role="alert">
                <?php echo "Your username is not registered."; ?>
              </div>
            <?php
            }
          ?>

          <div class="card">
            <div class="card-header">
              Forgot your password
            </div>
            <div class="card-body">
              <form action="<?php echo API_FORGOT_PASSWORD_URL; ?>" method="post">
                <div class="form-group">
                  <label for="usernameInput">Username</label>
                  <input type="text" name="username" class="form-control" id="usernameInput" aria-describedby="emailHelp" placeholder="Enter username">
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