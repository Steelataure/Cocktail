<?php
ob_start();
session_start();

include '../config/config.php';


$content = ob_get_clean();
include 'layout.php';
include 'footer.php';
?>
