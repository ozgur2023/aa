<?php include 'includes/header.php'; ?>
<title><?= $seo['product_title']; ?></title>
<meta name="description" content="<?= $seo['product_description']; ?>">
<meta name="keywords" content="<?= $seo['product_keywords']; ?>" />
<meta name="author" content="ParsTech">

<?php include 'includes/topbar.php'; ?>
<?php include 'includes/page-navbar.php'; ?>

<?php
$kont   =   $dbh->prepare("SELECT * FROM category  where category_s_name=? ");
$kont->execute(array($_GET['id']));
$kont    =   $kont->fetch(PDO::FETCH_OBJ);
if (!$kont) {
    header('Location:index.php');
}
$katlar = $dbh->query("SELECT * FROM category  where parent={$kont->id} ");
if (!$katlar->rowCount()) {
    $katyok = 1;
}
?>

<!-- Start of Main-->
<main class="main">
    <div class="page-content">
        <div class="container">
            <br>
            <?php if ($menu[17]['status'] == 1) { ?> <a href="<?= $gorsel['seven_link']; ?>"> <img src="<?= $ayar['web_adress']; ?>/img/<?= $gorsel['home_seven']; ?>"></a> <?php } ?>
            <br> <br>
            <!-- Start of Shop Content -->
            <div class="shop-content row gutter-lg mb-10">
                <!-- Start of Sidebar, Shop Sidebar -->
                <aside class="sidebar shop-sidebar sticky-sidebar-wrapper sidebar-fixed">
                    <!-- Start of Sidebar Overlay -->
                    <div class="sidebar-overlay"></div>
                    <a class="sidebar-close" href="#"><i class="close-icon"></i></a>

                    <!-- Start of Sidebar Content -->
                    <div class="sidebar-content scrollable">
                        <!-- Start of Sticky Sidebar -->
                        <div class="sticky-sidebar" style="background-color: #eee;">
                            <div class="filter-actions" style="margin-left: 20px; margin-right: 20px; padding: 15px;">
                                <label>Filtreleme :</label>
                                <a href="#" class="btn btn-dark btn-link filter-clean">Temizle</a>
                            </div>
                            <?php if ($katyok != 1) { ?>
                                <!-- Start of Collapsible widget -->
                                <div class="widget widget-collapsible" style="margin-left: 20px; margin-right: 20px; ">
                                    <h3 class="widget-title"><label>Alt Kategoriler</label></h3>
                                    <ul class="widget-body filter-items search-ul">
                                        <?php
                                        if (empty($kont->parent)) {
                                            $katlar =   $dbh->prepare("SELECT * FROM category  where parent=? ");
                                            $katlar->execute(array($kont->id));
                                            $katlar    =   $katlar->fetchAll(PDO::FETCH_OBJ);
                                        } else {
                                            $katlar =   $dbh->prepare("SELECT * FROM category  where parent=? ");
                                            $katlar->execute(array($kont->parent));
                                            $katlar    =   $katlar->fetchAll(PDO::FETCH_OBJ);
                                        }
                                        foreach ($katlar as $kat) {
                                        ?>
                                            <li><a href="kategori/<?= $kat->category_s_name ?>"><?= $kat->category_name ?></a></li>
                                        <?php   } ?>
                                        <!--    <li><a href="#">Babies</a></li>
                         <li><a href="#">Beauty</a></li>
                         <li><a href="#">Decoration</a></li>
                         <li><a href="#">Electronics</a></li>
                         <li><a href="#">Fashion</a></li>
                         <li><a href="#">Food</a></li>
                         <li><a href="#">Furniture</a></li>
                         <li><a href="#">Kitchen</a></li>
                         <li><a href="#">Medical</a></li>
                         <li><a href="#">Sports</a></li>
                         <li><a href="#">Watches</a></li> -->
                                    </ul>
                                </div>
                                <!-- End of Collapsible Widget -->
                            <?php } ?>

                            <!-- Start of Collapsible Widget -->
                            <div class="widget widget-collapsible" style="margin-left: 20px; margin-right: 20px; padding: 5px;">
                                <h3 class="widget-title"><label>Fiyat Filtrelemesi</label></h3>
                                <div class="widget-body">
                                    <ul class="filter-items search-ul">
                                        <li><a href="kategori/<?= $_GET['id'] ?>?min=0&max=100">0,00 TL - 100,00 TL </a></li>
                                        <li><a href="kategori/<?= $_GET['id'] ?>?min=100&max=200">100,00 TL - 200,00 TL</a></li>
                                        <li><a href="kategori/<?= $_GET['id'] ?>?min=200&max=300">200,00 TL - 300,00 TL</a></li>
                                        <li><a href="kategori/<?= $_GET['id'] ?>?min=300&max=500">300,00 TL - 500,00 TL</a></li>
                                        <li><a href="kategori/<?= $_GET['id'] ?>?min=500">500,00 TL +</a></li>
                                    </ul>
                                    <form action="" method="get" class="price-range">
                                        <input type="number" name="min" class="min_price text-center" placeholder="Min."><span class="delimiter">-</span><input type="number" name="max" class="max_price text-center" placeholder="Max."><button type="submit" class="btn btn-primary btn-rounded" style="border-color: <?= $ayar['color_two']; ?>; background-color: <?= $ayar['color_two']; ?>; ">Filtrele</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                        <!-- End of Sidebar Content -->
                    </div>
                    <!-- End of Sidebar Content -->
                </aside>
                <!-- End of Shop Sidebar -->

                <!-- Start of Shop Main Content -->
                <div class="main-content">

                    <div class="product-wrapper row cols-md-3 cols-sm-2 cols-2">
                        <?php
                        if ($_GET['min']) {
                            $sorgu = "&& product_price>=" . $_GET['min'];
                        }

                        if ($_GET['max']) {
                            $sorgu .= " && product_price<=" . $_GET['max'];
                        }
                        $urunler   =   $dbh->prepare("SELECT * FROM product  where parent like ? $sorgu order by id desc ");
                        $urunler->execute(array("%," . $kont->id . ",%"));
                        $urunler    =   $urunler->fetchAll(PDO::FETCH_OBJ);

                        if (count($urunler) > 0) {

                            foreach ($urunler as $key => $value) {

                                $kat   =   $dbh->prepare("SELECT * FROM category  where id=?  ");
                                $kat->execute(array(ltrim($value->parent, ",")));
                                $kat    =   $kat->fetch(PDO::FETCH_OBJ);
                                $wk  =   $dbh->prepare("SELECT * FROM wishlist WHERE user=? && product=? ");
                                $wk->execute(array($uyeid, $value->id));
                                $wk     =   $wk->fetch(PDO::FETCH_OBJ);
                        ?>
                                <div class="product-wrap">
                                    <div class="product text-center">
                                        <figure class="product-media">
                                            <a href="urun/<?= $value->seo_name ?> ">
                                                <img class="img-fluid" src="img/<?= $value->foto ?>" alt="Product" style="height:255px" />
                                            </a>
                                            <div class="product-action-vertical">
                                                <!--  <a href="#" class="btn-product-icon btn-cart w-icon-cart" title="Add to cart"></a> -->
                                                <a href="#" id="<?= $value->id ?>" title="" onclick="wishlist.add(this);" class="btn-product-icon  <?php if ($wk) {
                                                                                                                                                        echo "wisa";
                                                                                                                                                    } ?>  btn-wishlist w-icon-heart" title="Favorilere Ekle"></a>
                                                <a href="urun/<?= $value->seo_name ?>" class="btn-product-icon  w-icon-search" title="Ürün Detay"></a>
                                                <!--     <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                    title="Add to Compare"></a> -->
                                            </div>
                                        </figure>
                                        <div class="product-details">
                                            <div class="product-cat">
                                                <a href="urun/<?= $value->seo_name ?>"><?= $kat->category_name ?></a>
                                            </div>
                                            <h3 class="product-name">
                                                <a href="urun/<?= $value->seo_name ?> "><?= $value->product_name ?></a>
                                            </h3>

                                            <div class="product-pa-wrapper">
                                                <div class="product-price">
                                                    <?= para($value->product_price) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else {
                            echo " 

<div class='col-md-12 mb-4'>
<div class='alert alert-error alert-bg alert-button alert-block'>
<h4 class='alert-title'>Üzgünüz...</h4>
<p style='max-width: 200rem;'>
Değerli kullanıcımız, aradığınız ürünü ne yazık ki bulamadık dilerseniz müşteri temsilcisini arıyarak aradığınız ürün hakkında yardımcı olabiliriz.
</p>

<a href='tel:" . $ayar["phone"] . "' class='btn btn-error btn-rounded'>Hemen Ara</a>

</div>
</div>


";
                        } ?>



                    </div>

                </div>
                <!-- End of Shop Main Content -->
            </div>
            <!-- End of Shop Content -->
            <!-- bitişi-->
        </div>
        <!-- End of Container -->
    </div>


</main>
<!-- End of Main -->
<?php include 'includes/footer.php'; ?>