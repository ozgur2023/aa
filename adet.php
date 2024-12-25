<?php 
require_once("xpanel/inc/vt.php");

$id=$_POST['id'];
$adet=$_POST['adet'];

$_SESSION['sepet'][$id]['qty']=$adet;



?>
?>