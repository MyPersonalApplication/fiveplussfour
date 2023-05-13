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
            if (isset($_GET["function"]) == "del") {
                if (isset($_GET["id"])) {
                    $id = $_GET["id"];
                    mysqli_query($conn, "DELETE FROM feedback WHERE FeedID = '$id'");
                }
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
                                    <td class="text-center"><?php echo $row["state"]; ?></td>
                                    <td class="text-center"><?php echo $row["sendDate"]; ?></td>
                                    <td><?php echo $row["Username"]; ?></td>
                                    <td class="text-center"><?php echo $row["ProID"]; ?></td>
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