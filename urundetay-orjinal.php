<?php include 'includes/header.php';?>
<link rel="stylesheet" type="text/css" href="<?=$ayar['web_adress'];?>/assets/vendor/photoswipe/photoswipe.min.css">
<link rel="stylesheet" type="text/css" href="<?=$ayar['web_adress'];?>/assets/vendor/photoswipe/default-skin/default-skin.min.css">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>
<?php 
$urun   =   $dbh->prepare("SELECT * FROM product  where seo_name=?  ");
$urun    -> execute(array($_GET['id']));
$urun    =   $urun  -> fetch(PDO::FETCH_OBJ);

if(!$urun){
    header("Location:index.php");
    exit();
}
$parca=explode(",",$urun->parent);
$kat   =   $dbh->prepare("SELECT * FROM category  where id=?  ");
$kat    -> execute(array($parca[1]));
$kat    =   $kat  -> fetch(PDO::FETCH_OBJ);

?>

<?php
$hizmet = $dbh->query("SELECT * FROM product ", PDO::FETCH_ASSOC);
if ($hizmet->rowCount()) {
    foreach ($hizmet as $hizmet) { 

        if(seo($hizmet["product_name"]) == $_GET["id"]){
            $hizmet = cevir("project",$hizmet,$_SESSION["dil"]);
            break;
        }
    }
}              
?>

<title><?=$hizmet['page_title'];?></title>
<meta name="description" content="<?=$seo['page_description'];?>">
<meta name="keywords" content="<?=$seo['page_keywords'];?>" />
<meta name="author" content="ParsTech">


