<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Add Category</title>

    <?php
    include_once("../library.php");
    ?>
</head>

<body>
    <div class="container-fluid">
        <section class="row">
            <?php
            include_once("../../auth_admin.php");
            include_once("../nav.php");
            ?>
            <?php
            $errAddCategory = "";
            if (isset($_POST["btnAdd"])) {
                $id = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatID"]));
                $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatName"]));
                $des = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatDesc"]));
                $pic = $_FILES["catImage"];

                if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                    if ($pic["size"] <= 5242880) {
                        $sq = "SELECT * FROM category where CatID = '$id' or CatName = '$name'";
                        $result = mysqli_query($conn, $sq);
                        if (mysqli_num_rows($result) == 0) {
                            copy($pic['tmp_name'], "../../Category/" . $pic['name']);
                            $filePic = $pic['name'];
                            $picturecategory = htmlspecialchars(mysqli_real_escape_string($conn, $filePic));
                            mysqli_query($conn, "INSERT INTO category (CatID, CatName, CatDesc, Cat_image) VALUES ('$id', '$name', '$des', '$picturecategory')");
                            echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
                        } else {
                            $errAddCategory = "Duplicate category ID or Name";
                        }
                    } else {
                        $errAddCategory = "Size of image too big";
                    }
                } else {
                    $errAddCategory = "Image format is not correct";
                }
            }
            ?>

            <div class="col-lg-10 col-md-9 col-12">
                <h1 class="text-center mb-4">Adding Category</h1>
                <div class="text-center mb-4">
                    <span class="text-danger">
                        <h5><?= $errAddCategory == "" ? "" : $errAddCategory; ?></h5>
                    </span>
                </div>
                <form id="formAddcategory" name="formAddcategory" method="post" enctype="multipart/form-data" onsubmit="return formValid()">
                    <div class="form-outline mb-2">
                        <input type="text" name="txtCatID" id="txtCatID" class="form-control form-control-lg" placeholder="Category ID (*)" style="font-size: medium;" value='<?php echo isset($_POST["txtCatID"]) ? ($_POST["txtCatID"]) : ""; ?>' />
                        <label class="form-label" for="txtCatID"></label>
                        <span class="text-danger" id="errorCatID"></span>
                    </div>

                    <div class="form-outline mb-2">
                        <input type="text" name="txtCatName" id="txtCatName" class="form-control form-control-lg" placeholder="Category Name (*)" style="font-size: medium;" value='<?php echo isset($_POST["txtCatName"]) ? ($_POST["txtCatName"]) : ""; ?>' />
                        <label class="form-label" for="txtCatName"></label>
                        <span class="text-danger" id="errorCatName"></span>
                    </div>

                    <div class="form-outline mb-2">
                        <input type="text" name="txtCatDesc" id="txtCatDesc" class="form-control form-control-lg" placeholder="Category Description (*)" style="font-size: medium;" value='<?php echo isset($_POST["txtCatDesc"]) ? ($_POST["txtCatDesc"]) : ""; ?>' />
                        <label class="form-label" for="txtCatDesc"></label>
                        <span class="text-danger" id="errorCatDesc"></span>
                    </div>

                    <div class="form-outline mb-2">
                        <input type="file" name="catImage" id="catImage" class="form-control" value="" />
                        <label for="catImage" class="form-label"></label>
                        <span class="text-danger" id="errorCatImage"></span>
                    </div>

                    <div class="form-ouline text-center">
                        <input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
                        <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='./'" />
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        function formValid() {
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
            f = document.formAddcategory

            const errorCatID = document.getElementById('errorCatID')
            const errorCatName = document.getElementById('errorCatName')
            const errorCatDesc = document.getElementById('errorCatDesc')
            const errorCatImage = document.getElementById('errorCatImage')

            // Category ID
            if (format.test(f.txtCatID.value)) {
                errorCatID.innerHTML = "Category ID invalid"
                f.txtCatID.focus();
                return false;
            } else if (f.txtCatID.value == "") {
                errorCatID.innerHTML = "Please enter category ID"
                return false;
            } else {
                errorCatID.innerHTML = ""
            }
            // Category Name
            if (f.txtCatName.value == "") {
                errorCatName.innerHTML = "Please enter category name"
                return false;
            } else if (format.test(f.txtCatName.value)) {
                errorCatName.innerHTML = "Category name can't contain special character"
                f.txtCatName.focus();
                return false;
            } else {
                errorCatName.innerHTML = ""
            }
            // Category Description
            if (format.test(f.txtCatDesc.value)) {
                errorCatDesc.innerHTML = "Category description can't contain special character"
                f.txtCatDesc.focus();
                return false;
            } else if (f.txtCatDesc.value == "") {
                errorCatDesc.innerHTML = "Please enter category description"
                f.txtCatDesc.focus();
                return false;
            } else {
                errorCatDesc.innerHTML = ""
            }
            // Category Image
            if (f.catImage.value == "") {
                errorCatImage.innerHTML = "You must select the picture"
                return false;
            } else {
                errorCatImage.innerHTML = ""
            }
            return true;
        }
    </script>
</body>

</html>