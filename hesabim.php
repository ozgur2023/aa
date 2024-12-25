<?php include 'includes/header.php';?>
<title>Hesabım</title> 
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>
<?php if(empty($_SESSION["login"]) && empty($_COOKİE['login'])){ 
    header("location:musteri-girisi");
    exit();
} ?>


<?php
if (isset($_POST['hesap'])){
    $name           =   $_POST["name"];
    $mail           =   $_POST["mail"];
    $eskisifre      =   md5($_POST["current_password"]);
    $yeni           =   $_POST["new_password"];
    $tekrar         =   $_POST["confirm_password"];


    $msorgu     =   $dbh->prepare("SELECT * FROM users WHERE mail=? and id!=?");
    $msorgu     ->  execute(array($mail,$user['id']));
    $sifrekont     =   $dbh->prepare("SELECT * FROM users WHERE password=? and id!=?");
    $sifrekont     ->  execute(array(md5($eskisifre),$user['id']));

    if(!filter_var($mail,FILTER_VALIDATE_EMAIL)) {
        $sonuc= "Girdiğiniz mail formatı hatalı.";
    }elseif($msorgu->rowCount()){
        $sonuc= "Bu mail adresi daha önce kullanılmış.";

    }elseif($sifrekont->rowCount() && !empty($eskisifre)){
        $sonuc= "Eski Şifreniz Hatalı.";

    }else{
        if($yeni!=$tekrar && !empty($yeni)  && !empty($tekrar)){
            $sonuc= "Şifreler Uyuşmamakta.";
            $hata=1;

        }elseif (strlen($yeni)<6 && !empty($yeni)) {
            $sonuc= "Parolanız en az 6 karakterden oluşmalı.";
            $hata=1;


        }elseif(!empty($yeni)){

            $update =   $dbh->prepare("UPDATE users SET  password=? where id=?");
            $update-> execute(array(md5($_POST["current_password"]),$user['id']));
            $sonuc= "Düzenleme Başarılı.";

        }

        if($hata!=1){
            $insert =   $dbh->prepare("UPDATE users SET name=?, mail=? where id=?");
            $insert-> execute(array($name,$mail,$user['id']));
            $sonuc= "Düzenleme Başarılı.";
        }
    }

}?>


<?php
if (isset($_POST['adres'])){
    $ulke=$_POST["ulke"];
    $sokak=$_POST["sokak"];
    $sehir=$_POST["sehir"];
    $ilce=$_POST["ilce"];
    $sirket=$_POST["sirket"];
    $posta=$_POST["posta"];
    $aadres=$_POST["aadres"];
    $update =   $dbh->prepare("UPDATE users SET aadres=?,sirket=?,ulke=?, sehir=?,ilce=?,sokak=?,posta=? where id=?");
    $update-> execute(array($aadres,$sirket,$ulke,$sehir,$ilce,$sokak,$posta,$user['id']));
    header("Refresh: 0;");


}?>
<style type="text/css">




/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.containerm {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}

