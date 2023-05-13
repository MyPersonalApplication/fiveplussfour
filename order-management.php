<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
        echo "<script>alert('You are not administrator to access this page')</script>";
        echo '<meta http-equiv="refresh" content = "0; URL=index.php"/>';
    } else {

?>
        <script>
            function deleteConfirm() {
                if (confirm("Are you sure to delete!")) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>

        <?php
        if (isset($_GET["function"]) == "del") {
            $ido = $_GET["ido"];
            $idp = $_GET["idp"];
            mysqli_query($conn, "DELETE FROM orderdetail WHERE OrderID = '$ido' AND ProID = '$idp'");
        }
        ?>

        <div class="container border my-2">
            <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                <h1 class="text-center mb-4">Order Management</h1>
                <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Order date</strong></th>
                            <!-- <th><strong>Delivery date</strong></th> -->
                            <th><strong>Delivery local</strong></th>
                            <th><strong>Customer Name</strong></th>
                            <th><strong>Product</strong></th>
                            <th><strong>Quantity</strong></th>
                            <th><strong>Delete</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $No = 1;
                        $sq = "SELECT Orderdate, Deliverydate, Deliverylocal, c.CustName, Pro_image, Qty
                                FROM orders o, orderdetail od, product p, customer c
                                WHERE o.OrderID = od.OrderID AND od.ProID = p.ProID AND o.Username = c.Username ORDER BY Orderdate DESC";
                        $res = mysqli_query($conn, $sq);
                        if (!$res) {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No ?></td>
                                <td align='center'><?php echo $row["Orderdate"]; ?></td>
                                <!-- <td align='center'><?php echo $row["Deliverydate"]; ?></td> -->
                                <td><?php echo $row["Deliverylocal"]; ?></td>
                                <td><?php echo $row["CustName"]; ?></td>
                                <td align='center'>
                                    <img src='Product/<?php echo $row["Pro_image"] ?>' border='0' width="50" height="50" />
                                </td>
                                <td align='center'><?php echo $row["Qty"]; ?></td>
                                <td style='text-align:center'>
                                    <a href="?page=order_management&&function=del&&ido=<?php echo $row["OrderID"] ?>&&idp=<?php echo $row["ProID"] ?>" onclick="return deleteConfirm()">
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
<?php
    }
}
?>