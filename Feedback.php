<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Feedback</title>

    <?php
    include_once("partial/library.php");
    ?>
</head>

<body>
    <div class="container-fluid">
        <?php
        include_once("auth_user.php");
        include_once("partial/header.php");
        ?>
        <?php
        if (isset($_POST['btnSendfeedback'])) {
            $fid = $_POST['txtid'];
            $us = $_POST['txtusername'];
            $content = $_POST['txtmessage'];

            mysqli_query($conn, "INSERT INTO feedback (Content, sendDate, Username, ProID) VALUES ('$content', '" . date('Y-m-d H:i:s') . "', '$us', '$fid')");
            echo ("<script>
                            Swal.fire(
                                'Feedback',
                                'Send feedback successfully',
                                'success'
                            ).then((result) => {
                                window.location.href = 'purchase-history.php';
                            })
                        </script>");
        }
        ?>
        <section class="my-2 border" style="background-color: #f3f3f3">
            <div class="m-md-5 m-3 card">
                <!--Section heading-->
                <h2 class="font-weight-bold text-center py-3">
                    Feedback
                </h2>
                <!--Section description-->
                <p class="text-center w-responsive mx-3 mx-md-5 mb-4">
                    Do you have any feedback? Please do not hesitate to contact us directly.
                </p>

                <form id="feedbackform" name="feedbackform" method="POST" class="mx-md-5 m-3" onsubmit="return formValid()">
                    <!--Grid row-->
                    <div class="row mb-4">
                        <!--Grid column-->
                        <div class="col-md-6 ps-2">
                            <input type="hidden" name="txtid" value="<?= $id ?>">
                            <?php
                            $username = $_COOKIE['username'];
                            $sqlUser = "SELECT CustName FROM customer WHERE Username = '$username'";
                            $resUser = mysqli_query($conn, $sqlUser) or die('Invalid query: ' . mysqli_error($conn));
                            if (mysqli_num_rows($resUser) > 0) {
                                $rowUser = mysqli_fetch_array($resUser, MYSQLI_ASSOC);
                            ?>
                                <input type="text" id="txtname" name="txtname" class="form-control" placeholder="Your name (*)" value="<?= $rowUser['CustName'] ?>" />
                            <?php
                            } else {
                            ?>
                                <input type="text" id="txtname" name="txtname" class="form-control" placeholder="Your name (*)" value="" />
                            <?php
                            }
                            ?>
                        </div>
                        <!--Grid column-->

                        <!--Grid column-->
                        <div class="col-md-6 pe-2">
                            <input type="text" id="txtusername" name="txtusername" class="form-control" placeholder="Username (*)" value="<?= $_COOKIE['username'] ?>" />
                        </div>
                        <!--Grid column-->
                    </div>
                    <!--Grid row-->
                    <?php
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT ProName FROM product WHERE ProID = '$id'";
                        $res = mysqli_query($conn, $sql);
                        if (!$res) {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        $row = mysqli_fetch_array($res, MYSQLI_ASSOC)
                    ?>
                        <div class="mx-2">
                            <input type="hidden" name="txtid" value="<?= $id ?>">
                            <!--Grid row-->
                            <input type="text" id="txtproduct" name="txtproduct" class="form-control" placeholder="Product (*)" value="<?= $row['ProName'] ?>" />
                            <label for="product" class=""></label>
                            <!--Grid row-->

                            <!--Grid row-->
                            <textarea type="text" id="txtmessage" name="txtmessage" rows="3" class="form-control md-textarea" placeholder="Your feedback (*)"></textarea>
                            <label for="message"></label>
                            <!--Grid row-->
                            <div class="form-ouline text-center">
                                <input type="submit" class="btn btn-primary" name="btnSendfeedback" id="btnSendfeedback" value="Send Feedback" />
                                <input type="button" class="btn btn-primary" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='?page=viewdetail&id=<?= $id ?>'" />
                            </div>
                        </div>
                    <?php
                    } else {
                        echo '<meta http-equiv="refresh" content = "0; URL=purchase-history.php"/>';
                    }
                    ?>
                </form>
            </div>
        </section>
        <?php
        include_once("partial/footer.php");
        ?>
    </div>
    <?php
    include_once("partial/script.php");
    ?>
    <script>
        function formValid() {
            f = document.feedbackform;

            if (f.txtname.value == "" || f.txtusername.value == "" || f.txtproduct.value == "" || f.txtmessage.value == "") {
                alert("Enter fileds with marks(*), please");
                f.txtmessage.focus();
                return false;
            }
            return true;
        }
    </script>
</body>

</html>