<?php include 'includes/header.php';?>
<title><?=$seo['social_title'];?></title>
<meta name="description" content="<?=$seo['social_description'];?>">
<meta name="keywords" content="<?=$seo['social_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>




<!-- Start of Main -->
<main class="main">
    <!-- Start of Page Header -->
  <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">SİPARİŞ TAKİBİ</h1>
        </div>
    </div>
    <!-- End of Page Header --> 
    
    <br>
    <!-- Start of Page Content -->
    <div class="page-content mb-10 pb-2">
        <div class="container">

            <section class="mb-7"> 
                <div class="row">

                    <form action="" method="post"> 
                        <label>Sipariş Kodunuz</label>
                        <input type="text" name="sip" class="form-control">
                        <br>
                        <center>
                            <button type="submit" class="btn btn-icon-left btn-back btn-md mb-4">Sorgula</button>
                        </center>
                    </form>
 
    <div class="col-md-12 mb-6">
        <div class="alert alert-primary alert-bg alert-button alert-block">
            <h4 class="alert-title">Sipariş Sorgulama</h4>
            <p style="max-width: 10000000rem;">
            Değerli müşterimiz, tarafınıza mail ve sms olarak iletilen sipariş kodunu yukarıdaki alana girerek sorgula butonuna basınız akabinde alt kısımda siparişinizin mevcut durumunu görüntüleyebilirsiniz.
          </p>

          <?php 
          if($_POST){
            $sip = $dbh -> prepare("SELECT * FROM product_order WHERE sipno = ?");
            $sip-> execute(array($_POST['sip']));
            $sip = $sip->fetch(PDO::FETCH_OBJ);
            ?>

            <?php if($sip){ ?>

              <div class="order-results pt-8 pb-8">
                <div class="overview-item">
                    <strong>Sipariş No:</strong>
                    <span><?=$sip->sipno?></span>
                </div>

                <div class="overview-item">
                    <strong>Sipariş Durumu:</strong>
                    <span>
                       <?php if($sip->status == 0){
                        echo ' Bekliyor';
                    }else if ($sip->status == 1) {
                        echo 'Yapılıyor';
                    }else if ($sip->status == 2) {
                        echo ' Tamamlandı';
                    }else if ($sip->status == 3) {
                        echo ' İptal Edildi';
                    }else if ($sip->status == 6) {
                        echo ' Kargoya Verildi';
                    }
                    ?>
                </span>
            </div>

            <div class="overview-item">
                <strong>Sipariş Tarihi: </strong>
                <span><?=$sip->history?></span>
            </div>
            <div class="overview-item">
                <strong>Toplam Tutar: </strong>
                <span><?=$sip->amount?> TL</span>
            </div>
            <div class="overview-item">
                <strong>Ödeme Türü:</strong>
                <span><?php if($sip->odeme_tip==0){echo "Online Ödeme";}elseif($sip->odeme_tip==1){echo "Havale Eft";}else{echo "Kapıda Ödeme";} ?></span>
            </div>

             <div class="overview-item">
                <strong>Adres Bilgisi:</strong>
                <span> <?php $adres= explode("/",$sip->adress);
                foreach ($adres as $adre) {
                    echo $adre." ";
                }

                ?></span>
            </div>

            <div class="overview-item">
                <strong>Telefon ve Mail: </strong>
                <span>   <?=$sip->phone?> -     <?=$sip->email?></span>
            </div>
              

            <br>
                    <div class="order-details mb-1">
                        <table class="order-details-table">
                            <thead>
                                <tr class="summary-subtotal">
                                    <td>
                                        <h3 class="summary-subtitle">Kargo Firma: <?=$sip->kargo_firma?></h3>
                                    </td>   

                                    <td><h3 class="summary-total-price">Takip Numarası: <?=$sip->kargo_kod?></h3></td> 

                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    

        </div>

    </div>
    <br>

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
                    <td class="order-id"><?=$porsiyon["serving_name"];?> <b><?=$siparisdetay->qty?> <i class="fas fa-times"></i></b> <?=$urun["product_name"];?>  </td>
                    <td class="order-date"><?=$toplamu?> TL</td>
                    
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="" class="btn btn-success btn-rounded btn-icon-right" disabled="">Toplam Tutar: <?=$toplam2?> TL</a>
</div>

</div>

  
                </div>
            <?php }else{
                echo"<center>HATALI SİPARİŞ KODU</center>" ;
            }

        }
        ?>






                </div>
            </section>







        </div>
        <!-- End of Page Content -->
    </main>
    <!-- End of Main -->
    <?php include 'includes/footer.php';?>