<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Update Product</title>

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
            function bind_Category_List($conn, $selectValue)
            {
                $sqlstring = "SELECT CatID, CatName from category";
                $result = mysqli_query($conn, $sqlstring);
                echo "<select name='CategoryList' class='form-control'>
					<option value='0'>Choose category</option>";
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    if ($row['CatID'] == $selectValue) {
                        echo "<option value='" . $row['CatID'] . "' selected>" . $row['CatName'] . "</option>";
                    } else {
                        echo "<option value='" . $row['CatID'] . "'>" . $row['CatName'] . "</option>";
                    }
                }
                echo "</select>";
            }
            $errUpdateProduct = "";
            if (isset($_POST["btnUpdatePro"])) {
                $id = $_POST["txtProID"];
                $proname = $_POST["txtProName"];
                $short = $_POST["txtSmallDesc"];
                $detail = $_POST["txtDetailDesc"];
                $price = $_POST["txtProPrice"];
                $qty = $_POST["txtQty"];
                $pic = $_FILES["txtImage"];
                $category = $_POST["CategoryList"];

                $id = htmlspecialchars(mysqli_real_escape_string($conn, $id));
                $proname = htmlspecialchars(mysqli_real_escape_string($conn, $proname));
                $short = htmlspecialchars(mysqli_real_escape_string($conn, $short));
                $detail = htmlspecialchars(mysqli_real_escape_string($conn, $detail));

                if ($pic['name'] != "") {
                    if ($pic["type"] == "image/jpg" || $pic["type"] == "image/jpeg" || $pic["type"] == "image/png" || $pic["type"] == "image/gif") {
                        if ($pic["size"] <= 5242880) {
                            $sq = "SELECT * FROM product WHERE ProID != '$id' AND ProName = '$proname'";
                            $result = mysqli_query($conn, $sq);
                            if (mysqli_num_rows($result) == 0) {

                                copy($pic['tmp_name'], "../../Product/" . $pic['name']);
                                $filePic = $pic['name'];

                                $sqlstring = "UPDATE product SET ProName = '$proname',
                                                ProPrice = '$price',
                                                SmallDesc = '$short',
                                                DetailDesc = '$detail',
                                                ProDate = '" . date('Y-m-d H:i:s') . "',
                                                Pro_qty = '$qty',
                                                Pro_image = '$filePic',
                                                CatID = '$category'
                                                WHERE ProID = '$id'";
                                $res = mysqli_query($conn, $sqlstring);
                                if (!$result) {
                                    die('Invalid query: ' . mysqli_error($conn));
                                }
                                echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
                            } else {
                                $errUpdateProduct = "Duplicate product Name";
                            }
                        } else {
                            $errUpdateProduct = "Size of image too big";
                        }
                    } else {
                        $errUpdateProduct = "Image format is not correct";
                    }
                } else {
                    $sq = "SELECT * FROM product WHERE ProID != '$id' AND ProName = '$proname'";
                    $result = mysqli_query($conn, $sq);
                    if (mysqli_num_rows($result) == 0) {
                        $sqlstring = "UPDATE product SET ProName = '$proname',
                                        ProPrice = '$price',
                                        SmallDesc = '$short',
                                        DetailDesc = '$detail',
                                        ProDate = '" . date('Y-m-d H:i:s') . "',
                                        Pro_qty = '$qty',
                                        CatID = '$category'
                                        WHERE ProID = '$id'";
                        mysqli_query($conn, $sqlstring);
                        echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
                    } else {
                        $errUpdateProduct = "Duplicate product Name";
                    }
                }
            }
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $sqlstring = "SELECT ProID, ProName, ProPrice, SmallDesc, DetailDesc, ProDate, Pro_qty, Pro_image, CatID
					        FROM product
                            WHERE ProID = '$id'";
                $result = mysqli_query($conn, $sqlstring);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $proname = $row["ProName"];
                $short = $row["SmallDesc"];
                $detail = $row["DetailDesc"];
                $price = $row["ProPrice"];
                $qty = $row["Pro_qty"];
                $pic = $row["Pro_image"];
                $category = $row["CatID"];
            ?>
                <div class="col-lg-10 col-md-9 col-12">
                    <h2 class="text-center my-3">Updating Product</h2>
                    <div class="text-center mb-4">
                        <span class="text-danger">
                            <h5 id="errUpdateProduct"><?= $errUpdateProduct == "" ? "" : $errUpdateProduct; ?></h5>
                        </span>
                    </div>
                    <form id="frmUpdateProduct" name="frmUpdateProduct" method="post" enctype="multipart/form-data" action="" class="form-horizontal mx-md-5" role="form" onsubmit="return formValid()">
                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtProID">Product ID:</label>
                            <input type="text" name="txtProID" id="txtProID" class="form-control" placeholder="" readonly value='<?php echo $id; ?>' />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtProName">Product Name:</label>
                            <input type="text" name="txtProName" id="txtProName" class="form-control" placeholder="" value='<?php echo $proname; ?>' />
                            <span class="text-danger" id="errorProName"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatID">Choose Category:</label>
                            <div>
                                <?php
                                bind_Category_List($conn, $category);
                                ?>
                            </div>
                            <span class="text-danger" id="errorProCate"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtProPrice">Price:</label>
                            <input type="text" name="txtProPrice" id="txtProPrice" class="form-control" placeholder="" value='<?php echo $price ?>' />
                            <span class="text-danger" id="errorProPrice"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtSmallDesc">Small Description:</label>
                            <input type="text" name="txtSmallDesc" id="txtSmallDesc" class="form-control" placeholder="" value='<?php echo $short ?>' />
                            <span class="text-danger" id="errorProSmallDesc"></span>
                        </div>

                        <div class="form-group mb-4">
                            <label for="lblDetail" class="control-label mb-1 fw-bold">Detail description: </label>
                            <div class="">
                                <textarea name="txtDetailDesc" rows="4" class="btn-block"><?php echo $detail ?></textarea>
                            </div>
                            <span class="text-danger" id="errorProDetailDesc"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtQty">Quantity:</label>
                            <input type="number" min="1" name="txtQty" id="txtQty" class="form-control" placeholder="" value="<?php echo $qty ?>" />
                            <span class="text-danger" id="errorProQty"></span>
                        </div>

                        <div class="form-outline mb-3">
                            <label for="txtImage" class="form-label mb-1 fw-bold">Choose Picture:</label><br>
                            <img src='../../Product/<?php echo $pic; ?>' class="mb-2" border='0' width="50" height="50" />
                            <input type="file" name="txtImage" id="txtImage" class="form-control" value="" />
                        </div>

                        <div class="form-ouline my-3 text-center">
                            <div class="">
                                <input type="submit" class="btn btn-primary" name="btnUpdatePro" id="btnUpdatePro" value="Update" />
                                <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?id=<?php echo $row['ProID']; ?>'" />
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
            f = document.frmUpdateProduct;

            const errUpdateProduct = document.getElementById('errUpdateProduct')
            const errorProID = document.getElementById('errorProID')
            const errorProName = document.getElementById('errorProName')
            const errorProCate = document.getElementById('errorProCate')
            const errorProPrice = document.getElementById('errorProPrice')
            const errorProSmallDesc = document.getElementById('errorProSmallDesc')
            const errorProDetailDesc = document.getElementById('errorProDetailDesc')
            const errorProQty = document.getElementById('errorProQty')
            const errorProImage = document.getElementById('errorProImage')

            if (f.txtProID.value == "" || f.txtProName.value == "" || f.txtProPrice.value == "" || f.txtSmallDesc.value == "" || f.txtQty.value == "" || f.txtDetailDesc.value == "") {
                errUpdateProduct.innerHTML = "Enter fileds with marks(*), please"
                return false;
            } else {
                errUpdateProduct.innerHTML = ""
            }
            // Product Category
            if (f.CategoryList.value == 0) {
                errorProCate.innerHTML = "Please choose category"
                return false;
            } else {
                errorProCate.innerHTML = ""
            }
            return true;
        }
    </script>
</body>

</html>