<!-- Start of Main -->
<main class="main mb-10 pb-1">
    <!-- Start of Breadcrumb -->
    <br>
    <!-- End of Breadcrumb -->

    <!-- Start of Page Content -->
    <div class="page-content">
        <div class="container">
            <div class="row gutter-lg">
                <div class="main-content">
                    <div class="product product-single row">
                        <div class="col-md-6 mb-4 mb-md-8">
                            <div class="product-gallery product-gallery-sticky">
                                <div
                                class="product-single-carousel owl-carousel owl-theme owl-nav-inner row cols-1 gutter-no">

                                <figure class="product-image">
                                    <img src="img/<?=$urun->foto?>"
                                    data-zoom-image="img/<?=$urun->foto?>"
                                    alt="Fashion Table Sound Marker" width="800" height="900">
                                </figure>
                                <?php
                                $sorguu = $dbh->prepare("SELECT * FROM product_gallery where select_category='".$urun->id."'");
                                $sorguu->execute(); 

                                while ($sonucc = $sorguu->fetch()) {
                                    $id = $sonucc['id']; 
                                    $select_category = $sonucc['select_category']; 
                                    $foto = $sonucc['foto'];
                                    ?>
                                    <figure class="product-image">
                                        <img src="<?=$ayar['web_adress'];?>/img/<?=$sonucc['foto'];?>"
                                        data-zoom-image="<?=$ayar['web_adress'];?>/img/<?=$sonucc['foto'];?>"
                                        alt="Gallery" width="800" height="900">
                                    </figure>
                                <?php } ?>
                            </div>
                            <div class="product-thumbs-wrap">
                                <div class="product-thumbs row cols-4 gutter-sm">
                                    <div class="product-thumb active">
                                        <img src="img/<?=$urun->foto?>"
                                        alt="Product Thumb" width="800" height="900">
                                    </div>
                                    <?php
                                    $sorgu = $dbh->prepare("SELECT * FROM product_gallery where select_category='".$urun->id."'");
                                    $sorgu->execute(); 

                                    while ($sonuc = $sorgu->fetch()) {
                                        $id = $sonuc['id']; 
                                        $select_category = $sonuc['select_category']; 
                                        $foto = $sonuc['foto'];
                                        ?>
                                        <div class="product-thumb">
                                            <img src="<?=$ayar['web_adress'];?>/img/<?=$sonuc['foto'];?>"
                                            alt="Product Thumb" width="800" height="900">
                                        </div>
                                    <?php } ?>
                                </div>
                                <button class="thumb-up disabled"><i class="w-icon-angle-left"></i></button>
                                <button class="thumb-down disabled"><i
                                    class="w-icon-angle-right"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-6 mb-md-8">
                            <div class="product-details" data-sticky-options="{'minWidth': 767}">
                                <h1 class="product-title"><?=$urun->product_name?></h1>
                                <div class="product-bm-wrapper">
                                    <figure class="brand">
                                        <img src="assets/images/products/brand/brand-6.jpg" alt="Brand"
                                        width="85" height="48" />
                                    </figure>
                                    <div class="product-meta">
                                        <div class="product-categories">
                                            Kategori:
                                            <span class="product-category"><?=$kat->category_name?></span>
                                        </div>

                                        <div class="product-sku">
                                            Ürün Kodu: <span><?=$urun->pro_code?></span>
                                        </div>

                                    </div>

                                    <div class="social-links-wrapper">
                                        <div class="social-links">
                                            <div class="social-icons social-no-color border-thin">

                                            </div>
                                        </div>
                                        

                                        <?php 
                                        $wk  =   $dbh->prepare("SELECT * FROM wishlist WHERE user=? && product=? ");
                                        $wk     ->  execute(array($uyeid,$urun->id));
                                        $wk     =   $wk     ->fetch(PDO::FETCH_OBJ);
                                        ?>
                                        <span class="divider d-xs-show"></span>
                                        <div class="product-link-wrapper d-flex">
                                            <a  href="#" id="<?=$urun->id?>" title="" onclick="wishlist.add(this);" class="btn-product-icon     <?php if($wk){echo"wisa";} ?> w-icon-heart"><span></span></a>
                                            
                                            <a href="whatsapp://send?text=https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];  ?>&t=Merhaba," class="social-icon social-whatsapp fab fa-whatsapp"></a>
                                        </div>
                                    </div>
                                </div>


                                <div class="product-price"><center><?=para($urun->product_price)?> </center></div>


                                <hr class="product-divider">
                                <?php 
                                $benzers= explode(",", $urun->benzer);
                                if(count($benzers)>0 && !empty($urun->benzer)){
                                    ?>
                                    <div class="product-form product-variation-form product-image-swatch">
                                        <label>Benzer:</label>
                                        <div class="d-flex align-items-center w-100">
                                            <?php 
                                            foreach ($benzers as $benzer) {
                                                $udetay   =   $dbh->prepare("SELECT * FROM product  where id=?  ");
                                                $udetay    -> execute(array($benzer));
                                                $udetay    =   $udetay  -> fetch(PDO::FETCH_OBJ);
                                                if($udetay){
                                                    ?>
                                                    <a href="urun/<?=$udetay->seo_name?>" class="image"><img
                                                        src="img/<?=$udetay->foto?>"
                                                        alt="Resim" width="24" height="24" /></a>

                                                    <?php } } ?>

                                                </div>
                                            </div>
                                        <?php } ?>
                                        <form action="sepetekle.php" method="post" enctype="multipart/form-data" data-xhr="true">
                                            <?php 
                                            $alt = $dbh->query("select * from product_serving WHERE parent = {$urun->id}  ", PDO::FETCH_ASSOC);
                                            $sayy=0;
                                            foreach ($alt as $alt) {
                                                $sayy+=$alt['stok'];
                                            }
                                            if($sayy>0 ){

                                                ?>
                                                <div class="product-form product-variation-form product-size-swatch">
                                                    <label class="mb-1">Seçenekler:</label>
                                                    <div class="flex-wrap d-flex align-items-center product-variations w-100">

                                                        <?



                                                        $alt = $dbh->query("select * from product_serving WHERE parent = {$urun->id}  ", PDO::FETCH_ASSOC);

                                                        $say=0;
                                                        if ($alt->rowCount()) {

                                                            $a=0;
                                                            foreach ($alt as $alt) {
                                                                $say+=$alt['stok'];
                                                                $alt = cevir("product_serving",$alt,$_SESSION["dil"]); ?>

                                                                <?php if($alt['stok']>0){ $size=$alt['id'];?>
                                                                <a href="#" onclick="bedenkont(<?=$alt['id']?>)" price="<?=$alt['price']?>" id="size<?=$alt['id']?>" value="<?=$alt['id']?> " class="size  "><?= $alt['name']?> - <?= $alt['price']?> TL </a>
                                                                <?php $a++;} ?>
                                                            <?php } 
                                                        }

                                                        ?>                

                                                    </div>
                                                    <!-- <a href="#" class="product-variation-clean">Clean All</a>-->
                                                </div>
                                            <?php } ?>
                                            <input type="hidden" class="esize" name="size" value="">
                                            <input type="hidden" name="tasarim" id="tasarim" value="false">
                                            <input type="hidden" name="tip" value="ekle">
                                            <input type="hidden" name="id" value="<?=$urun->id;?>">
                                            <style>											.product{margin-right:25px!important}											</style>	
                                            <div class="fix-bottom product-sticky-content sticky-content">
                                                <div class="product-form container" style="width: 100%; align-items: inherit;">
                                                    <?php if($menu[2]['status']==1){ ?> 
                                                        <div class="product-qty-form">
                                                            <div class="input-group">
                                                                <input class="quantity form-control" name="qty" type="number" min="1"
                                                                max="10000000">
                                                                <button type="button" class="quantity-plus w-icon-plus"></button>
                                                                <button type="button" class="quantity-minus w-icon-minus"></button>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                    <?php if($say>0 || $urun->stock_quantity>0){ ?>
                                                     <?php if($menu[2]['status']==1){ ?> 

                                                         <div id="">
                                                             <button id="sepeteat" class="btn btn-dark" style="background-color: <?=$ayar['color_two'];?>; border-color: <?=$ayar['color_two'];?>">
                                                                 <i class="w-icon-cart"></i>
                                                                 <span>Sepete Ekle</span>
                                                             </button>
                                                         </div>
                                                     <?php } ?>

                                                 <?php }else{?>

                                                    <div class="col-md-12 mb-4">
                                                        <div class="alert alert-danger alert-dark alert-round alert-inline">
                                                            <h4 class="alert-title">UYARI :</h4>
                                                            Bu üründe stok tükendi...
                                                            <button type="button" class="btn btn-link btn-close">
                                                                <i class="d-icon-times"></i>
                                                            </button>
                                                        </div>
                                                    </div>


                                                <?php } ?>



                                            </div>
                                        </div>
                                    </form>


                                </div>
								<div class="card-flex  mt-4 mb-4">
								   <div class="col-12">
									  <div class="page-sub-header">
										 <h2 class="mt-0" style="#fe7c00">Nasıl Sipariş Vermek İstersiniz?</h2>
									  </div>
								   </div>
								   <div id="onlinetasarla" class="w-100">
									  <div class="border border-primary rounded my-3 custom_design w-100">
										<a class="btn-img-text custom-design media px-3 py-2 text-primary">
											<div class="icon" style="width:20%;float:left">
												<i class="w-icon-display mr-3 align-self-center" style="font-size: 60px;"></i>
											</div>
											<div style="width:80%;float:right">
												<span class="media-body align-self-center">
													<span class="mt-0 mb-1 h4">ONLINE TASARLA</span>
													<span class="d-block text-black-50 short-disc mb-0">Boş bir sayfada tasarımınızı oluşturun</span>
												</span>
											</div>
											<div style="clear:both"></div>
										</a>
									  </div>
								   </div>
								   <div class="w-100 mt-4">
									  <div class="border border-secondary rounded my-3 upload_design w-100">
										<a href="#" class="btn-img-text upload-design media px-3 py-2 text-secondary">
											<div class="icon" style="width:20%;float:left">
												<i class="w-icon-withdraw mr-3 align-self-center" style="font-size: 60px;"></i>
											</div>
											<div style="width:80%;float:right">
												<span class="media-body align-self-center">
													<span class="mt-0 mb-1 h4">TASARIM YÜKLE</span>
													<span class="d-block text-black-50 short-disc mb-0">Baskıya hazır tasarımınızı bir dosyadan yükleyin</span>
												</span>
											</div>
											<div style="clear:both"></div>
										</a>
									  </div>
								   </div>
								   <div class="w-100 mt-4">
									  <div class="border border-info rounded my-3 hire_designer w-100">
										<a href="#" class="btn-img-text ico-hire-designer media px-3 py-2 text-info">
											<div class="icon" style="width:20%;float:left">
												<i class="w-icon-user mr-3 align-self-center" style="font-size: 60px;"></i>
											</div>
											<div style="width:80%;float:right">
												<span class="media-body align-self-center">
													<span class="mt-0 mb-1 h4">TASARIMCI DESTEĞİ</span>
													<span class="d-block text-black-50 short-disc mb-0">Tasarımınızı tarif edin ve siparişinizi tamamlayın</span>
												</span>
											</div>
											<div style="clear:both"></div>
										</a>
									  </div>
								   </div>
								</div>
								
                            </div>
                        </div>
                        <div class="tab tab-nav-boxed tab-nav-underline product-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#product-tab-description" class="nav-link active" style="color: <?=$ayar['color_two'];?>">ÜRÜN AÇIKLAMASI</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#product-tab-specification" class="nav-link">TAKSİT TABLOSU</a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-tab-description">
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-5">
                                            <?=$urun->product_description?>
                                        </div>

                                    </div>


                                </div>

                                <div class="tab-pane" id="product-tab-specification">
                                    <div class="row mb-4">
                                        <div class="col-md-12 mb-5">
                                            <style>
                                            #paytr_taksit_tablosu{clear: both;font-size: 12px;max-width: 1200px;text-align: center;font-family: Arial, sans-serif;}
                                            #paytr_taksit_tablosu::before {display: table;content: " ";}
                                            #paytr_taksit_tablosu::after {content: "";clear: both;display: table;}
                                            .taksit-tablosu-wrapper{margin: 5px;width: 280px;padding: 12px;cursor: default;text-align: center;display: inline-block;border: 1px solid #e1e1e1;}
                                            .taksit-logo img{max-height: 38px;padding-bottom: 10px; width: 60px;}
                                            .taksit-tutari-text{float: left;width: 126px;color: #a2a2a2;margin-bottom: 5px;}
                                            .taksit-tutar-wrapper{display: inline-block;background-color: #f7f7f7;}
                                            .taksit-tutar-wrapper:hover{background-color: #e8e8e8;}
                                            .taksit-tutari{float: left;width: 126px;padding: 6px 0;color: #474747;border: 2px solid #ffffff;}
                                            .taksit-tutari-bold{font-weight: bold;}
                                            @media all and (max-width: 600px) {.taksit-tablosu-wrapper {margin: 5px 0;}}
                                        </style>
                                        <div id="paytr_taksit_tablosu"></div>
                                        <script src="https://www.paytr.com/odeme/taksit-tablosu/v2?token=0e76a89ce36fb4641cfd367e9c24ea3749a8a8808074a83e9202a3361e9af449&merchant_id=174021&amount=<?=$urun->product_price?>&taksit=0&tumu=0"></script>
                                    </div>

                                </div>


                            </div>

                        </div>
                    </div>
                    <section class="vendor-product-section">
                      <div class="title-link-wrapper mb-4">
                          <h4 class="title text-left">Popüler Ürünler</h4>
                          <a href="<?=$ayar['web_adress'];?>/kategoriler" class="btn btn-dark btn-link btn-slide-right btn-icon-right">Tüm Ürünleri Gör <i class="w-icon-long-arrow-right"></i></a>
                      </div>
                      <div class="owl-carousel owl-theme row cols-lg-3 cols-md-4 cols-sm-3 cols-2"
                      data-owl-options="{
                        'nav': false,
                        'dots': false,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 2
                            },
                            '576': {
                                'items': 3
                            },
                            '768': {
                                'items': 4
                            },
                            '992': {
                                'items': 3
                            }
                        }
                    }">
                    <?php 

                    $urunler   =   $dbh->prepare("SELECT * FROM product   ");
                    $urunler    -> execute(array("%,".$kont->id.",%"));
                    $urunler    =   $urunler  -> fetchAll(PDO::FETCH_OBJ);


                    foreach ($urunler as $key => $value) { 

                        $kat   =   $dbh->prepare("SELECT * FROM category    ");
                        $kat    -> execute(array(ltrim($value->parent,",")));
                        $kat    =   $kat  -> fetch(PDO::FETCH_OBJ);

                        ?>  

                        <div class="product">
                            <figure class="product-media">
                                <a href="product-default.html">
                                    <img src="<?=$ayar['web_adress'];?>/img/<?=$value->foto?>" alt="Ürün"
                                    width="300" height="338" />
                                    <img src="<?=$ayar['web_adress'];?>/img/<?=$value->foto?>" alt="Product"
                                    width="300" height="338" />
                                </a>
                                <div class="product-action-vertical">
                                    <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                    title="Add to cart"></a>
                                    <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                    title="Add to wishlist"></a>
                                    <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                    title="Add to Compare"></a>
                                </div>
                                <div class="product-action">
                                    <a href="<?=$ayar['web_adress'];?>/urun/<?=$value->seo_name?>" class="btn-product btn-quickview" title="İncele">Hemen İncele</a>
                                </div>
                            </figure>
                            <div class="product-details">
                                <div class="product-cat"><a href="shop-banner-sidebar.html"><?=$kat->category_name?></a>
                                </div>
                                <h4 class="product-name"><a href="product-default.html"><?=$value->product_name?></a>
                                </h4>

                                <div class="product-pa-wrapper">
                                    <div class="product-price"> <?=para($value->product_price)?> </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </section>

        </div>
        <!-- End of Main Content -->
        <aside class="sidebar product-sidebar sidebar-fixed right-sidebar sticky-sidebar-wrapper">
            <div class="sidebar-overlay"></div>
            <a class="sidebar-close" href="#"><i class="close-icon"></i></a>
            <a href="#" class="sidebar-toggle d-flex d-lg-none"><i class="fas fa-chevron-left"></i></a>
            <div class="sidebar-content scrollable">
                <div class="sticky-sidebar">

                    <?php if($menu[18]['status']==1){ ?> 
                        <div class="widget widget-icon-box mb-6">
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                    <i class="w-icon-truck"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title"><?=$ayar['free_cargo'];?> TL</h4>
                                    <p>ve üzeri alışverişlerinizde kargo ücretsiz</p>
                                </div>
                            </div>
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                    <i class="w-icon-bag"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Güvenilir</h4>
                                    <p>hizmet kalitesi için 7/24 bize ulaşabilirsiniz.</p>
                                </div>
                            </div>
                            <div class="icon-box icon-box-side">
                                <span class="icon-box-icon text-dark">
                                    <i class="w-icon-money"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">15 Gün</h4>
                                    <p>içerisinde sorgusuz sualsiz iade hakkı</p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- End of Widget Icon Box -->



                    <div class="widget widget-products">
                        <div class="title-link-wrapper mb-2">
                            <h4 class="title title-link font-weight-bold">En Çok Görüntülenenler</h4>
                        </div>

                        <div class="owl-carousel owl-theme owl-nav-top" data-owl-options="{
                            'nav': true,
                            'dots': false,
                            'items': 1,
                            'margin': 20
                        }">
                        <div class="widget-col">
                            <?php 

                            $urunler   =   $dbh->prepare("SELECT * FROM product WHERE dash=1 LIMIT 10  ");
                            $urunler    -> execute(array("%,".$kont->id.",%"));
                            $urunler    =   $urunler  -> fetchAll(PDO::FETCH_OBJ);


                            foreach ($urunler as $key => $value) { 

                                $kat   =   $dbh->prepare("SELECT * FROM category    ");
                                $kat    -> execute(array(ltrim($value->parent,",")));
                                $kat    =   $kat  -> fetch(PDO::FETCH_OBJ);

                                ?>  

                                <div class="product product-widget">
                                    <figure class="product-media">
                                        <a href="<?=$ayar['web_adress'];?>/urun/<?=$value->seo_name?>">
                                            <img src="<?=$ayar['web_adress'];?>/img/<?=$value->foto?>" alt="Ürün"
                                            width="100" height="113" />
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name">
                                            <a href="<?=$ayar['web_adress'];?>/urun/<?=$value->seo_name?>"><?=$kat->category_name?><br>
                                                <h6><?=$value->product_name?></h6></a>
                                            </h4>

                                            <div class="product-price"><?=para($value->product_price)?></div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </aside>
        <!-- End of Sidebar -->
    </div>
</div>
</div>
<!-- End of Page Content -->
</main>
<!-- End of Main -->
<script src="assets/vendor/sticky/sticky.min.js"></script>
<script src="assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="assets/vendor/photoswipe/photoswipe.min.js"></script>
<script src="assets/vendor/photoswipe/photoswipe-ui-default.min.js"></script>
<?php include 'includes/footer.php';?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



<script type="text/javascript">

    var price = 1500
    var currency_symbol = "TL"

    var formattedOutput = new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: 'TRY',
        minimumFractionDigits: 2,
    });



    function bedenkont($id) {

        $('.size_box').each(function(i, obj) {
            $( this ).removeClass("selected");
        });
        var size =$("#size").val();
        var size =$id;
        var price =$('#size'+$id).attr('price');
        $('#size'+$id).addClass("selected");
        $('.product-variation-price').text(formattedOutput.format(price).replace(currency_symbol, ''));
        $.ajax({
            url     : 'kont.php',
            data    :'durum=sizekont&size='+size,
            type    : 'POST',
            success : function(sonuc){
                $(".esize").val(size);

                $('#sipver').html(sonuc);

            }
        });
    }
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('submit', 'form[data-xhr]', function(event){
            event.preventDefault();
            var action    = $(this).attr('action');
            var method    = $(this).attr('method');
            var formData  = new FormData($(this)[0]);
            $.ajax({
                url:  action,
                type: method,
                data: formData,
                cache: false,
                contentType: false,
                processData: false

            })
            .done(function(result){
                result=jQuery.trim(result.toString());
                if(result>0){


                    Swal.fire({
                        title: 'Max '+result+' Adet alabilirsiniz.',
                        icon: 'info',
                        html:
                        ``,
                        showCloseButton: true,
                        focusConfirm: false
                    })

                }else if(result=="Adet"){

                    Swal.fire({
                        title: 'Minimum 1 Adet Seçebilirsiniz',
                        icon: 'info',
                        html:
                        ``,
                        showCloseButton: true,
                        focusConfirm: false
                    })
                }else if(result=="sec"){

                    Swal.fire({
                        title: 'Beden Seçiniz!',
                        icon: 'info',
                        html:
                        ``,
                        showCloseButton: true,
                        focusConfirm: false
                    })

                }else if(result=="ok"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Ürün sepete eklendi',
                        showConfirmButton: false,
                        timer: 1500
                    })


                    window.setTimeout(function () {
                        window.location.reload();
                    }, 1500);

                }else if(result=="godesign"){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tasarıma Yönlendiriliyorsunuz',
                        showConfirmButton: false,
                        timer: 1500
                    })


                    window.setTimeout(function () {
                        window.location = 'https://samsunsoftware.net.tr/baski/tasarla/<?=$urun->seo_name?>';
                    }, 1500);

                }else{
                    Swal.fire({
                        title: 'Hata Oluştu!',
                        icon: 'info',
                        html:
                        ``,
                        showCloseButton: true,
                        focusConfirm: false
                    })
                }

            })
            .fail(function(result){
                alert(result);
            })
        });

        $('#onlinetasarla').click(function(){
            $('#tasarim').val('true');
            setTimeout(function(){$('#sepeteat').click();},500);
        });
    });

