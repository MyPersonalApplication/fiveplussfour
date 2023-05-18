<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    .font-family {
        font-family: 'Roboto', sans-serif;
    }

    a.list-group-item {
        background-color: rgb(180, 180, 180);
    }

    a.list-group-item:hover {
        background-color: black
    }
</style>
<div class="col-lg-2 col-md-3 content-left pe-0">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light justify-content-center">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu"><span class="navbar-toggler-icon"></span></button>

        <!-- Brand -->
        <a class="font-family nav-link mt-2" href="../../manage/order/index.php">
            <h3 class="fw-bold">Administration</h3>
        </a>
    </nav>
    <!-- Navbar -->
    <nav id="sidebarMenu" class="collapse d-md-block">
        <div class="position-sticky">
            <div class="font-family list-group list-group-flush">
                <a href="../../manage/order/index.php" class="list-group-item list-group-item-action py-4 text-light">Order
                    management</a>
                <a href="../../manage/category/index.php" class="list-group-item list-group-item-action py-4 text-light">Category
                    management</a>
                <a href="../../manage/product/index.php" class="list-group-item list-group-item-action py-4 text-light">Product
                    management</a>
                <a href="../../manage/feedback/index.php" class="list-group-item list-group-item-action py-4 text-light">Feedback
                    management</a>
                <a href="../../logout.php" class="list-group-item list-group-item-action py-4 text-light" onclick="return confirm('Are you sure to logout?')">Logout</a>
            </div>
        </div>
    </nav>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>