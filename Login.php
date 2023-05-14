<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FPF - Login</title>
  <?php
  include_once("partial/library.php");
  ?>
</head>

<body>
  <div class="container-fluid">
    <?php
    include_once("isLogined.php");
    include_once("partial/header.php");
    ?>
    <?php
    $errLogin = "";
    if (isset($_POST["btnLogin"])) {
      $username = $_POST["txtUsername"];
      $password = $_POST["txtPassword"];

      $username = mysqli_real_escape_string($conn, $username);

      $sql = "SELECT * FROM customer WHERE Username = '$username'";
      $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

      if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
        $passwordHash = $row['Password'];

        if (password_verify($password, $passwordHash)) {
          setcookie('username', $row["Username"], time() + (24 * 60 * 60), '/');
          setcookie('admin', $row["State"], time() + (24 * 60 * 60), '/');

          if ($row['State']) {
            echo '<meta http-equiv="refresh" content = "0; URL=manage/order/index.php"/>';
          } else {
            echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
          }
        } else {
          $errLogin = "Password is not correct";
        }
      } else {
        // echo "<script>alert('Username or Password incorrect')</script>";
        $errLogin = "Username is not exist";
      }
    }
    ?>
    <section class="d-flex justify-content-center align-items-center border my-2">
      <div class="row my-4 mx-2">
        <div class="col-md-6 d-flex align-items-center">
          <img src="Image/log.png" class="img-fluid mt-4" alt="Phone image" />
        </div>
        <div class="col-md-6">
          <h2 class="text-center mt-5 d-none d-md-block">
            <strong>Login</strong>
          </h2>
          <div class="text-center">
            <span class="text-danger"><?= $errLogin == "" ? "" : $errLogin; ?></span>
          </div>
          <form id="formLogin" name="formLogin" method="POST" onsubmit="return formValid()">
            <!-- Fill in Username -->
            <div class="form-outline">
              <label class="form-label" for="formUsername" style="font-weight: 700;">Username</label>
              <input type="text" name="txtUsername" id="formUsername" class="form-control form-control-lg" style="font-size: medium;" value='<?php echo isset($_POST["txtUsername"]) ? ($_POST["txtUsername"]) : ""; ?>' />
              <span class="text-danger" id="errorUsername"></span>
            </div>

            <!-- Fill in Password -->
            <div class="form-outline my-3">
              <label class="form-label fw-bold" for="formPassword">Password</label>
              <input type="password" name="txtPassword" id="formPassword" class="form-control form-control-lg" style="font-size: medium;" />
              <span class="text-danger" id="errorPassword"></span>
            </div>

            <div class="d-flex justify-content-around align-items-center mb-3">
              <!-- Checkbox -->
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkBox" />
                <label class="form-check-label" for="checkBox">Remember me
                </label>
              </div>
              <a href="#!">Forgot password?</a>
            </div>

            <!-- Sign in button -->
            <button type="submit" name="btnLogin" id="btnLogin" class="btn btn-primary btn-block mb-3">
              Sign in
            </button>
            <div class="text-center mb-3">
              <p>Don’t have an account? <a href="?page=register"> Sign up </a> </p>
            </div>
          </form>
        </div>
      </div>
    </section>
    <?php
    include_once("partial/footer.php");
    ?>
  </div>
  <script>
    function formValid() {
      f = document.formLogin
      const errorUsername = document.getElementById('errorUsername')
      const errorPassword = document.getElementById('errorPassword')

      if (f.txtUsername.value == "") {
        errorUsername.innerHTML = "Username can't be empty"
        f.txtUsername.focus();
        return false;
      } else {
        errorUsername.innerHTML = ""
      }

      if (f.txtPassword.value == "") {
        errorPassword.innerHTML = "Password can't be empty"
        f.txtPassword.focus();
        return false;
      } else {
        errorPassword.innerHTML = ""
      }

      return true;
    }
  </script>
</body>

</html>