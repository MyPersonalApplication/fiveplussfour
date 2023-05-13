<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Detail</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <?php
    include_once("partial/library.php");
    ?>
</head>

<body>
    <div class="container-fluid">
        <?php
        // include_once("auth_user.php");
        include_once("partial/header.php");
        ?>
        <?php
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $sqlstring = "SELECT ProID, ProName, ProPrice, SmallDesc, DetailDesc, Pro_qty, Pro_image, CatName
                FROM product p, category c
                WHERE p.CatID = c.CatID AND ProID = '$id'";
            $result = mysqli_query($conn, $sqlstring);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

            $proname = $row["ProName"];
            $price = $row["ProPrice"];
            $short = $row["SmallDesc"];
            $detail = $row["DetailDesc"];
            $qty = $row["Pro_qty"];
            $pic = $row["Pro_image"];
            $catname = $row["CatName"];
        ?>
            <div class="my-2 border">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title ms-2"><?= $proname ?></h3>
                        <h6 class="card-subtitle ms-2 mb-4"><?= $short ?></h6>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 mb-3" valign="middle">
                                <div class="white-box text-center"><img src="Product/<?= $pic ?>" class="img-responsive" height="auto" width="60%"></div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mt-xl-4">
                                <h4 class="box-title">Product description</h4>
                                <p><?= $detail ?></p>
                                <?php
                                if ($qty > 0) {
                                ?>
                                    <h4 class="mt-md-5">Remaining products: <?= $qty ?></h4>
                                    <div class="my-4 align-items-center">
                                        <h2 class="me-3">
                                            $<?= $price ?>
                                        </h2>
                                    </div>
                                    <form action="cart.php" method="POST" class="mb-2">
                                        <div class="d-flex">
                                            <input type="hidden" name="proid" value="<?= $id ?>">
                                            <input type="number" name="quantity" value="1" min="1" max="<?= $qty ?>">
                                            <input type="submit" name="addcart" class="btn btn-dark mx-md-2 my-2 my-md-0 col-md-3" value="Add to cart">
                                            <input type="submit" name="btnBuynow" formaction="order.php" class="btn btn-primary btn-rounded me-md-2 my-md-0 mb-2 col-md-3" value="Buy Now">
                                            <!-- <input type="submit" name="btnFeedback" formaction="feedback.php?id=<?= $id ?>" class="btn btn-warning btn-rounded col-md-3" value="Feedback"> -->
                                        </div>
                                    </form>
                                <?php
                                } else {
                                ?>
                                    <h4 class="text-danger mt-5">OUT OF STOCK</h4>
                                <?php
                                }
                                ?>
                                <h3 class="box-title mt-5">Key Highlights</h3>
                                <ul class="list-unstyled">
                                    <li><i class="fa fa-check text-success"></i> Quality fabric is cool</li>
                                    <li><i class="fa fa-check text-success"></i> Designed to fit all sizes</li>
                                    <li><i class="fa fa-check text-success"></i> The perfect product to flaunt your amazing collection</li>
                                </ul>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <h3 class="box-title mt-5 mb-3">General Info</h3>
                                <div class="table-responsive">
                                    <table class="table table-striped table-product">
                                        <tbody>
                                            <tr>
                                                <td width="190">Brand</td>
                                                <td><?= $catname ?></td>
                                            </tr>
                                            <tr>
                                                <td>Delivery Condition</td>
                                                <td>Knock Down</td>
                                            </tr>
                                            <tr>
                                                <td>Type</td>
                                                <td>Clothes</td>
                                            </tr>
                                            <tr>
                                                <td>Style</td>
                                                <td>Modern</td>
                                            </tr>
                                            <tr>
                                                <td>Suitable For</td>
                                                <td>Everyone</td>
                                            </tr>
                                            <tr>
                                                <td>Care Instructions</td>
                                                <td>Do not apply any toxic chemical for cleaning</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <h3 class="box-title mt-5 mb-3">Feedback from customer</h3>
                                    <table class="table table-striped table-product">
                                        <?php
                                        $sql = "SELECT Username, Content FROM feedback WHERE state = '1' AND ProID = '$id'";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        ?>
                                            <tbody>
                                                <tr>
                                                    <td width="190"><?= $row['Username'] ?></td>
                                                    <td><?= $row['Content'] ?></td>
                                                </tr>
                                            </tbody>
                                        <?php
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        } else {
            header("Location: shop.php");
        }
        ?>
        <?php
        include_once("partial/footer.php");
        ?>
    </div>
    <?php
    include_once("partial/script.php");
    ?>
</body>

</html>