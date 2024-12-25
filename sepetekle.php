<?php 
require_once("xpanel/inc/vt.php");



if ($_POST['tip']) {
	$tip = $_POST['tip'];
	switch ($tip) {
		case 'ekle':

        if($_POST['qty']<1){
            echo "Adet";
            exit();
        }
        $urunid=$_POST['id'];
        $alt = $dbh->query("select * from product_serving WHERE parent = {$urunid}  ", PDO::FETCH_ASSOC);
        $sayy=0;
        foreach ($alt as $alt) {
            $sayy+=$alt['stok'];
        }

        if($sayy>0 && !$_POST['size'] ){
            echo "sec";
            exit();
        }
       /* if (is_array($_SESSION['sepet'][$_POST['urunid']])) {
        $_SESSION['sepet'][$_POST['urunid']]['qty']['menu_porsiyon']+= $_POST['qty']['urunid']['menu_porsiyon'];
    } else {*/

        if($_POST['size']){

           $stokk   =   $dbh->prepare("SELECT * FROM product_serving  where id=?  ");
           $stokk    -> execute(array($_POST['size']));
           $stokk    =   $stokk  -> fetch(PDO::FETCH_OBJ);
           if($stokk->stok<$_POST['qty']){
            echo $stokk->stok;
            exit();
        }
    }





    $_SESSION['sepet'][] = $_POST;

    if ($_POST['tasarim'] == 'true') {
        echo "godesign";
    }else{echo "ok";}



    break;

    case 'sil':
    $id = $_POST['id'];
    unset($_SESSION['sepet'][$id]);
    break;

}


//header("location:".htmlspecialchars($_SERVER['HTTP_REFERER']));

}
if ($_GET['tip']) {
   $tipp = $_GET['tip'];
   switch ($tipp) {

      case 'sil':
      $id = $_GET['urun'];


      unset($_SESSION['sepet'][$id]);
      break;
  }

  header("location:".htmlspecialchars($_SERVER['HTTP_REFERER']));

}

