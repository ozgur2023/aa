<?php include 'includes/header.php';?>
<title>Siparişiniz Alındı</title> 
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>




<!-- Start of Main -->
<main class="main">
    <!-- Start of Page Header -->
<div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">SİPARİŞİNİZ ALINDI</h1>
        </div>
    </div>
    <!-- End of Page Header --> 
    
    <br>
    <!-- Start of Page Content -->
    <div class="page-content mb-10 pb-2">
        <div class="container">

          <section class="mb-7"> 
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="alert alert-icon alert-success alert-bg alert-inline">
                        <h4 class="alert-title">
                            <i class="fas fa-check"></i>Başarılı</h4> Değerli müşterimiz siparişiniz başarı ile alınmıştır.
                        </div>
                    </div>
                    
                    
                </div>
            </section>


            <section class="mb-7"> 
                <div class="row">
                   
                    <div class="col-md-12 mb-6">
                        <div class="alert alert-primary alert-bg alert-button alert-block">
                            <h4 class="alert-title">Ödeme Bilgilendirmesi</h4>
                            <p style="max-width: 10000000rem;">
                              Değerli müşterimiz, siparişiniz başarı ile alınmış olup kapıda ödeme yöntemi ile siparişinizi tamamlamış bulunmaktasınız. Siparişiniz en kısa süre de gönderimi sağlanacak olup ürünün ücretini teslimat esnasında ödeyeceğinizi hatırlatırız.
                          </p>

                          <?php 

                          $sip = $dbh -> prepare("SELECT * FROM product_order WHERE sipno = ?");
                          $sip-> execute(array($_SESSION['sip']));
                          $sip = $sip->fetch(PDO::FETCH_OBJ);
                          ?>

                          <div class="order-results pt-8 pb-8">
                            <div class="overview-item">
                                <span>Sipariş No:</span>
                                <strong><?=$_SESSION['sip']?></strong>
                            </div>
                            
                            <div class="overview-item">
                                <span>Sipariş Tarihi: </span>
                                <strong><?=$sip->history?></strong>
                            </div>
                            <div class="overview-item">
                                <span>Toplam Tutar: </span>
                                <strong><?=$sip->total_amount?> TL</strong>
                            </div>
                            <div class="overview-item">
                                <span>Ödeme Türü:</span>
                                <strong><?php if($sip->odeme_tip==0){echo "Online Ödeme";}elseif($sip->odeme_tip==1){echo "Havale Eft";}else{echo "Kapıda Ödeme";} ?></strong>
                            </div>

                            <br> 
                            <p class="address-detail pb-2">
                                <?php $adres= explode("/",$sip->adress);
                                foreach ($adres as $adre) {
                                    echo $adre." ";
                                }

                            ?><br>
                            <?=$sip->phone?> -     <?=$sip->email?>

                        </p>
                        
                    </div>

                    <a href="<?=$ayar['web_adress'];?>/odeme-yontemleri" class="btn btn-dark btn-rounded">BANKA HESAPLARIMIZ</a>
                    <a href="tel:<?=$ayar['phone'];?>" class="btn btn-primary btn-rounded">MÜŞTERİ TEMSİLCİSİNİ ARA</a>
                    
                </div>
            </div>
            
        </div>
    </section>
    



    <div class="tab-pane mb-4" id="account-orders" style="background-color: #eee; padding-top: .8rem; padding: 15px;">
        <div class="icon-box icon-box-side icon-box-light">
          
        </div>

        <table class="shop-table account-orders-table mb-6">
            <thead>
                <tr>
                    <th class="order-id">Ürün Adı</th>
                    <th class="order-date">Fiyatı</th> 
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
                if(!empty($siparisdetay->size)){

                    $porsiyon = $dbh -> prepare("SELECT * FROM product_serving WHERE id = ?");
                    $porsiyon-> execute(array($siparisdetay->size));
                    $porsiyon = $porsiyon->fetch(PDO::FETCH_ASSOC);

                    $fiyat = $urun["product_price"]+$porsiyon["serving_price"];
                    $porsiyon_name= $porsiyon["serving_name"];

                }else{
                    $porsiyon_name="";
                    $fiyat = $urun["product_price"];
                }

                $baslikseo  = seo( $urun['product_name']); 

                $toplam = $fiyat  ;  
                $toplamu = $fiyat*$siparisdetay->qty  ;  
                $toplam2 += $toplamu;

                ?>
                <tr style="background-color: #fff">
                    <td class="order-id"><?=$porsiyon["serving_name"];?> <b><?=$siparisdetay->qty?> <i class="fas fa-times"></i></b> <?=$urun["product_name"];?> </td>
                    <td class="order-date"><?=$toplamu?> TL</td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="" class="btn btn-success btn-rounded btn-icon-right" disabled="">Toplam Tutar: <?=$toplam2?> TL</a>
</div>



</div>
<!-- End of Page Content -->
</main>
<!-- End of Main -->
<?php include 'includes/footer.php';?>