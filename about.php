<?php
include_once("connectDB.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NDQ - About Us</title>
  <?php
  include_once("partial/library.php");
  ?>
</head>

<body>
  <div class="container-fluid">
    <?php
    include_once("partial/header.php");
    ?>
    <section class="my-2">
      <div style="background-color: #f3f3f3">
        <div class="d-flex">
          <div class="card card-registration m-md-5 m-2">
            <div class="row">
              <div class="col-xl-6">
                <div class="m-2 m-md-5 text-center">
                  <div class="m-md-5 m-5">
                    <h3>
                      ABOUT NDQ STORE
                    </h3>
                  </div>
                  <div class="m-5">
                    <div class="">
                      Celebrating Beauty and Style
                    </div>
                  </div>
                  <div class="my-5">
                    <div class="">
                      NDQ Store was founded by a group of like-minded fashion devotees, determined to deliver style to shoppers worldwide.
                      Our store offers a huge collection of goods at affordable prices, and our payment and shipping options are simply unmatched.
                      What are you waiting for? Start shopping online today and find out more about what makes us so special.
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6">
                <div class="my-md-5">
                  <img src="Image/clothes.png" height="80%" width="100%">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php
    include_once("partial/footer.php");
    ?>
  </div>
  <?php
  include_once("partial/script.php");
  ?>
</body>

</html>