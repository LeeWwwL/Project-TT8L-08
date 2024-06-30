<?php
include("config.php");
session_start();
session_destroy();

// Redirect before any output
header("Location: ../../index.php");
exit();

echo "Current Directory: " . getcwd();

$target = "../../index.php";
if (file_exists($target)) {
    echo "Target exists: " . $target;
} else {
    echo "Target does not exist: " . $target;
}
?>

