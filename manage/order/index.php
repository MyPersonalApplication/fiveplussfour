<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Manage Order</title>

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
                    <h1 class="text-center mb-4">Manage Order</h1>
                    <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th><strong>No.</strong></th>
                                <th><strong>Order date</strong></th>
                                <!-- <th><strong>Delivery date</strong></th> -->
                                <th><strong>Delivery local</strong></th>
                                <th><strong>Customer Name</strong></th>
                                <th><strong>Telephone</strong></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $No = 1;
                            $sq = "SELECT OrderID, Orderdate, Deliverydate, Deliverylocal, CustName, CustPhone
                                FROM orders o
                                ORDER BY Orderdate DESC";
                            $res = mysqli_query($conn, $sq);
                            if (!$res) {
                                die('Invalid query: ' . mysqli_error($conn));
                            }
                            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <a href="detail.php?id=<?= $row['OrderID'] ?>" class="text-decoration-none"><?= $No ?></a>
                                    </td>
                                    <td class="text-center"><?= $row["Orderdate"]; ?></td>
                                    <!-- <td class="text-center"><?= $row["Deliverydate"]; ?></td> -->
                                    <td><?= $row["Deliverylocal"]; ?></td>
                                    <td><?= $row["CustName"]; ?></td>
                                    <td class="text-center"><?= $row["CustPhone"]; ?></td>
                                    <!-- <td class="text-center">
                                        <img src='../../Product/<?= $row["Pro_image"] ?>' border='0' width="50" height="50" />
                                    </td> -->
                                </tr>
                            <?php
                                $No++;
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </section>
    </div>
    <script>
        function deleteConfirm() {
            if (confirm("Are you sure to delete!")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</body>

</html>