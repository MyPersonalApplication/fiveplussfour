<header class="d-flex flex-wrap justify-content-between py-4" style="background-color: #E0E0E0;">
    <div class="col-12 col-md-3">
        <div class="d-flex justify-content-center">
            <img title="FPFStore" onclick="location.href='index.php'" src="Image/NDQlogo.png" height="40" width="40" class="me-2" style="border-radius: 5px" role="button" />
            <form class="d-flex input-group w-auto" method="POST" action="?page=shop">
                <input name="txtSearch" type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button class="btn btn-primary searching" type="submit" name="btnSearch">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>
    <div class="col-12 col-md-auto">
        <ul class="nav justify-content-center align-items-center mt-2 mt-lg-0 mt-md-0">
            <li><a href="index.php" class="nav-link px-2 link-dark text-uppercase fw-bold">Home</a></li>
            <li><a href="shop.php" class="nav-link px-lg-4 px-sm-3 link-dark text-uppercase fw-bold">Shop</a></li>
            <!-- <li><a href="?page=contact" class="nav-link px-2 link-dark text-uppercase">Contact</a></li> -->
            <li><a href="about.php" class="nav-link px-2 link-dark text-uppercase fw-bold">About</a></li>
        </ul>
    </div>
    <div class="col-12 col-md-3">
        <?php
        if (isset($_COOKIE['username'])) {
        ?>
            <div class="nav navbar navbar-expand-md d-flex justify-content-center ps-lg-5 ps-xl-5">
                <!-- Icon -->
                <a class="text-reset me-4 ms-xl-5" href="cart.php">
                    <i class="bi bi-cart-fill"></i>
                </a>

                <!-- Avatar -->
                <div class="dropdown">
                    <a class="dropdown-toggle d-flex align-items-center text-reset" href="#" id="navbarDropdownMenuAvatar" role="button" data-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle" style="color: black;" loading="lazy"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
                        <li>
                            <a class="dropdown-item" href="">Hi, <?php echo $_COOKIE['username'] ?></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="profile.php">Profile</a>
                        </li>
                        <div class="dropdown-divider"></div>
                        <li>
                            <a class="dropdown-item" href="logout.php" onclick="return confirm('Are you sure to logout?')">Log out</a>
                        </li>
                    </ul>
                </div>

            </div>
        <?php
        } else {
        ?>
            <div class="mt-2 mt-lg-0 mt-md-0">
                <div class="d-flex justify-content-center">
                    <a href="login.php" class="btn btn-outline-primary me-2" class="btn btn-outline-primary" role="button">
                        Login
                    </a>
                    <a href="register.php" class="btn btn-primary" class="btn btn-outline-primary" role="button">
                        Sign-up
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</header>