<?php
include_once("connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NDQ - Cart</title>
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
        if (isset($_POST['addcart'])) {
            $username = $_COOKIE['username'];
            $proid = $_POST['proid'];
            $quantity = $_POST['quantity'];

            $sql = "SELECT * FROM cart where ProID = '$proid' AND Username = '$username'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $updateQty = $row['Count'] + $quantity;

                $sqlUpdate = "UPDATE cart SET Count = '$updateQty' WHERE ProID = '$proid' AND Username = '$username'";
                mysqli_query($conn, $sqlUpdate) or die(mysqli_error($conn));
            } else {
                $sql_insertToCart = "INSERT INTO cart(Username, ProID, Count) VALUES ('$username', '$proid', '$quantity')";
                mysqli_query($conn, $sql_insertToCart) or die(mysqli_error($conn));
            }
            header("Location: cart.php");
            exit();
        }
        ?>
        <div class="my-2 border">
            <h2 class="text-center my-3">My Cart</h2>
            <div class="container">
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:50%">Product</th>
                            <th style="width:10%">Price</th>
                            <th style="width:8%">Quantity</th>
                            <th style="width:22%" class="text-center">Total</th>
                            <th style="width:10%"> </th>
                        </tr>
                    </thead>
                    <?php
                    $username = $_COOKIE['username'];
                    $sql = "SELECT p.ProID as pro_id, p.ProName as pro_name, p.SmallDesc as small_desc, p.ProPrice, p.Pro_image as pro_image, c.cart_id, c.Count as quantity 
                            FROM cart c INNER JOIN product p ON p.ProID = c.ProID WHERE c.Username = '$username'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $all = 0;
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $total = $row['ProPrice'] * $row['quantity'];
                            $all += $total;
                    ?>
                            <tbody>
                                <tr>
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-12 col-md-4 col-lg-3 hidden-xs d-flex align-items-center">
                                                <img src="Product/<?= $row['pro_image'] ?>" alt="" class="img-responsive" width="100">
                                            </div>
                                            <div class="col-12 col-md-7 col-lg-8 mt-3 ms-md-3 ms-lg-0">
                                                <h4 class="nomargin"><?= $row['pro_name'] ?></h4>
                                                <p><?= $row['small_desc'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price">$<?php echo $row['ProPrice'] ?></td>
                                    <td data-th="Quantity"><input type="number" min="1" readonly class="form-control text-center" value="<?php echo $row['quantity'] ?>">
                                    </td>
                                    <td data-th="Total" class="text-center">$<?php echo $total ?></td>
                                    <td class="actions" data-th="">
                                        <a class="btn btn-danger btn-sm" href="?function=del&id=<?= $row['cart_id'] ?>" onclick="return confirm('Are you sure to delete!')">
                                            <i class="bi bi-trash-fill text-white"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        <?php
                        }
                        ?>
                        <tfoot>
                            <tr>
                                <td><a href="shop.php" class="btn btn-primary mb-2 mb-md-0"><i class="bi bi-caret-left-fill"></i>Keep Buying</a>
                                    <a href="?function=removeall" class="btn btn-warning" onclick="return confirm('Are you sure to clear all the cart!')"><i class="bi bi-x-circle-fill"></i> Clear cart</a>
                                </td>
                                <td colspan="2" class="hidden-xs"> </td>
                                <td class="hidden-xs text-center"><strong>Order Total $<?php echo $all ?></strong></td>
                                <td><a href="order.php" class="btn btn-success btn-block">Order Now<i class="fa fa-angle-right"></i></a></td>
                            </tr>
                        </tfoot>
                    <?php
                    } else {
                        echo "  <tr>
                                    <td colspan='5' class='me-4 text-center fw-bold'>Cart is empty</td>
                                </tr>";
                    }
                    // Delete a data
                    if (isset($_GET['id']) && isset($_GET['function']) == "del") {
                        $id = $_GET['id'];

                        // Delete product into Cart
                        $sql = "DELETE FROM cart WHERE cart_id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        echo ("<script>
                                    Swal.fire(
                                        'Removed',
                                        'A product was removed!',
                                        'success'
                                    ).then((result) => {
                                        window.location.href = 'cart.php';
                                    })
                                </script>");
                    }
                    // Delete all cart
                    if (isset($_GET['function']) == "removeall") {
                        $username = $_COOKIE['username'];
                        $sql = "DELETE FROM cart WHERE Username = '$username'";
                        $result = mysqli_query($conn, $sql);
                        if (!$result) {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        echo ("<script>
                                    Swal.fire(
                                        'Removed',
                                        'All product was removed!',
                                        'success'
                                    ).then((result) => {
                                        window.location.href = 'cart.php';
                                    })
                                </script>");
                    }
                    ?>
                </table>
            </div>
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