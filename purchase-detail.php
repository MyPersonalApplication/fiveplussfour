<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Purchase History</title>

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
        <form name="frm" method="post" action="" class="mt-3 mx-md-2">
            <h1 class="text-center mb-4">Order Management</h1>
            <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr class="text-center">
                        <th><strong>No.</strong></th>
                        <th><strong>Product</strong></th>
                        <th><strong>Image</strong></th>
                        <th><strong>Quantity</strong></th>
                        <th><strong>Total</strong></th>
                        <th><strong>Feedback</strong></th>
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
                                    <img src='Product/<?= $row["Pro_image"] ?>' border='0' width="150" />
                                </td>
                                <td class="text-center"><?= $row["Qty"]; ?></td>
                                <td class="text-center fw-bold">$<?= $row["Qty"] * $row['ProPrice']; ?></td>
                                <td class="text-center">
                                    <a href="feedback.php?id=<?= $row["ProID"] ?>" class="btn btn-warning btn-rounded">Feedback</a>
                                </td>
                            </tr>
                    <?php
                            $No++;
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-center">
                <a href="purchase-history.php" class="btn btn-primary">Back to order</a>
            </div>
        </form>
        <?php
        include_once("partial/footer.php");
        ?>
    </div>
    <?php
    include_once("partial/script.php");
    ?>
</body>

</html>