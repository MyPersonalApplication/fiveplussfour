<footer class="text-center bg-light text-muted">
    <!-- Section: Social media -->
    <div class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
        <!-- Left -->
        <div class="me-5 d-none d-md-block mx-md-4">
            <span>Get connected with us on social networks:</span>
        </div>

        <!-- Right -->
        <div class="mx-md-3">
            <a href="https://www.facebook.com/nguyenduyquang02/" target="blank" class="me-4 figure" style="color: #3b5998">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="https://twitter.com/?lang=en" target="blank" class="me-4 figure" style="color: #1da1f2">
                <i class="bi bi-twitter"></i>
            </a>
            <a href="https://www.instagram.com/?hl=en" target="blank" class="me-4 figure" style="color: #d6249f">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="https://www.pinterest.com/" target="blank" class="me-0 figure" style="color: #bd081c">
                <i class="bi bi-pinterest"></i>
            </a>
        </div>
    </div>

    <div class="text-center text-md-start mt-5">
        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-4">
                <div class="mx-5 text-center">
                    <!-- Content -->
                    <h6 class="text-uppercase fw-bold mb-4">
                        <i class="bi bi-gem me-2"></i>FPF STORE
                    </h6>
                    <p>
                        FPF Store was founded in 2022. Our store offers a
                        huge collection of unisex. What are you waiting for?
                        Start shopping online today.
                    </p>
                </div>
            </div>

            <!-- Grid column -->
            <div class="col-md-4">
                <div class="text-center">
                    <h6 class="text-uppercase fw-bold mb-4">Brands</h6>
                    <?php
                    $result = mysqli_query($conn, "SELECT c.CatID, c.CatName , COUNT(c.CatID), SUM(Qty)
                                              FROM orderdetail o RIGHT JOIN product p
                                              ON o.ProID = p.ProID INNER JOIN category c
                                              ON p.CatID = c.CatID
                                              GROUP BY c.CatID
                                              ORDER BY SUM(Qty)
                                              DESC
                                              LIMIT 4");

                    if (!$result) {
                        die('Invalid query: ' . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    ?>
                        <p>
                            <a href="?page=shop&id=<?php echo $row['CatID'] ?>" class="text-reset text-decoration-none"><?php echo $row['CatName'] ?></a>
                        </p>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Grid column -->
            <div class="col-md-4">
                <div class="mx-5 text-center">
                    <!-- Links -->
                    <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
                    <p>
                        <i class="bi bi-house-door me-2"></i>Xuan Khanh, Ninh Kieu, Can Tho
                    </p>
                    <p>
                        <i class="bi bi-envelope me-2"></i>quangndgcc200030@fpt.edu.vn
                    </p>
                    <p><i class="bi bi-telephone me-2"></i>+84 916 843 367</p>
                    <p><i class="bi bi-telephone me-2"></i>+84 327 281 160</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05)">© 2022 Copyright:
        <a class="text-reset fw-bold" href="index.php">FPFStore.com</a>
    </div>
</footer>