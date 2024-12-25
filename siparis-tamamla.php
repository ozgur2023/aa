<?php include 'includes/header.php';?>
<title>SİPARİŞİ TAMAMLA</title> 
<meta name="author" content="ParsTech">

<?php 
if(count($_SESSION['sepet']) ==0){
    header("location:index.php");
    exit();
}?> 
<?php if(isset($_GET['kuponiptal'])){
    unset($_SESSION['kupon']);
    header("Location:siparis-tamamla");
} ?>
<?php if ($_POST && isset($_POST['coupon'])) {
    $cou=$_POST['coupon'];

    $ksorgu     =   $dbh->prepare("SELECT * FROM coupon WHERE coupon_code=? && status=1");
    $ksorgu     ->  execute(array($cou));
    $ksorgu     =   $ksorgu     ->fetch(PDO::FETCH_OBJ);
    if(!$ksorgu){
        $csonuc=" 

        <div class='alert alert-warning alert-button show-code-action'>
        Kupon kodu hatalı yada süresi sona ermiş olabilir.
        </div>



        ";

    }elseif($ksorgu  && $ksorgu->minimum_amount<=$toplam2c){
        $csonuc=" 
        <div class='alert alert-success alert-button show-code-action'>
        Kupon başarı ile tanımlanmıştır. 
        </div>
        ";
        $_SESSION['kupon']=$ksorgu;
    }else{
        $csonuc="

        <div class='alert alert-warning alert-button show-code-action'>
        Kuponu uygulayabilmek için sepet tutarınız minimum ".para($ksorgu->minimum_amount)." olmalıdır.
        </div>
        ";

    }

} 
?>
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>

<!-- Start of Main -->
<main class="main checkout">
    <!-- Start of Breadcrumb -->

