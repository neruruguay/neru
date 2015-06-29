<?php

session_start();

//include('dbcon.php');
//echo $_GET['code'].'--'.$_SESSION['random_number'].'<br>';

if (isset($_GET['code']) && strtolower($_GET['code']) == strtolower($_SESSION['random_number'])) {
    echo 1; // submitted 
} else {
    echo 0; // invalid code
}
?>
