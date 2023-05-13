<?php
if (!isset($_COOKIE['username'])) {
    echo ("<script>
                Swal.fire(
                'Access Denied',
                'Please log in to continue!',
                'warning'
                ).then((result) => {
                    window.location.href = 'login.php';
                  })
            </script>");
}
