<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Update Category</title>

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
            $errUpdateCategory = "";
            if (isset($_POST["btnUpdateCat"])) {
                $id = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatID"]));
                $name = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatName"]));
                $des = htmlspecialchars(mysqli_real_escape_string($conn, $_POST["txtCatDesc"]));
                $pic = $_FILES["fileImage"];

                if ($pic['name'] != "") {
                    if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                        if ($pic["size"] <= 5242880) {
                            $sq = "SELECT * FROM category where CatID != '$id' AND CatName = '$name'";
                            $result = mysqli_query($conn, $sq);
                            if (mysqli_num_rows($result) == 0) {
                                copy($pic['tmp_name'], "../../Category/" . $pic['name']);
                                $filePic = $pic['name'];
                                $picturecategory = htmlspecialchars(mysqli_real_escape_string($conn, $filePic));
                                mysqli_query($conn, "UPDATE category SET CatName = '$name', CatDesc = '$des', Cat_image = '$picturecategory' WHERE CatID = '$id'");
                                echo '<meta http-equiv="refresh" content = "0; URL=?page=category_management"/>';
                            } else {
                                $errUpdateCategory = "Duplicate category Name";
                            }
                        } else {
                            $errUpdateCategory = "Size of image too big";
                        }
                    } else {
                        $errUpdateCategory = "Image format is not correct";
                    }
                } else {
                    $sq = "SELECT * FROM category WHERE CatID != '$id' AND CatName = '$name'";
                    $result = mysqli_query($conn, $sq);
                    if (mysqli_num_rows($result) == 0) {
                        mysqli_query($conn, "UPDATE category SET CatName = '$name', CatDesc = '$des' WHERE CatID = '$id'");
                        echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
                    } else {
                        $errUpdateCategory = "Dulicate category Name";
                    }
                }
            }
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $result = mysqli_query($conn, "SELECT * FROM category WHERE CatID = '$id'");
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $cat_id = $row["CatID"];
                $cat_name = $row["CatName"];
                $cat_des = $row["CatDesc"];
                $pic = $row["Cat_image"];

            ?>
                <div class="col-lg-10 col-md-9 col-12">
                    <h2 class="text-center mb-4">Updating Category</h2>
                    <div class="text-center mb-4">
                        <span class="text-danger">
                            <h5><?= $errUpdateCategory == "" ? "" : $errUpdateCategory; ?></h5>
                        </span>
                    </div>
                    <form id="formUpdatecategory" name="formUpdatecategory" enctype="multipart/form-data" method="POST" onsubmit="return formValid()">
                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatID">Category ID:</label>
                            <input type="text" name="txtCatID" id="txtCatID" class="form-control" readonly value='<?php echo $cat_id; ?>' />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatName">Category Name:</label>
                            <input type="text" name="txtCatName" id="txtCatName" class="form-control" value='<?php echo $cat_name ?>' />
                            <span class="text-danger" id="errorCatName"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatDesc">Category Description:</label>
                            <input type="text" name="txtCatDesc" id="txtCatDesc" class="form-control" value='<?php echo $cat_des ?>' />
                            <span class="text-danger" id="errorCatDesc"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label for="fileImage" class="form-label mb-1 fw-bold">Choose Picture:</label><br>
                            <img src='../../Category/<?php echo $pic; ?>' class="mb-2" border='0' width="100" height="50" />
                            <input type="file" name="fileImage" id="fileImage" class="form-control" value="">
                        </div>

                        <div class="form-group text-center">
                            <div class="">
                                <input type="submit" class="btn btn-primary" name="btnUpdateCat" id="btnUpdateCat" value="Update" />
                                <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?id=<?php echo $row['CatID']; ?>'" />
                                <input type="button" class="btn btn-primary" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='./'" />
                            </div>
                        </div>
                    </form>
                </div>
            <?php
            } else {
                echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
            }
            ?>
        </section>
    </div>
    <script>
        function formValid() {
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
            f = document.formUpdatecategory

            const errorCatName = document.getElementById('errorCatName')
            const errorCatDesc = document.getElementById('errorCatDesc')

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

            return true;
        }
    </script>
</body>

</html>