@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
 }
 .cancelbtn {
     width: 100%;
 }
}
</style>  
<!-- Start of Main -->
<main class="main">
    <!-- Start of Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">Hesabım</h1>
        </div>
    </div>
    <!-- End of Page Header -->

    <?php if($sonuc){echo $sonuc;} ?>
    <?php 

    $sipler = $dbh -> prepare("SELECT * FROM product_order WHERE uye = ? order by id desc");
    $sipler-> execute(array($user['id']));
    $sipler = $sipler->fetchAll(PDO::FETCH_OBJ);
    foreach ($sipler as $sip) { ?>

        <div id="id01<?=$sip->sipno;?>" class="modal">

          <form class="modal-content animate" >
            <div class="imgcontainer">
              <span onclick="document.getElementById('id01<?=$sip->sipno;?>').style.display='none'" class="close" title="Close Modal">&times;</span>
          </div>

          <div class="containerm">
            <table class="order-details-table">
                <thead>
                    <tr class="summary-subtotal">
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $toplam2=0;
                    $sipp = json_decode($sip->sip);
                    $_SESSION['sepett']=$sipp;

                    foreach ($_SESSION['sepett'] as $siparis => $siparisdetay) {
                        $array=$siparisdetay;
                        $urun_getir = $dbh -> prepare("SELECT * FROM product WHERE id = ?");
                        $urun_getir-> execute(array($siparisdetay->id));
                        $urun = $urun_getir->fetch(PDO::FETCH_ASSOC);

                        $fiyat = $urun["product_price"];

                        $baslikseo  = seo( $urun['product_name']); 

                        $toplam = $fiyat  ;  
                        $toplamu = $fiyat*$siparisdetay->qty  ;  
                        $toplam2 += $toplamu;

                        ?>
                        <tr>
                            <td class="product-name"><?=$urun["product_name"];?> <span> <i class="fas fa-times"></i> <?=$siparisdetay->qty?></span></td>
                            
                            <td class="product-price"> <?=$toplamu?> TL</td>
                        </tr>
                    <?php } ?>

                    <tr class="summary-subtotal">
                        <td >

                        </td>

                        <td style="    float: right;">
                            <h4 class="summary-subtitle"><?php echo $dil['013'];?> : <?=$toplam2?> TL</h4>
                        </td>                                                   
                    </tr>

                    <tr class="summary-subtotal">
                        <td >
                            <h4 class="summary-subtitle"><?php echo $dil['058'];?> :

                                <?php if($sip->status == 0){
                                    echo ' Bekliyor';
                                }else if ($sip->status == 1) {
                                    echo ' Yapılıyor';
                                }else if ($sip->status == 2) {
                                    echo 'Tamamlandı';
                                }else if ($sip->status == 3) {
                                    echo 'İptal Edildi';
                                }
                                ?>
                            </h4>
                        </td>
                        <td style="    float: right;">
                            <h4 class="summary-subtitle"><?php echo $dil['061'];?>: <?php if($sip->odeme_tip==0){echo "Online Ödeme";}elseif($sip->odeme_tip==1){echo "Havale Eft";}else{echo "Kapıda Ödeme";} ?>
                            /
                            <?php if ($sip->payment==1) {echo "Ödendi";}else{echo"Ödenmedi";} ?>
                        </h4>
                    </td>

                </tr>
            </tbody>
        </table>
    </div>


</form>
</div>

<?php } ?>
<!-- Start of PageContent -->
<div class="page-content pt-2">
    <div class="container">
        <div class="tab tab-vertical row gutter-lg">
            <ul class="nav nav-tabs mb-6" role="tablist" style="background-color: #eee;">
                <br>
                <li class="nav-item">
                    <a href="#account-dashboard" class="nav-link active" style="background-color: #fff;">MÜŞTERİ PANELİ</a>
                </li>
                <li class="nav-item">
                    <a href="#account-orders" class="nav-link" style="background-color: #fff;">SATIN ALDIKLARIM</a>
                </li>
                <li class="nav-item">
                    <a href="#account-downloads" class="nav-link" style="background-color: #fff;">FAVORİLERİM</a>
                </li>
                <li class="nav-item">
                    <a href="#account-addresses" class="nav-link" style="background-color: #fff;">ADRESLERİM</a>
                </li>
                <li class="nav-item">
                    <a href="#account-details" class="nav-link" style="background-color: #fff;">PROFİL BİLGİLERİM</a>
                </li>

            </ul>

            <div class="tab-content mb-6">
                <div class="tab-pane active in" id="account-dashboard">
                    <p class="greeting">
                        Hoş geldiniz
                        <span class="text-dark font-weight-bold"><?=$user['name']?>;</span>

                    </p>

                    <p class="mb-4">
                        Değerli kullanıcımız bu panel üzerinden tüm işlemlerinizi kolaylıkla gerçekleştirebilirsiniz.
                    </p>

                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                            <a href="#account-orders" class="link-to-tab">
                                <div class="icon-box text-center">
                                    <span class="icon-box-icon icon-orders">
                                        <i class="w-icon-orders"></i>
                                    </span>
                                    <div class="icon-box-content">
                                        <p class="text-uppercase mb-0">SATIN ALDIKLARIM</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                            <a href="#account-downloads" class="link-to-tab">
                                <div class="icon-box text-center">
                                  <span class="icon-box-icon icon-wishlist">
                                    <i class="w-icon-heart"></i>
                                </span>
                                <div class="icon-box-content">
                                    <p class="text-uppercase mb-0">FAVORİ ÜRÜNLERİM</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                        <a href="#account-addresses" class="link-to-tab">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon icon-address">
                                    <i class="w-icon-map-marker"></i>
                                </span>
                                <div class="icon-box-content">
                                    <p class="text-uppercase mb-0">ADRESLERİM</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                        <a href="#account-details" class="link-to-tab">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon icon-account">
                                    <i class="w-icon-user"></i>
                                </span>
                                <div class="icon-box-content">
                                    <p class="text-uppercase mb-0">HESAP BİLGİLERİM</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">
                        <a href="cikis.php">
                            <div class="icon-box text-center">
                                <span class="icon-box-icon icon-logout">
                                    <i class="w-icon-logout"></i>
                                </span>
                                <div class="icon-box-content">
                                    <p class="text-uppercase mb-0">OTURUMU KAPAT</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-6 mb-4">

                    </div>
                </div>
            </div>

            <div class="tab-pane mb-4" id="account-orders">
                <div class="icon-box icon-box-side icon-box-light">
                    <span class="icon-box-icon icon-orders">
                        <i class="w-icon-orders"></i>
                    </span>
                    <div class="icon-box-content">
                        <h4 class="icon-box-title text-capitalize ls-normal mb-0">SATIN ALDIĞIM ÜRÜNLER</h4>
                    </div>
                </div>


                <table class="shop-table account-orders-table mb-6">
                    <thead>
                        <tr>
                            <th class="order-id">Sipariş No</th>
                            <th class="order-date">Sipariş Tarihi</th>
                            <th class="order-status">Sipariş Durumu</th>
                            <th class="order-total">Tutar</th>
                            <th class="order-actions">Detay</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php 

                       $sipler = $dbh -> prepare("SELECT * FROM product_order WHERE uye = ? order by id desc");
                       $sipler-> execute(array($user['id']));
                       $sipler = $sipler->fetchAll(PDO::FETCH_OBJ);
                       if(count($sipler)>0){
                        foreach ($sipler as $sip) { ?>



                            <tr>
                                <td class="order-id">#<?=$sip->sipno;?></td>
                                <td class="order-date">August 20, 2021</td>
                                <td class="order-status">

                                    <?php if($sip->status == 0){
                                        echo ' Bekliyor';
                                    }else if ($sip->status == 1) {
                                        echo ' Yapılıyor';
                                    }else if ($sip->status == 2) {
                                        echo 'Tamamlandı';
                                    }else if ($sip->status == 3) {
                                        echo 'İptal Edildi';
                                    }
                                    ?>

                                    <?php if($sip->odeme_tip==0){echo "Online Ödeme";}elseif($sip->odeme_tip==1){echo "Havale Eft";}else{echo "Kapıda Ödeme";} ?>
                                    /
                                    <?php if ($sip->payment==1) {echo "Ödendi";}else{echo"Ödenmedi";} ?>
                                </td>
                                <td class="order-total">
                                    <span class="order-price"><?=para($sip->total_amount)?></span> 
                                </td>
                                <td class="order-action">
                                    <a  class="btn btn-outline btn-default btn-block btn-sm btn-rounded" onclick="document.getElementById('id01<?=$sip->sipno;?>').style.display='block'">Detay</a>
                                </td>
                            </tr>


                        <?php } ?>





                        <?php  }else{echo ' <p class=" b-2">'.$dil['069'].'</p>

                        <a href="anasayfa" class="btn btn-primary">'.$dil['070'].'</a>

                        ';} ?>
                               <!--  <tr>
                                    <td class="order-id">#2321</td>
                                    <td class="order-date">August 20, 2021</td>
                                    <td class="order-status">Processing</td>
                                    <td class="order-total">
                                        <span class="order-price">$150.00</span> for
                                        <span class="order-quantity"> 1</span> item
                                    </td>
                                    <td class="order-action">
                                        <a href="#"
                                        class="btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order-id">#2319</td>
                                    <td class="order-date">August 20, 2021</td>
                                    <td class="order-status">Processing</td>
                                    <td class="order-total">
                                        <span class="order-price">$201.00</span> for
                                        <span class="order-quantity"> 1</span> item
                                    </td>
                                    <td class="order-action">
                                        <a href="#"
                                        class="btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="order-id">#2318</td>
                                    <td class="order-date">August 20, 2021</td>
                                    <td class="order-status">Processing</td>
                                    <td class="order-total">
                                        <span class="order-price">$321.00</span> for
                                        <span class="order-quantity"> 1</span> item
                                    </td>
                                    <td class="order-action">
                                        <a href="#"
                                        class="btn btn-outline btn-default btn-block btn-sm btn-rounded">View</a>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>

                        <a href="shop-banner-sidebar.html" class="btn btn-dark btn-rounded btn-icon-right">Go
                            Shop<i class="w-icon-long-arrow-right"></i></a>
                        </div>

                        <div class="tab-pane" id="account-downloads">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-downloads mr-2">
                                    <i class="w-icon-download"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title ls-normal">FAVORİ ÜRÜNLERİM</h4>
                                </div>
                            </div>
                           

                            <table class="shop-table account-orders-table mb-6">
                                <thead>
                                    <tr>
                                        <td class="text-center">Resim</td>
                                        <td class="text-left">Ürün</td>
                                        <td class="text-center">Ürün Detay</td>
                                    </tr>
                                </thead>
                                <tbody>
                                   <?php 

                                   $favlar = $dbh -> prepare("SELECT * FROM wishlist WHERE user = ? order by id desc");
                                   $favlar-> execute(array($user['id']));
                                   $wls = $favlar->fetchAll(PDO::FETCH_OBJ);
                                   if(count($wls)>0){
                                      foreach ($wls as $wl) {
                                        $ur   =   $dbh->prepare("SELECT * FROM product  where id=? ");
                                        $ur   -> execute(array($wl->product));
                                        $ur    =   $ur   -> fetch(PDO::FETCH_OBJ);

                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <a href="urun/<?=$ur->seo_name?>"><img width="85" style="height: 93px;object-fit: contain;" class="img-thumbnail" title="Aspire Ultrabook Laptop" alt="Aspire Ultrabook Laptop" src="img/<?=$ur->foto?>">
                                                </a>
                                            </td>
                                            <td class="text-left"><a href="urun/<?=$ur->seo_name?>"><?=$ur->product_name?></a>
                                            </td>
                                            <td class="text-center"><a class="btn btn-info" title="" data-toggle="tooltip" href="urun/<?=$ur->seo_name?>" data-original-title="View"><i class="fa fa-eye"></i></a>


                                            </td>
                                        </tr>
                                    <?php } ?>




                                    <?php  }else{echo '  <p class="mb-4">Favorilere eklenmiş bir ürün bulunamadı</p>

                                    <a href="anasayfa" class="btn btn-primary">'.$dil['070'].'</a>

                                    ';} ?>

                                </tbody>
                            </table>

                            <a href="kategorilerimiz" class="btn btn-dark btn-rounded btn-icon-right">ÜRÜNLERE GÖZ AT<i class="w-icon-long-arrow-right"></i></a>
                        </div>

                        <div class="tab-pane" id="account-addresses">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-map-marker">
                                    <i class="w-icon-map-marker"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">Sipariş Adres Bilgilerim</h4>
                                </div>
                            </div>
                            <br>

                            <form class="form account-details-form" action=""  method="post">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Şirket Unvanı (varsa)</label>
                                            <input type="text" id="lastname" value="<?=$user['sirket']?>" name="sirket"
                                            class="form-control form-control-md">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Ülke</label>
                                            <input type="text" id="lastname" value="<?=$user['ulke']?>" name="ulke"
                                            class="form-control form-control-md">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Şehir</label>
                                            <input type="text" id="lastname" value="<?=$user['sehir']?>" name="sehir"
                                            class="form-control form-control-md">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">İlçe</label>
                                            <input type="text" id="lastname" value="<?=$user['ilce']?>" name="ilce"
                                            class="form-control form-control-md">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Posta Kodu</label>
                                            <input type="text" id="lastname" value="<?=$user['posta']?>" name="posta"
                                            class="form-control form-control-md">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">Açık adres</label>
                                            <input type="text" id="lastname" value="<?=$user['aadres']?>" name="aadres"
                                            class="form-control form-control-md">
                                        </div>
                                    </div>


                                </div>


                                <button type="submit" name="adres" class="btn btn-dark btn-rounded btn-sm mb-4">Kaydet</button>
                            </form>

                        </div>

                        <div class="tab-pane" id="account-details">
                            <div class="icon-box icon-box-side icon-box-light">
                                <span class="icon-box-icon icon-account mr-2">
                                    <i class="w-icon-user"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title mb-0 ls-normal">Üyelik Bilgilerim</h4>
                                </div>
                            </div>
                            <form class="form account-details-form" action="" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">İsim Soyisim *</label>
                                            <input type="text" id="firstname" value="<?=$user['name']?>" name="name"
                                            class="form-control form-control-md" required="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lastname">E-Mail Adresiniz *</label>
                                            <input type="text" id="lastname" value="<?=$user['mail']?>" name="mail"
                                            class="form-control form-control-md" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname">Telefon Numaranız *</label>
                                            <input type="text" id="lastname" value="<?=$user['phone']?>" disabled name="phone"
                                            class="form-control form-control-md" required="">
                                        </div>
                                    </div>



                                </div>



                                <h4 class="title title-password ls-25 font-weight-bold">Şifrenizi Değiştirin</h4>
                                <div class="form-group">
                                    <label class="text-dark" for="new-password">Eski Şifreniz Şifreniz</label>
                                    <input type="password" class="form-control form-control-md"
                                    id="current_password" name="current_password">
                                </div>
                                <div class="form-group">
                                    <label class="text-dark" for="new-password">Yeni Şifreniz</label>
                                    <input type="password" class="form-control form-control-md"
                                    id="new-password" name="new_password">
                                </div>
                                <div class="form-group mb-10">
                                    <label class="text-dark" for="conf-password">Tekrar Yeni Şifreniz</label>
                                    <input type="password" class="form-control form-control-md"
                                    id="confirm_password" name="confirm_password">
                                </div>
                                <button type="submit" name="hesap" class="btn btn-dark btn-rounded btn-sm mb-4">Kaydet</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->

    <?php include 'includes/footer.php';?>
    <script type="text/javascript">
    // Get the modal
    var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

</script>