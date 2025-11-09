<?php
session_start();
session_unset();  /*remove all temporary datas*/ 
session_destroy();
header("Location: login.php");
exit();
?>