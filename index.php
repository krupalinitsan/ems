<?php

if (isset($_SESSION['IS_LOGIN'])) {
    header('location:dashboard.php');
} else {
    header('location:login.php');
}

?>