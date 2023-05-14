<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Add Product</title>

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
            function bind_Category_List($conn)
            {
                $sqlstring = "SELECT CatID, CatName from category";
                $result = mysqli_query($conn, $sqlstring);
                echo "<select name='CategoryList' class='form-control'>
					<option value='0'>Choose category</option>";
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "<option value='" . $row['CatID'] . "'>" . $row['CatName'] . "</option>";
                }
                echo "</select>";
            }
            $errAddProduct = "";
            if (isset($_POST["btnAdd"])) {
                $id = $_POST["txtProID"];
                $proname = $_POST["txtProName"];
                $short = $_POST["txtSmallDesc"];
                $detail = $_POST["txtDetailDesc"];
                $price = $_POST["txtProPrice"];
                $qty = $_POST["txtQty"];
                $pic = $_FILES["fileImage"];
                $category = $_POST["CategoryList"];
                $err = "";

                $iden = htmlspecialchars(mysqli_real_escape_string($conn, $id));
                $pronameen = htmlspecialchars(mysqli_real_escape_string($conn, $proname));
                $shorten = htmlspecialchars(mysqli_real_escape_string($conn, $short));
                $detailen = htmlspecialchars(mysqli_real_escape_string($conn, $detail));

                if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                    if ($pic["size"] <= 5242880) {
                        $sq = "SELECT * FROM product WHERE ProID = '$id' or ProName = '$proname'";
                        $result = mysqli_query($conn, $sq);
                        if (mysqli_num_rows($result) == 0) {
                            copy($pic['tmp_name'], "../../Product/" . $pic['name']);
                            $filePic = $pic['name'];
                            $picture = htmlspecialchars(mysqli_real_escape_string($conn, $filePic));
                            $sqlstring = "INSERT INTO product (ProID, ProName, ProPrice, SmallDesc, DetailDesc, ProDate, Pro_qty, Pro_image, CatID)
                                    VALUES ('$iden', '$pronameen', '$price', '$shorten', '$detailen', '" . date('Y-m-d H:i:s') . "', $qty, '$picture', '$category')";
                            mysqli_query($conn, $sqlstring) or die(mysqli_error($conn));
                            echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
                        } else {
                            $errAddProduct = "Duplicate product ID or Name";
                        }
                    } else {
                        $errAddProduct = "Size of image too big";
                    }
                } else {
                    $errAddProduct = "Image format is not correct";
                }
            }
            ?>

            <div class="col-lg-10 col-md-9 col-12">
                <h2 class="text-center mb-4">Adding new Product</h2>
                <div class="text-center mb-4">
                    <span class="text-danger">
                        <h5 id="errAddProduct"><?= $errAddProduct == "" ? "" : $errAddProduct; ?></h5>
                    </span>
                </div>
                <form id="frmAddproduct" name="frmAddproduct" method="post" enctype="multipart/form-data" class="form-horizontal" onsubmit="return formValid()">
                    <div class="form-outline mb-2">
                        <input type="text" name="txtProID" id="txtProID" class="form-control" placeholder="Product ID (*)" value='<?php echo isset($_POST["txtProID"]) ? ($_POST["txtProID"]) : ""; ?>' />
                        <label class="form-label" for="txtProID"></label>
                        <span class="text-danger" id="errorProID"></span>
                    </div>
                    <div class="form-outline mb-2">
                        <input type="text" name="txtProName" id="txtProName" class="form-control" placeholder="Product Name (*)" value='<?php echo isset($_POST["txtProName"]) ? ($_POST["txtProName"]) : ""; ?>' />
                        <label class="form-label" for="txtProName"></label>
                        <span class="text-danger" id="errorProName"></span>
                    </div>
                    <div class="form-outline mb-2">
                        <div name="slcategory">
                            <?php
                            bind_Category_List($conn);
                            ?>
                        </div>
                        <label class="form-label" for=""></label>
                        <span class="text-danger" id="errorProCate"></span>
                    </div>
                    <div class="form-outline mb-2">
                        <input type="number" min="1" name="txtProPrice" id="txtProPrice" step="0.01" class="form-control" placeholder="Price (*)" value='<?php echo isset($_POST["txtProPrice"]) ? ($_POST["txtProPrice"]) : ""; ?>' />
                        <label class="form-label" for="txtProPrice"></label>
                        <span class="text-danger" id="errorProPrice"></span>
                    </div>
                    <div class="form-outline mb-2">
                        <input type="text" name="txtSmallDesc" id="txtSmallDesc" class="form-control" placeholder="Small Description (*)" value='<?php echo isset($_POST["txtSmallDesc"]) ? ($_POST["txtSmallDesc"]) : ""; ?>' />
                        <label class="form-label" for="txtSmallDesc"></label>
                        <span class="text-danger" id="errorProSmallDesc"></span>
                    </div>

                    <div class="form-ouline mb-4">
                        <textarea name="txtDetailDesc" rows="4" placeholder="Detail Description (*)" class="btn-block"><?php echo isset($_POST["txtDetailDesc"]) ? ($_POST["txtDetailDesc"]) : ""; ?></textarea>
                        <span class="text-danger" id="errorProDetailDesc"></span>
                    </div>

                    <div class="form-outline mb-2">
                        <input type="number" name="txtQty" id="txtQty" min="1" class="form-control" placeholder="Quantity (*)" value='<?php echo isset($_POST["txtQty"]) ? ($_POST["txtQty"]) : ""; ?>' />
                        <label class="form-label" for="txtQty"></label>
                        <span class="text-danger" id="errorProQty"></span>
                    </div>

                    <div class="form-outline mb-2">
                        <input type="file" name="fileImage" id="fileImage" class="form-control" value="" />
                        <label for="fileImage" class="form-label"></label>
                        <span class="text-danger" id="errorProImage"></span>
                    </div>

                    <div class="form-ouline mt-2 text-center">
                        <div class="">
                            <input type="submit" class="btn btn-primary" name="btnAdd" id="btnAdd" value="Add new" />
                            <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='./'" />
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        function formValid() {
            var format = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
            f = document.frmAddproduct;

            const errAddProduct = document.getElementById('errAddProduct')
            const errorProID = document.getElementById('errorProID')
            const errorProName = document.getElementById('errorProName')
            const errorProCate = document.getElementById('errorProCate')
            const errorProPrice = document.getElementById('errorProPrice')
            const errorProSmallDesc = document.getElementById('errorProSmallDesc')
            const errorProDetailDesc = document.getElementById('errorProDetailDesc')
            const errorProQty = document.getElementById('errorProQty')
            const errorProImage = document.getElementById('errorProImage')

            if (f.txtProID.value == "" || f.txtProName.value == "" || f.txtProPrice.value == "" || f.txtSmallDesc.value == "" || f.txtQty.value == "" || f.txtDetailDesc.value == "") {
                errAddProduct.innerHTML = "Enter fileds with marks(*), please"
                return false;
            } else {
                errAddProduct.innerHTML = ""
            }
            // Product ID
            if (format.test(f.txtProID.value)) {
                errorProID.innerHTML = "Product ID invalid";
                f.txtProID.focus();
                return false;
            } else {
                errorProID.innerHTML = ""
            }
            // Product Category
            if (f.CategoryList.value == 0) {
                errorProCate.innerHTML = "Please choose category"
                return false;
            } else {
                errorProCate.innerHTML = ""
            }
            // Product Image
            if (f.fileImage.value == "") {
                errorProImage.innerHTML = "You must select the picture"
                f.fileImage.focus();
                return false;
            } else {
                errorProImage.innerHTML = ""
            }
            return true;
        }
    </script>
</body>

</html>