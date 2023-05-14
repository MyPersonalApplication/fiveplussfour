<?php
include_once("../../connectDB.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FPF - Manage Category</title>

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
            if (isset($_GET["function"]) == "del" && isset($_GET["id"])) {
                $id = $_GET["id"];
                $sq = "SELECT Cat_image FROM category WHERE CatID = '$id'";
                $res = mysqli_query($conn, $sq);
                if (mysqli_num_rows($res) == 1) {
                    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
                    $filePic = $row['Cat_image'];
                    unlink("../../Category/" . $filePic);
                    mysqli_query($conn, "DELETE FROM product WHERE CatID = '$id'");
                    mysqli_query($conn, "DELETE FROM category WHERE CatID = '$id'");
                }
                echo '<meta http-equiv="refresh" content = "0; URL=./"/>';
            }
            ?>
            <div class="col-lg-10 col-md-9 col-12">
                <form name="frm" method="post" action="" class="mt-3 mx-md-2">
                    <h1 class="text-center">Manage Category</h1>
                    <div class="text-center mb-2">
                        <a href="add.php" class="btn btn-outline-primary">
                            <img src="../../Image/add.png" alt="Add new" width="16" height="16" border="0" />Add
                        </a>
                    </div>
                    <table id="tablecategory" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th><strong>No.</strong></th>
                                <th><strong>Category Name</strong></th>
                                <th><strong>Description</strong></th>
                                <th><strong>Image</strong></th>
                                <th><strong>Edit</strong></th>
                                <th><strong>Delete</strong></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $No = 1;
                            $result = mysqli_query($conn, "SELECT * FROM category");
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $No; ?></td>
                                    <td><?php echo $row["CatName"]; ?></td>
                                    <td><?php echo $row["CatDesc"]; ?></td>
                                    <td class="text-center">
                                        <img src='../../Category/<?php echo $row["Cat_image"] ?>' border='0' width="100" height="50" />
                                    </td>
                                    <td style='text-align:center'>
                                        <a href="update.php?id=<?php echo $row["CatID"]; ?>">
                                            <i class="bi bi-pen-fill" style="color: black;"></i>
                                        </a>
                                    </td>
                                    <td style='text-align:center'>
                                        <a href="?function=del&id=<?php echo $row["CatID"] ?>" onclick="return deleteConfirm()">
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