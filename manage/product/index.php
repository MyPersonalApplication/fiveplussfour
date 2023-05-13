<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Manage Product</title>

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
            if (isset($_GET["function"]) == "del") {
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];
                    $sq = "SELECT Pro_image FROM product WHERE ProID = '$id'";
                    $res = mysqli_query($conn, $sq);
                    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                    $filePic = $row['Pro_image'];
                    unlink("Product/" . $filePic);
                    mysqli_query($conn, "DELETE FROM product WHERE ProID = '$id'");
                }
            }
            ?>
            <div class="col-lg-10 col-md-9 col-12">
                <form name="frm" method="post" action="" class="mt-3">
                    <h1 class="text-center">Manage Product</h1>
                    <div class="text-center mb-2">
                        <a href="?page=add_product" class="btn btn-outline-primary">
                            <img src="../../Image/add.png" alt="Add new" width="16" height="16" border="0" /> Add new
                        </a>
                    </div>
                    <table id="tableproduct" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th><strong>No.</strong></th>
                                <th><strong>Product ID</strong></th>
                                <th><strong>Product Name</strong></th>
                                <th><strong>Price</strong></th>
                                <th><strong>Quantity</strong></th>
                                <th><strong>Category Name</strong></th>
                                <th><strong>Image</strong></th>
                                <th><strong>Edit</strong></th>
                                <th><strong>Delete</strong></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $No = 1;
                            $result = mysqli_query($conn, "SELECT ProID, ProName, ProPrice, Pro_qty, Pro_image, CatName
                                                FROM product p, category c
                                                WHERE p.CatID = c.CatID
                                                ORDER BY ProDate DESC");
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            ?>
                                <tr valign="middle">
                                    <td class="text-center"><?php echo $No; ?></td>
                                    <td class="text-center"><?php echo $row["ProID"]; ?></td>
                                    <td><?php echo $row["ProName"]; ?></td>
                                    <td class="text-center">$<?php echo $row["ProPrice"]; ?></td>
                                    <td class="text-center"><?php echo $row["Pro_qty"]; ?></td>
                                    <td><?php echo $row["CatName"]; ?></td>
                                    <td class="text-center">
                                        <img src='../../Product/<?php echo $row["Pro_image"] ?>' border='0' width="50" height="50" />
                                    </td>
                                    <td class="text-center">
                                        <a href="?page=update_product&&id=<?php echo $row['ProID'] ?>">
                                            <i class="bi bi-pen-fill" style="color: black;"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a href="?page=product_management&&function=del&&id=<?php echo $row["ProID"] ?>" onclick="return deleteConfirm()">
                                            <i class="bi bi-trash-fill" style="color: red;"></i>
                                        </a>
                                    </td>
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