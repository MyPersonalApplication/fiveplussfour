<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FPF - Register</title>
  <?php
  include_once("partial/library.php");
  ?>
  <style>
    .col-md-6 {
      padding: 0 5px 0 0px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <?php
    include_once("isLogined.php");
    include_once("partial/header.php");
    ?>
    <?php
    $errorRegister = "";
    if (isset($_POST["btnSignup"])) {
      $username = $_POST["txtUsername"];
      $password = $_POST["txtPassword"];
      $firstname = $_POST["txtFirstname"];
      $lastname = $_POST["txtLastname"];
      $year = $_POST["slYear"];
      $month = $_POST["slMonth"];
      $day = $_POST["slDay"];
      if (isset($_POST["cbSex"])) {
        $sex = $_POST["cbSex"];
      }
      $phone = $_POST["txtTelephone"];
      $email = $_POST["txtEmail"];
      $address = $_POST["txtAddress"];

      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $sq = "SELECT * FROM customer where Username = '$username'";
      $result = mysqli_query($conn, $sq);
      if (mysqli_num_rows($result) == 0) {
        mysqli_query($conn, "INSERT INTO customer (UserName, Password, CustName, CustSex, CustPhone, CustMail, CustAddress, Birthday, State)
                            VALUES ('$username', '$hashedPassword', '$firstname $lastname', '$sex', '$phone', '$email', '$address', '$year-$month-$day', 0)");
        echo ("<script>
                Swal.fire(
                  'Success',
                  'You registered successfully!!!',
                  'success'
                ).then((result) => {
                  window.location.href = 'login.php';
                })
              </script>");
      } else {
        $errorRegister = "Username already exists";
      }
    }
    ?>
    <div class="my-2">
      <section class="d-flex justify-content-center align-items-center h-100 border">
        <div class="row g-0">
          <div class="col-lg-6 d-none d-lg-block">
            <img src="Image/register.jpg" width="100%">
          </div>
          <div class="col-lg-6 my-4" style="background-color: #f3f3f3;">
            <form id="formRegister" name="formRegister" method="POST" class="card-body p-md-5 text-black" onsubmit="return formValid()">
              <h3 class="mb-4 text-uppercase" align="center">
                <strong>Customer registration</strong>
              </h3>
              <div class="text-center mb-3">
                <span class="text-danger"><?= $errorRegister == "" ? "" : $errorRegister; ?></span>
              </div>

              <div class="form-outline mb-2">
                <input type="text" id="txtUsername" class="form-control" name="txtUsername" placeholder="Username(*)" value='<?php echo isset($_POST["txtUsername"]) ? ($_POST["txtUsername"]) : ""; ?>' />
                <label class="form-label" for="txtUsername"></label>
                <span class="text-danger" id="errorUsername"></span>
              </div>

              <div class="form-outline mb-2">
                <input type="password" id="txtPassword" class="form-control" name="txtPassword" placeholder="Password(*)" />
                <label class="form-label" for="txtPassword"></label>
                <span class="text-danger" id="errorPassword"></span>
              </div>

              <div class="form-outline mb-2">
                <input type="password" id="txtConfirmPass" class="form-control" name="txtConfirmPass" placeholder="Confirm Password(*)" />
                <label class="form-label" for="txtConfirmPass"></label>
                <span class="text-danger" id="errorConfirmPassword"></span>
              </div>

              <div class="row mb-2">
                <div class="col-md-6">
                  <div class="form-outline">
                    <input type="text" id="txtFirstname" class="form-control" name="txtFirstname" placeholder="First name(*)" value='<?php echo isset($_POST["txtFirstname"]) ? ($_POST["txtFirstname"]) : ""; ?>' />
                    <label class="form-label" for="txtFirstname"></label>
                    <span class="text-danger" id="errorFirstname"></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-outline">
                    <input type="text" id="txtLastname" class="form-control" name="txtLastname" placeholder="Last name(*)" value='<?php echo isset($_POST["txtLastname"]) ? ($_POST["txtLastname"]) : ""; ?>' />
                    <label class="form-label" for="txtLastname"></label>
                    <span class="text-danger" id="errorLastname"></span>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <div class="d-md-flex justify-content-start align-items-center">
                  <h6 class="mb-3 mb-lg-0 me-4">Gender:</h6>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio" name="cbSex" id="MaleGender" value="Male" />
                    <label class="form-check-label" for="femaleGender">Male</label>
                  </div>

                  <div class="form-check form-check-inline mb-0 me-4">
                    <input class="form-check-input" type="radio" name="cbSex" id="FemaleGender" value="Female" />
                    <label class="form-check-label" for="maleGender">Female</label>
                  </div>
                </div>
                <span class="text-danger" id="errorGender"></span>
              </div>

              <div class="mb-4">
                <div class="d-md-flex justify-content-start align-items-center">
                  <h6 class="mb-md-0 me-3 mb-3">Birthday:</h6>
                  <div class="input-group">
                    <span class="col-md-4 pb-md-0 col-12 pb-2">
                      <select name="slYear" id="slYear" class="form-control">
                        <option value="0">Choose Year</option>
                        <?php
                        for ($i = 1970; $i <= 2020; $i++) {
                          echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                        ?>
                      </select>
                    </span>
                    <span class="col-md-4 py-md-0 col-12 py-2">
                      <select name="slMonth" id="slMonth" class="form-control">
                        <option value="0">Choose Month</option>
                        <?php
                        for ($i = 1; $i <= 12; $i++) {
                          echo "<option value='" . $i . "'>" . $i . "</option>";
                        }

                        ?>
                      </select>
                    </span>
                    <span class="col-md-4 pt-md-0 col-12 pt-2">
                      <select name="slDay" id="slDay" class="form-control">
                        <option value="0">Choose Day</option>
                        <?php
                        for ($i = 1; $i <= 31; $i++) {
                          echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                        ?>
                      </select>
                    </span>
                  </div>

                </div>
                <span class="text-danger" id="errorBirthday"></span>
              </div>

              <div class="form-outline mb-2">
                <input type="text" id="txtTelephone" class="form-control" name="txtTelephone" placeholder="Telephone(*)" value='<?php echo isset($_POST["txtTelephone"]) ? ($_POST["txtTelephone"]) : ""; ?>' />
                <label class="form-label" for="txtTelephone"></label>
                <span class="text-danger" id="errorTelephone"></span>
              </div>

              <div class="form-outline mb-2">
                <input type="text" id="txtEmail" class="form-control" name="txtEmail" placeholder="Email(*)" value='<?php echo isset($_POST["txtEmail"]) ? ($_POST["txtEmail"]) : ""; ?>' />
                <label class="form-label" for="txtEmail"></label>
                <span class="text-danger" id="errorEmail"></span>
              </div>

              <div class="form-outline mb-2">
                <input type="text" id="txtAddress" class="form-control" name="txtAddress" placeholder="Address(*)" value='<?php echo isset($_POST["txtAddress"]) ? ($_POST["txtAddress"]) : ""; ?>' />
                <label class="form-label" for="txtAddress"></label>
                <span class="text-danger" id="errorAddress"></span>
              </div>

              <div class="d-flex justify-content-end pt-0">
                <button class="btn btn-light btn-lg" name="btnReset" onclick="window.location='register.php'">
                  Reset all
                </button>
                <button type="submit" class="btn btn-dark btn-lg ms-2" name="btnSignup">
                  Sign up
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
    <?php
    include_once("partial/footer.php");
    ?>
  </div>
  <?php
  include_once("partial/script.php");
  ?>
  <script>
    function hasWhiteSpace(s) {
      return (/\s/).test(s);
    }

    function formValid() {
      f = document.formRegister
      var validname = /^[A-Za-z]+|(\s)$/;
      var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
      var phone_pattern = /^(\(0\d{1,3}\)\d{7})|(0\d{9,10})$/;
      var email_pattern = /^[a-zA-Z]\w*(\.\w+)*\@\w+(\.\w{2,3})+$/;

      const errorUsername = document.getElementById('errorUsername')
      const errorPassword = document.getElementById('errorPassword')
      const errorConfirmPassword = document.getElementById('errorConfirmPassword')
      const errorFirstname = document.getElementById('errorFirstname')
      const errorLastname = document.getElementById('errorLastname')
      const errorGender = document.getElementById('errorGender')
      const errorBirthday = document.getElementById('errorBirthday')
      const errorTelephone = document.getElementById('errorTelephone')
      const errorEmail = document.getElementById('errorEmail')
      const errorAddress = document.getElementById('errorAddress')

      // Username
      if (f.txtUsername.value == "" || format.test(f.txtUsername.value) || hasWhiteSpace(f.txtUsername.value)) {
        errorUsername.innerHTML = "Username can't be empty and special character, please enter again"
        f.txtUsername.focus();
        return false;
      } else {
        errorUsername.innerHTML = ""
      }
      // Password
      if (f.txtPassword.value == "") {
        errorPassword.innerHTML = "Password can't be empty, please enter again"
        f.txtPassword.focus();
        return false;
      } else if (f.txtPassword.value.length <= 5) {
        errorPassword.innerHTML = "Password must be greater than 5 chars, please enter again"
        f.txtPassword.focus();
        return false;
      } else {
        errorPassword.innerHTML = ""
      }
      // Confirm Pass
      if (f.txtConfirmPass.value == "") {
        errorConfirmPassword.innerHTML = "Confirm Password can't be empty, please enter again"
        f.txtConfirmPass.focus();
        return false;
      } else if (f.txtPassword.value != f.txtConfirmPass.value) {
        errorConfirmPassword.innerHTML = "Password and Confirm Pass do not match, please enter again"
        f.txtConfirmPass.focus();
        return false;
      } else {
        errorConfirmPassword.innerHTML = ""
      }
      // First name
      if (f.txtFirstname.value == "" || format.test(f.txtFirstname.value) || validname.test(f.txtFirstname.value) == false) {
        errorFirstname.innerHTML = "Invalid first name. Please enter again"
        f.txtFirstname.focus();
        return false;
      } else {
        errorFirstname.innerHTML = ""
      }
      // Last name
      if (f.txtLastname.value == "" || format.test(f.txtLastname.value) || validname.test(f.txtLastname.value) == false) {
        errorLastname.innerHTML = "Invalid last name. Please enter again"
        f.txtLastname.focus();
        return false;
      } else {
        errorLastname.innerHTML = ""
      }
      // Gender
      if (f.cbSex.value == 0) {
        errorGender.innerHTML = "Please choose your sex"
        return false;
      } else {
        errorGender.innerHTML = ""
      }
      // Birthday
      if (f.slYear.value == 0 || f.slMonth.value == 0 || f.slDay.value == 0) {
        errorBirthday.innerHTML = "Invalid Birthday, please enter again"
        return false;
      } else {
        errorBirthday.innerHTML = ""
      }
      // Telephone
      if (phone_pattern.test(f.txtTelephone.value) == false) {
        errorTelephone.innerHTML = "Invalid phone number, please enter again"
        f.txtTelephone.focus();
        return false;
      } else {
        errorTelephone.innerHTML = ""
      }
      // Email
      if (email_pattern.test(f.txtEmail.value) == false) {
        errorEmail.innerHTML = "Invalid email address, please enter again"
        f.txtEmail.focus();
        return false;
      }
      // Address
      if (f.txtAddress.value == "") {
        errorAddress.innerHTML = "Address can't be empty, please enter again"
        f.txtAddress.focus();
        return false;
      } else {
        errorAddress.innerHTML = ""
      }
      return true;
    }
  </script>
</body>

</html>