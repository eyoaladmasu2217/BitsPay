<?php
echo "Running all migration scripts...<br>";

include "usrtbl.php";
include "createprgrmtbl.php";
include "studenttbl.php";
include "tution_feetbl.php";
include "transactiontbl.php";
include "wallet.php";
include "wallettransactiontbl.php";
echo "All migration scripts executed successfully.<br>";


?>
