<?php
if (isset($_COOKIE['username'])) {
    echo ("<script>
                Swal.fire(
                'Access Denied',
                'You are logged in!',
                'warning'
                ).then((result) => {
                    window.location.href = 'index.php';
                  })
            </script>");
    // header("Location: login.php");
    // exit();
}
