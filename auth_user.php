<?php
if (!isset($_COOKIE['username']) || $_COOKIE['admin']) {
    echo ("<script>
                Swal.fire(
                'Access Denied',
                'Please log in with user account to continue!',
                'warning'
                ).then((result) => {
                    window.location.href = 'login.php';
                  })
            </script>");
}
