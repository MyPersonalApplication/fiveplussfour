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
            if (isset($_POST["btnAdd"])) {
                $id = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatID"]));
                $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatName"]));
                $des = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatDesc"]));
                $pic = $_FILES["catImage"];

                if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                    if ($pic["size"] <= 2097152) {
                        $sq = "SELECT * FROM category where CatID = '$id' or CatName = '$name'";
                        $result = mysqli_query($conn, $sq);
                        if (mysqli_num_rows($result) == 0) {
                            copy($pic['tmp_name'], "Category/" . $pic['name']);
                            $filePic = $pic['name'];
                            $picturecategory = htmlspecialchars(mysqli_real_escape_string($conn, $filePic));
                            mysqli_query($conn, "INSERT INTO category (CatID, CatName, CatDesc, Cat_image) VALUES ('$id', '$name', '$des', '$picturecategory')");
                            echo '<meta http-equiv="refresh" content = "0; URL=?page=category_management"/>';
                        } else {
                            echo "<li>Duplicate category ID or Name</li>";
                        }
                    } else {
                        echo "Size of image too big";
                    }
                } else {
                    echo "Image format is not correct";
                }
            }
            ?>

            <div class="col-lg-10 col-md-9 col-12">
                <h1 class="text-center mb-4">Adding Category</h1>
                <form id="formAddcategory" name="formAddcategory" method="post" enctype="multipart/form-data" onsubmit="return formValid()">
                    <div class="form-outline">
                        <input type="text" name="txtCatID" id="txtCatID" class="form-control form-control-lg" placeholder="Category ID (*)" style="font-size: medium;" value='<?php echo isset($_POST["txtCatID"]) ? ($_POST["txtCatID"]) : ""; ?>' />
                        <label class="form-label" for="txtCatID"></label>
                    </div>

                    <div class="form-outline">
                        <input type="text" name="txtCatName" id="txtCatName" class="form-control form-control-lg" placeholder="Category Name (*)" style="font-size: medium;" value='<?php echo isset($_POST["txtCatName"]) ? ($_POST["txtCatName"]) : ""; ?>' />
                        <label class="form-label" for="txtCatName"></label>
                    </div>

                    <div class="form-outline">
                        <input type="text" name="txtCatDesc" id="txtCatDesc" class="form-control form-control-lg" placeholder="Category Description (*)" style="font-size: medium;" value='<?php echo isset($_POST["txtCatDesc"]) ? ($_POST["txtCatDesc"]) : ""; ?>' />
                        <label class="form-label" for="txtCatDesc"></label>
                    </div>

                    <div class="form-outline">
                        <input type="file" name="catImage" id="catImage" class="form-control" value="" />
                        <label for="catImage" class="form-label"></label>
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

            if (format.test(f.txtCatID.value)) {
                alert("Category ID invalid, please enter again");
                f.txtCatID.focus();
                return false;
            }
            if (f.txtCatID.value == "" || f.txtCatName.value == "" || f.txtCatDesc.value == "") {
                alert("Enter fileds with marks(*), please");
                return false;
            }
            if (format.test(f.txtCatName.value)) {
                alert("Category name can't contain special character, please enter again");
                f.txtCatName.focus();
                return false;
            }
            if (format.test(f.txtCatDesc.value)) {
                alert("Category description can't contain special character, please enter again");
                f.txtCatDesc.focus();
                return false;
            }
            if (f.catImage.value == "") {
                alert("You must select your picture");
                return false;
            }
            return true;
        }
    </script>
</body>

</html>