<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Manage Feedback</title>

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
            if (isset($_POST['btnUpdateFeedback']) && $_POST['txtupdateFeed'] == 1) {
                $id = $_POST['txtIDFeed'];
                mysqli_query($conn, "UPDATE feedback SET state = 0 WHERE FeedID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
                echo '<meta http-equiv="refresh" content = "0; URL="/>';
            }
            if (isset($_POST['btnUpdateFeedback']) && $_POST['txtupdateFeed'] == 0) {
                $id = $_POST['txtIDFeed'];
                mysqli_query($conn, "UPDATE feedback SET state = 1 WHERE FeedID = '$id'") or die('Invalid query: ' . mysqli_error($conn));
                echo '<meta http-equiv="refresh" content = "0; URL="/>';
            }
            // Delete feedback
            if (isset($_GET["function"]) == "del" && isset($_GET["id"])) {
                $id = $_GET["id"];
                mysqli_query($conn, "DELETE FROM feedback WHERE FeedID = '$id'");
                echo '<meta http-equiv="refresh" content = "0; URL="/>';
            }
            ?>

            <div class="col-lg-10 col-md-9 col-12">
                <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                    <h1 class="text-center">Manage Feedback</h1>
                    <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th><strong>No.</strong></th>
                                <th><strong>Content</strong></th>
                                <th><strong>Send Date</strong></th>
                                <th><strong>Username</strong></th>
                                <th><strong>Product Name</strong></th>
                                <th><strong>Image</strong></th>
                                <th><strong>Show</strong></th>
                                <th><strong>Delete</strong></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $No = 1;
                            $sq = "SELECT * FROM feedback f INNER JOIN product p ON f.ProID = p.ProID ORDER BY sendDate DESC";
                            $res = mysqli_query($conn, $sq);
                            if (!$res) {
                                die('Invalid query: ' . mysqli_error($conn));
                            }
                            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?= $No ?></td>
                                    <td><?= $row["Content"]; ?></td>
                                    <td class="text-center"><?= $row["sendDate"]; ?></td>
                                    <td><?= $row["Username"]; ?></td>
                                    <td class="text-center"><?= $row["ProName"]; ?></td>
                                    <td class="text-center">
                                        <img src='../../Product/<?= $row["Pro_image"] ?>' border='0' width="100" />
                                    </td>
                                    <td style='text-align:center'>
                                        <form action="" method="POST">
                                            <input type="hidden" id="txtIDFeed" name="txtIDFeed" value="<?= $row['FeedID']; ?>">
                                            <input type="hidden" id="txtupdateFeed" name="txtupdateFeed" value="<?= $row['state']; ?>">
                                            <?php
                                            if ($row['state'] == 1) {
                                            ?>
                                                <button type="submit" class="btn btn-success" name="btnUpdateFeedback">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            <?php
                                            } else {
                                            ?>
                                                <button type="submit" class="btn btn-danger" name="btnUpdateFeedback">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            <?php
                                            }
                                            ?>
                                        </form>
                                    </td>
                                    <td style='text-align:center'>
                                        <a href="?function=del&id=<?= $row["FeedID"] ?>" onclick="return deleteConfirm()">
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