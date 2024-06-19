<?php
   include("php/config.php");
session_start();
session_destroy();

echo "Current Directory: " . getcwd();

$target = "../../index.php";
if (file_exists($target)) {
    echo "Target exists: " . $target;
} else {
    echo "Target does not exist: " . $target;
}

header("Location: ../../index.php");
exit();
?>
