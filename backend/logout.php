<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php?logged_out=1");
exit();
?>