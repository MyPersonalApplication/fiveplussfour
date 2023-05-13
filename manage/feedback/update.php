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
        <?php
        include_once("connectdatabase.php");
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $result = mysqli_query($conn, "SELECT * FROM feedback WHERE FeedID = '$id'");
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $feed_id = $row["FeedID"];
            $feed_content = $row["Content"];
            $feed_state = $row["state"];
            $feed_us = $row["Username"];
            $feed_proid = $row["ProID"];
        ?>
            <div class="container border my-2">
                <div class="m-5">
                    <h2 class="text-center mb-4">Updating Feedback</h2>
                    <form id="formUpdatefeed" name="formUpdatefeed" method="post">
                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatID">Feed ID:</label>
                            <input type="text" name="txtFeedID" class="form-control" readonly value='<?php echo $feed_id; ?>' />
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label mb-1 fw-bold" for="txtCatName">Content:</label>
                            <input type="text" class="form-control" readonly value='<?php echo $feed_content ?>' />
                        </div>

                        <div class="row">
                            <div class="form-outline mb-3 col-md-4">
                                <label class="form-label mb-1 fw-bold" for="txtCatDesc">State:</label>
                                <input type="number" name="txtstate" min="0" max="1" id="txtstate" class="form-control" value='<?php echo $feed_state ?>' />
                            </div>

                            <div class="form-outline mb-3 col-md-4">
                                <label class="form-label mb-1 fw-bold" for="txtCatDesc">Username:</label>
                                <input type="text" class="form-control" readonly value='<?php echo $feed_us ?>' />
                            </div>

                            <div class="form-outline mb-3 col-md-4">
                                <label class="form-label mb-1 fw-bold" for="txtCatDesc">Product ID:</label>
                                <input type="text" class="form-control" readonly value='<?php echo $feed_proid ?>' />
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="">
                                <input type="submit" class="btn btn-primary" name="btnUpdate" id="btnUpdate" value="Update" />
                                <input type="button" class="btn btn-primary" name="btnIgnore" id="btnIgnore" value="Ignore" onclick="window.location='?page=update_cbshow&&id=<?php echo $feed_id; ?>'" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
<?php
            if (isset($_POST["btnUpdate"])) {
                $id = $_POST["txtFeedID"];
                $state = $_POST["txtstate"];

                mysqli_query($conn, "UPDATE feedback SET state = '$state' WHERE FeedID = '$id'");
                echo '<meta http-equiv="refresh" content = "0; URL=?page=feedback_management"/>';
            }
        } else {
            echo '<meta http-equiv="refresh" content = "0; URL=?page=feedback_management"/>';
        }
    }
}
?>