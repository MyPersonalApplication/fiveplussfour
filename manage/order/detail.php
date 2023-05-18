<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Order Detail</title>

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

            <div class="col-lg-10 col-md-9 col-12">
                <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                    <h1 class="text-center mb-4">Order Detail</h1>
                    <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th><strong>No.</strong></th>
                                <th><strong>Product</strong></th>
                                <th><strong>Image</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th><strong>Total</strong></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $No = 1;
                                $sq = "SELECT * FROM orderdetail od INNER JOIN product p ON od.ProID = p.ProID WHERE OrderID = '$id'";
                                $res = mysqli_query($conn, $sq);
                                if (!$res) {
                                    die('Invalid query: ' . mysqli_error($conn));
                                }
                                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            ?>
                                    <tr>
                                        <td class="text-center"><?= $No ?></td>
                                        <td class="text-center"><?= $row["ProName"]; ?></td>
                                        <td class="text-center">
                                            <img src='../../Product/<?= $row["Pro_image"] ?>' border='0' width="50" height="50" />
                                        </td>
                                        <td class="text-center"><?= $row["Qty"]; ?></td>
                                        <td class="text-center fw-bold">$<?= $row["Qty"] * $row['ProPrice']; ?></td>
                                    </tr>
                            <?php
                                    $No++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <div class="text-center">
                        <a href="../order/index.php" class="btn btn-primary">Back to order</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</body>

</html>