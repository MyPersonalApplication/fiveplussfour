<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Payment</title>
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
        <?php
        if (isset($_POST["btnPayment"])) {
            $dlocal = $_POST['txtAddress'];
            $username = $_POST['txtUsername'];
            $custName = $_POST['txtFullname'];
            $custPhone = $_POST['txtPhonenumber'];
            $total = $_POST['txtTotal'];

            // Add to order table
            $sql = "INSERT INTO orders (Orderdate, Deliverydate, Deliverylocal, CustName, CustPhone, Total, Status, Username) 
                VALUES ('" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '$dlocal', '$custName', '$custPhone', '$total', '0', '$username')";

            mysqli_query($conn, $sql) or die(mysqli_error($conn));

            // Get last id inserted
            $last_id = mysqli_insert_id($conn);
            $sqlOrderDetail = "SELECT cart_id, Username, Count, ProID FROM `cart` WHERE username = '$username'";
            $resOrderDetail = mysqli_query($conn, $sqlOrderDetail);

            if (mysqli_num_rows($resOrderDetail) > 0) {
                while ($row = mysqli_fetch_array($resOrderDetail, MYSQLI_ASSOC)) {
                    $proid = $row['ProID'];
                    $proqty = $row['Count'];
                    // // Add to order detail table
                    $sql = "INSERT INTO orderdetail (OrderID, ProID, Qty) VALUES ('$last_id', '$proid', '$proqty')";
                    $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                    $sqlUpdateQty = "SELECT Pro_qty FROM product WHERE ProID = '$proid'";
                    $resUpdateQty = mysqli_query($conn, $sqlUpdateQty) or die(mysqli_error($conn));
                    $row = mysqli_fetch_array($resUpdateQty, MYSQLI_ASSOC);
                    $updateqty = $row['Pro_qty'] - $proqty;
                    mysqli_query($conn, "UPDATE product SET Pro_qty = '$updateqty' WHERE ProID = '$proid'") or die(mysqli_error($conn));
                }
                $sqlDeleteCart = "DELETE FROM `cart` WHERE username = '$username'";
                mysqli_query($conn, $sqlDeleteCart) or die(mysqli_error($conn));

                echo ("<script>
                            Swal.fire(
                                'Completely Payment',
                                'You have successfully paid',
                                'success'
                            ).then((result) => {
                                window.location.href = 'cart.php';
                            })
                        </script>");
            } else {
                echo ("<script>
                            Swal.fire(
                                'ERROR',
                                'Something went wrong!!!',
                                'error'
                            ).then((result) => {
                                window.location.href = 'order.php';
                            })
                        </script>");
            }
        }
        if (isset($_POST["btnPaymentnow"])) {
            $dlocal = $_POST['txtAddress'];
            $username = $_POST['txtUsername'];
            $custName = $_POST['txtFullname'];
            $custPhone = $_POST['txtPhonenumber'];
            $total = $_POST['txtTotal'];

            // Add to order table
            $sql = "INSERT INTO orders (Orderdate, Deliverydate, Deliverylocal, CustName, CustPhone, Total, Status, Username) 
                VALUES ('" . date('Y-m-d H:i:s') . "', '" . date('Y-m-d H:i:s') . "', '$dlocal', '$custName', '$custPhone', '$total', '0', '$username')";

            mysqli_query($conn, $sql) or die(mysqli_error($conn));

            // Get last id inserted
            $last_id = mysqli_insert_id($conn);

            $proid = $_POST['proid'];
            $quantity = $_POST['quantity'];

            $sq = "INSERT INTO orderdetail (OrderID, ProID, Qty) VALUES ('$last_id', '$proid', '$quantity')";

            $result = mysqli_query($conn, $sq) or die(mysqli_error($conn));

            $res = mysqli_query($conn, "SELECT Pro_qty FROM product WHERE ProID = '$proid'");
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
            $updateqty = $row['Pro_qty'] - $quantity;
            mysqli_query($conn, "UPDATE product SET Pro_qty = '$updateqty' WHERE ProID = '$proid'");

            echo ("<script>
                            Swal.fire(
                                'Completely Payment',
                                'You have successfully paid',
                                'success'
                            ).then((result) => {
                                window.location.href = 'cart.php';
                            })
                        </script>");
        }
        ?>
        <div class="cardorder border my-2 p-md-3">
            <div class="cardorder-top border-bottom text-center mb-4">
                <span id="logo">FPFStore.com</span>
            </div>
            <form action="" method="POST" class="cardorder-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="left border">
                            <div class="header">Payment by Cash</div>
                            <div class="row mt-3">
                                <?php
                                $username = $_COOKIE['username'];
                                $sqlFindUser = "SELECT * FROM `customer` WHERE Username = '$username'";
                                $res = mysqli_query($conn, $sqlFindUser);

                                if (mysqli_num_rows($res) > 0) {
                                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                                ?>
                                        <div><span>Username:</span>
                                            <input class="input" name="txtUsername" placeholder="Username" value="<?= $row['Username'] ?>">
                                        </div>
                                        <div><span>Order's name:</span>
                                            <input class="input" name="txtFullname" placeholder="Full name" value="<?= $row['CustName'] ?>">
                                        </div>
                                        <div><span>Phone Number:</span>
                                            <input class="input" name="txtPhonenumber" placeholder="Phone Number" value="<?= $row['CustPhone'] ?>">
                                        </div>
                                        <div class="col-12"><span>Order date:</span>
                                            <input class="input" name="txtOderdate" placeholder="yy-mm-dd" value="<?php echo date('Y-m-d') ?>">
                                        </div>
                                        <div><span>Address:</span>
                                            <input class="input" name="txtAddress" placeholder="Address" value="<?= $row['CustAddress'] ?>">
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<meta http-equiv="refresh" content = "0; URL=cart.php"/>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['btnBuynow'])) {
                        $proid = $_POST['proid'];
                        $quantity = $_POST['quantity'];

                        $sql = "SELECT * FROM `product` WHERE ProID = '$proid'";
                        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                        $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                        $name = $row['ProName'];
                        $short = $row['SmallDesc'];
                        $image = $row['Pro_image'];
                        $price = $row['ProPrice'];
                    ?>
                        <div class="col-md-6">
                            <input type="hidden" name="proid" value="<?= $proid ?>">
                            <input type="hidden" name="quantity" value="<?= $quantity ?>">
                            <div class="right border">
                                <div class="header">Order Summary</div>
                                <hr>
                                <div class="row item">
                                    <div class="col-4 align-self-center"><img class="img-fluid" src="Product/<?= $image ?>" width="50%"></div>
                                    <div class="col-8">
                                        <b>$ <?= $price ?></b>
                                        <div class="row text-muted"><?= $name ?></div>
                                        <div class="row">Qty: <?= $quantity ?></div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row lower">
                                    <div class="col text-left">Item</div>
                                    <div class="col text-right">1</div>
                                </div>
                                <div class="row lower">
                                    <div class="col text-left">Subtotal</div>
                                    <div class="col text-right">$ <?= ($price * $quantity) ?></div>
                                </div>
                                <div class="row lower">
                                    <div class="col text-left">Delivery</div>
                                    <div class="col text-right">Free</div>
                                </div>
                                <div class="row lower">
                                    <div class="col text-left"><b>Total to pay</b></div>
                                    <input type="hidden" name="txtTotal" value="<?= ($price * $quantity) ?>">
                                    <div class="col text-right"><b>$ <?= ($price * $quantity) ?></b></div>
                                </div>
                                <input type="submit" class="btn btn-primary btnorder my-3" name="btnPaymentnow" id="btnPaymentnow" value="Payment" />
                                <input type="button" class="btn btn-light btn-block" style="font-size: 0.7rem;" name="btnCancel" id="btnCancel" value="Cancel" onclick="window.location='?page=viewdetail&id=<?php echo $proid ?>'" />
                                <p class="text-muted text-center">Complimentary Shipping</p>
                            </div>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-md-6">
                            <div class="right border">
                                <div class="header">Order Summary</div>
                                <hr>
                                <?php
                                $username = $_COOKIE['username'];
                                $sql = "SELECT * FROM `cart` c JOIN `customer` cus ON c.Username = cus.Username
                                        JOIN `product` p ON c.ProID = p.ProID WHERE c.Username = '$username'";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    $all = 0;
                                    $item = 0;
                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        $total = $row['ProPrice'] * $row['Count'];
                                        $all += $total;
                                ?>
                                        <div class="row item">
                                            <div class="col-4 align-self-center"><img class="img-fluid" src="Product/<?= $row['Pro_image'] ?>" width="50%"></div>
                                            <div class="col-8">
                                                <b>$ <?= $row['ProPrice'] ?></b>
                                                <div class="row text-muted"><?= $row['ProName'] ?></div>
                                                <div class="row">Qty: <?= $row['Count'] ?></div>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php
                                        $item++;
                                    }
                                    ?>
                                    <div class="row lower">
                                        <div class="col text-left">Item</div>
                                        <div class="col text-right"><?php echo $item ?></div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left">Subtotal</div>
                                        <div class="col text-right">$ <?php echo $all ?></div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left">Delivery</div>
                                        <div class="col text-right">Free</div>
                                    </div>
                                    <div class="row lower">
                                        <div class="col text-left"><b>Total to pay</b></div>
                                        <input type="hidden" name="txtTotal" value="<?php echo $all ?>">
                                        <div class="col text-right"><b>$ <?php echo $all ?></b></div>
                                    </div>
                                <?php
                                } else {
                                    echo '<meta http-equiv="refresh" content = "0; URL=cart.php"/>';
                                }
                                ?>
                                <input type="submit" class="btn btn-primary btnorder my-3" name="btnPayment" id="btnPayment" value="Payment" />
                                <p class="text-muted text-center">Complimentary Shipping</p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
        <?php
        include_once("partial/footer.php");
        ?>
    </div>
    <?php
    include_once("partial/script.php");
    ?>
</body>

</html>