<div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">SİPARİŞİ TAMAMLA</h1>
        </div>
    </div>
    <br>
    <!-- Start of PageContent -->
    <div class="page-content">
        <div class="container">
            <?php if(!empty($_SESSION["login"]) || !empty($_COOKIE['login'])){ }else{ ?>
                <div class="order-message" style="    justify-content: center;
                align-items: center;
                color: #222;
                padding: 3rem;
                border: 2px solid #e1e1e1;
                border-radius: 3px;">
                Değerli ziyaretçi, sitemize üye olmadığınız için sipairşinizi misafir üye konumunda vermektesiniz. Sipariş takibinizi mail veya sms üzerinden takip edebilirsiniz. Dilerseniz <a href="<?=$ayar['web_adress'];?>/musteri-kayit">Buraya tıklayarak</a> kayıt olabilir yada <a href="<?=$ayar['web_adress'];?>/musteri-girisi"> giriş </a> yapabilirsiniz.
            </div>
            <br>

        <?php } ?>

        <div class="row mb-9">
           <?php if($menu[22]['status']==1){ ?> 
            <form class="coupon" method="post">
              <h6 center><?php if($csonuc){echo $csonuc;} ?></h6>
              <input type="text" name="coupon" class="form-control " placeholder="İndirim kuponunuzu buraya yazabilirsiniz." style="float: left;width: 86%;margin-right: 15px;" required="">
              <button type="submit" class="btn btn-dark btn-outline btn-rounded">UYGULA</button>
          </form>
      <?php } ?>
  </div>
  <form class="form checkout-form" action="tamamla.php" method="post">

    <div class="row mb-9">
        <div class="col-lg-7 pr-lg-4 mb-4">
            <h3 class="title billing-title text-uppercase ls-10 pt-1 pb-3 mb-0">
             SİPARİŞ BİLGİLERİ
         </h3>
         <div class="row gutter-sm">
            <div class="col-xs-6">
                <label><?php echo $dil['024'];?> *</label>
                <input type="text" value="<?=$user['name']?>" class="form-control" name="first-name"  required="" />
            </div>
            <div class="col-xs-6">
                <label><?php echo $dil['039'];?></label>
                <input type="text" value="<?=$user['sirket']?>" class="form-control" name="company-name"  />
            </div>
        </div>

        <label><?php echo $dil['041'];?> *</label>
        <input type="text" class="form-control"  value="<?=$user['ulke']?>" name="country" required="" placeholder="Ülke" />
        <label>Açık Adres *</label>
        <input type="text" class="form-control" value="<?=$user['sokak']?>" name="sokak" required=""
        />

        <div class="row">
            <div class="col-xs-6">
                <label><?php echo $dil['043'];?>  *</label>
                <input type="text" class="form-control"  value="<?=$user['sehir']?>" name="city" required="" />
            </div>
            <div class="col-xs-6">
                <label><?php echo $dil['044'];?> *</label>
                <input type="text" class="form-control"  value="<?=$user['ilce']?>" name="state" required="" />
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <label><?php echo $dil['045'];?> *</label>
                <input type="text" class="form-control"   value="<?=$user['postakod']?>" name="postcode" required="" />
            </div>
            <div class="col-xs-6">
                <label><?php echo $dil['019'];?>  *</label>
                <input type="text" class="form-control"  value="<?=$user['phone']?>"  name="phone" required="" />
            </div>
        </div>
        <label><?php echo $dil['020'];?> *</label>
        <input type="text" class="form-control" name="email"  value="<?=$user['mail']?>" required="" />

        <h3 class="title title-simple text-left mb-3"><?php echo $dil['046'];?></h3>
        <label>Şirket adına fatura kestirmek isterseniz fatura bilgilerinizi yazabilirsiniz.</label>
        <textarea class="form-control" name="note" cols="30" rows="6"
        placeholder="....."></textarea>


    </div>


    <div class="col-lg-5 mb-4 sticky-sidebar-wrapper">
        <div class="order-summary-wrapper sticky-sidebar">
            <h3 class="title text-uppercase ls-10">SEPET BİLGİLERİ</h3>
            <div class="order-summary">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th colspan="2">
                                <b>Ürün Bilgileri</b>
                            </th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php 
                                                //print_r($_SESSION['sepet']);
                        $toplam2=0;
                        if(count($_SESSION['sepet']) > 0){
                            foreach ($_SESSION['sepet'] as $siparis => $siparisdetay) {
                                $array=$siparisdetay;
                                $urun_getir = $dbh -> prepare("SELECT * FROM product WHERE id = ?");
                                $urun_getir-> execute(array($siparisdetay["id"]));
                                $urun = $urun_getir->fetch(PDO::FETCH_ASSOC);
                                if(!empty($siparisdetay['size'])){

                                    $porsiyon = $dbh -> prepare("SELECT * FROM product_serving WHERE id = ?");
                                    $porsiyon-> execute(array($siparisdetay['size']));
                                    $porsiyon = $porsiyon->fetch(PDO::FETCH_ASSOC);

                                    $fiyat =$porsiyon["price"];
                                    $porsiyon_name= $porsiyon["name"];

                                }else{
                                    $porsiyon_name="";
                                    $fiyat = $siparisdetay['amount'];
                                }


                                $baslikseo  = seo( $urun['product_name']); 

                                $toplam = $fiyat  ;  
                                $toplamu = $fiyat*$array["qty"]  ;  
                                $toplam2 += $toplamu;

                                ?>
                                <tr class="bb-no">
                                    <td class="product-name"><?=$urun["product_name"];?> <i
                                        class="fas fa-times"></i> <span
                                        class="product-quantity"><?=$array['qty']?></span></td>
                                        <td class="product-total"><?=para($toplamu)?></td>
                                    </tr>

                                <?php } } ?>

                                <tr class="summary-subtotal">
                                    <td>
                                        <h4 class="summary-subtitle">%<?=$ayar['tax'];?> KDV</h4>
                                    </td>

                                    <td class="summary-subtotal-price" ><?=para($toplam2*("0.".$ayar['tax']))?>
                                </td>                                               
                            </tr>
                            <?php if ($_SESSION['kupon']) {
                                $kupin=$_SESSION['kupon']->discount_amount;
                                ?>
                                <tr class="summary-subtotal">
                                    <td>
                                        <h4 class="summary-subtitle"><?=$_SESSION['kupon']->coupon_name?> Kupon İndirimi <a href="siparis-tamamla?kuponiptal" style="color: red;">X</a></h4>
                                    </td>

                                    <td class="summary-subtotal-price" >-<?=para($_SESSION['kupon']->discount_amount)?>
                                </td>                                               
                            </tr>
                        <?php } ?>

                        <?php if($ayar['free_cargo']>=$toplam2){ ?>
                            <tr class="summary-subtotal">
                                <td>
                                    <h4 class="summary-subtitle">Kargo Ücreti</h4>
                                </td>

                                <td  class="summary-subtotal-price">
                                    <?=para($ayar['cargo_price'])?> 
                                </td>
                            </tr>
                            <?php $cargo=$ayar['cargo_price']; } ?>       

                            <tr class="summary-subtotal">
                                <td>
                                    <h4 class="summary-subtitle"><?php echo $dil['013'];?></h4>
                                </td>
                                <td class="summary-subtotal-price">
                                    <p class="summary-total-price" ><span id="toplamtutar"><?=para(($toplam2*("1.".$ayar['tax']))+$cargo-$kupin)?></span></p>
                                </td>                                               
                            </tr>
                        </tbody>


                        <tfoot>
                            <tr class="shipping-methods">
                                <td colspan="2" class="text-left">
                                   <h4 class="summary-subtitle">Ödeme Seçenekleri</h4>
                                   <ul id="shipping-method" class="mb-4">
                                    <?php if($menu[19]['status']==1){ ?> 
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="free-shipping" value="0" name="shipping" class="custom-control-input" checked>
                                                <label class="custom-control-label" for="free-shipping"><?php echo $dil['050'];?></label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($menu[20]['status']==1){ ?> 
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="standard_shipping" value="1" name="shipping" class="custom-control-input">
                                                <label class="custom-control-label" for="standard_shipping"><?php echo $dil['051'];?></label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if($menu[21]['status']==1){ ?> 
                                        <li>
                                            <div class="custom-radio">
                                                <input type="radio" id="express_shipping" value="2" name="shipping" class="custom-control-input">
                                                <label class="custom-control-label" for="express_shipping"><?php echo $dil['052'];?> +<?=para($ayar['door_payment'])?></label>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </td>
                        </tr>

                    </tfoot>
                </table>


                <div class="form-group place-order pt-6">
                    <button type="submit" class="btn btn-dark btn-block btn-rounded">SİPARİŞİ TAMAMLA</button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
</div>
</div>
<!-- End of PageContent -->
</main>
<!-- End of Main -->
<script src="<?=$ayar['web_adress'];?>/assets/vendor/sticky/sticky.js"></script>
<script src="<?=$ayar['web_adress'];?>/assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<?php include 'includes/footer.php';?>
