<?php
if (isset($_SESSION['us']) == false) {
    echo "<script>alert('You need to login before accessing this page')</script>";
    echo '<meta http-equiv="refresh" content = "0; URL=?page=login"/>';
} else {
    if (isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
        echo "<script>alert('You are administrator that cant not access this page')</script>";
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
            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                mysqli_query($conn, "DELETE FROM feedback WHERE FeedID = '$id'");
            }
        }
        ?>

        <div class="container border my-2">
            <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                <h1 class="text-center">Order Management</h1>
                <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th><strong>No.</strong></th>
                            <th><strong>Content</strong></th>
                            <th><strong>State</strong></th>
                            <th><strong>Send Date</strong></th>
                            <th><strong>Username</strong></th>
                            <th><strong>Product ID</strong></th>
                            <th><strong>Show</strong></th>
                            <th><strong>Delete</strong></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $No = 1;
                        $sq = "SELECT * FROM feedback ORDER BY sendDate DESC";
                        $res = mysqli_query($conn, $sq);
                        if (!$res) {
                            die('Invalid query: ' . mysqli_error($conn));
                        }
                        while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $No ?></td>
                                <td><?php echo $row["Content"]; ?></td>
                                <td align="center"><?php echo $row["state"]; ?></td>
                                <td align="center"><?php echo $row["sendDate"]; ?></td>
                                <td><?php echo $row["Username"]; ?></td>
                                <td align="center"><?php echo $row["ProID"]; ?></td>
                                <td style='text-align:center'>
                                    <a href="?page=update_cbshow&&id=<?php echo $row["FeedID"]; ?>">
                                        <i class="bi bi-pen-fill" style="color: black;"></i>
                                    </a>
                                </td>
                                <td style='text-align:center'>
                                    <a href="?page=feedback_management&&function=del&&id=<?php echo $row["FeedID"] ?>" onclick="return deleteConfirm()">
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