<?php
session_start();
session_destroy();
setcookie("username", "", time() - 3600, "/", "", true, true);
header("Location: login.php");
exit();
?>