</script>
<style>
.card-flex{
	display:flex;
	flex-wrap: wrap;
}
.custom_design {
	border: 3px solid #00b3ff;
	padding:10px;
	border-radius:10px
}
.upload_design {
	border: 3px solid #ffb639;
	padding:10px;
	border-radius:10px
}
.hire_designer {
	border: 3px solid #ff0000;
	padding:10px;
	border-radius:10px
}
.custom_design a {
	color: #00b3ff !important;
}
.custom_design:hover a {
	color: #008fcc !important;
}
.custom_design a span {
	color: #00b3ff !important;
}
.custom_design .h4{
	text-transform: uppercase;
	font-size:22px
}
.custom_design a span {
	color: #00b3ff !important;
	font-size:14px
}


.upload_design a {
	color: #ffb639 !important;
}
.upload_design:hover a {
	color: #ffb639 !important;
}
.upload_design a span {
	color: #ffb639 !important;
}
.upload_design .h4{
	text-transform: uppercase;
	font-size:22px
}
.upload_design a span {
	color: #ffb639 !important;
	font-size:14px
}


.hire_designer a {
	color: #FF0000 !important;
}
.hire_designer:hover a {
	color: #FF0000 !important;
}
.hire_designer a span {
	color: #FF0000 !important;
}
.hire_designer .h4{
	text-transform: uppercase;
	font-size:22px
}
.hire_designer a span {
	color: #FF0000 !important;
	font-size:14px
}

.short-disc {
	font-size: 14px;
	font-size: .875rem;
}
.align-self-center {
	-ms-flex-item-align: center !important;
	align-self: center !important;
}
</style>