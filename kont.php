<?php 
require_once("xpanel/inc/vt.php");



if ($_POST['size']) {
	$size = $_POST['size'];

  $product_serving  = $dbh->prepare("SELECT * FROM product_serving where id=?  ");
  $product_serving-> execute(array($size));
  $product_serving  = $product_serving->fetch(PDO::FETCH_OBJ);


  if($product_serving->stok>0){?>
    <input type="hidden" name="size" value="<?= $product_serving->id?>">
    <button class="btn btn-primary btn-cart">
      <i class="w-icon-cart"></i>
      <span>Sepete Ekle</span>
    </button>
  <?php }else{?>


    <div class="col-md-12 mb-4">
      <div class="alert alert-danger alert-dark alert-round alert-inline">
        <h4 class="alert-title">UYARI :</h4>
        Bu üründe stok tükendi...
        
      </div>
    </div>
  <?php }?>
  <?php }?>