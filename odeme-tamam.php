<?php include 'includes/header.php'; ?>
<title>Ödeme Tamamlama Sayfası</title>
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/page-navbar.php'; ?>
<?php unset($_SESSION['yuklenenfotolar']);
unset($_SESSION['yuklenentasarimlar']); ?>

<!-- Start of Main -->
<main class="main checkout">
    <!-- Start of Breadcrumb -->

    <title> Ödeme Tamamlandı</title>

    <?php if (empty($_SESSION['sip'])) {
        // header("location:index.php");
        exit();
    } ?>


    <div class="container mt-8">
        <div class="order-message">


            <div class="col-md-6 mb-4">
                <div class="alert alert-success alert-simple alert-btn">
                    <a href="#" class="btn btn-success btn-md">BAŞARILI</a>
                    BİZİ TERCİH ETTİĞİNİZ İÇİN TEŞEKKÜR EDERİZ. SİPARİŞİNİZ ALINMIŞTIR.

                </div>
            </div>

        </div>
        <?php

        $sip = $dbh->prepare("SELECT * FROM product_order WHERE sipno = ?");
        $sip->execute(array($_SESSION['sip']));
        $sip = $sip->fetch(PDO::FETCH_OBJ);
        ?>

        <div class="order-results pt-8 pb-8">
            <div class="overview-item">
                <span><?php echo $dil['057']; ?></span>
                <strong><?= $_SESSION['sip'] ?></strong>
            </div>
            <div class="overview-item">
                <span><?php echo $dil['058']; ?></span>
                <strong>Bekliyor</strong>
            </div>
            <div class="overview-item">
                <span><?php echo $dil['060']; ?></span>
                <strong><?= $sip->history ?></strong>
            </div>
            <div class="overview-item">
                <span><?php echo $dil['013']; ?></span>
                <strong><?= $sip->amount ?> TL</strong>
            </div>
            <div class="overview-item">
                <span><?php echo $dil['061']; ?></span>
                <strong><?php if ($sip->odeme_tip == 0) {
                            echo "Online Ödeme";
                        } elseif ($sip->odeme_tip == 1) {
                            echo "Havale Eft";
                        } else {
                            echo "Kapıda Ödeme";
                        } ?></strong>
            </div>
        </div>

        <h2 class="title title-simple text-left pt-3"><?php echo $dil['089']; ?></h2>
        <div class="order-details mb-1" style="padding: 15px;">
            <table class="order-details-table">
                <thead>
                    <tr class="summary-subtotal">
                        <td>
                            <h3 class="summary-subtitle"><?php echo $dil['031']; ?></h3>
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $toplam2 = 0;
                    $sipp = json_decode($sip->sip);
                    $_SESSION['sepett'] = $sipp;

                    foreach ($_SESSION['sepett'] as $siparis => $siparisdetay) {
                        $array = $siparisdetay;
                        $urun_getir = $dbh->prepare("SELECT * FROM product WHERE id = ?");
                        $urun_getir->execute(array($siparisdetay->id));
                        $urun = $urun_getir->fetch(PDO::FETCH_ASSOC);
                        if (!empty($siparisdetay->size)) {

                            $porsiyon = $dbh->prepare("SELECT * FROM product_serving WHERE id = ?");
                            $porsiyon->execute(array($siparisdetay->size));
                            $porsiyon = $porsiyon->fetch(PDO::FETCH_ASSOC);

                            $fiyat = $urun["product_price"] + $porsiyon["serving_price"];
                            $porsiyon_name = $porsiyon["serving_name"];
                        } else {
                            $porsiyon_name = "";
                            $fiyat = $urun["product_price"];
                        }

                        $baslikseo  = seo($urun['product_name']);

                        $toplam = $fiyat;
                        $toplamu = $fiyat * $siparisdetay->qty;
                        $toplam2 += $toplamu;

                    ?>
                        <tr>
                            <td class="product-name"><?= $porsiyon["serving_name"]; ?> <b><?= $siparisdetay->qty ?> <i class="fas fa-times"></i></b> <?= $urun["product_name"]; ?> <span> </span></td>
                            <td class="product-price"><?= $toplamu ?> TL</td>
                        </tr>
                    <?php } ?>

                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle"><?php echo $dil['090']; ?>:</h4>
                        </td>
                        <td class="summary-subtotal-price"><?= $toplam2 ?> TL</td>
                    </tr>
                    <tr class="summary-subtotal">
                        <td>

                        </td>
                        <td class="summary-subtotal-price"></td>
                    </tr>

                    <tr class="summary-subtotal">
                        <td>
                            <h4 class="summary-subtitle"><?php echo $dil['013']; ?></h4>
                        </td>
                        <td>
                            <p class="summary-total-price"><?= $toplam2 * ("1." . $ayar['tax']) + $ayar['cargo_price'] ?> TL</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h2 class="title title-simple text-left pt-8 mb-2"><?php echo $dil['091']; ?></h2>
        <div class="address-info pb-8 mb-6">
            <p class="address-detail pb-2">
                <?php $adres = explode("/", $sip->adress);
                foreach ($adres as $adre) {
                    echo $adre . " ";
                }

                ?><br>
                <?= $sip->phone ?><br>
                <?= $sip->email ?>
            </p>
        </div>

        <a href="anasayfa" class="btn btn-icon-left btn-back btn-md mb-4"><i class="d-icon-arrow-left"></i> <?php echo $dil['092']; ?></a>
    </div>
    </div>
</main>

<!-- End Main --> <?php include 'includes/footer.php'; ?>