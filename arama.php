<?php include 'includes/header.php';?>
<title><?=$seo['gallery_title'];?></title>
<meta name="description" content="<?=$seo['gallery_description'];?>">
<meta name="keywords" content="<?=$seo['gallery_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>


<!-- Start of Main-->
<main class="main">
  <div class="page-content">
    <div class="container">
        <br>
        <?php if($menu[17]['status']==1){ ?>    <a href="<?=$gorsel['seven_link'];?>"> <img src="<?=$ayar['web_adress'];?>/img/<?=$gorsel['home_seven'];?>"></a> <?php } ?>
        <br> <br>
        <!-- Start of Shop Content -->
        <div class="shop-content row gutter-lg mb-10">  
            <!-- Start of Sidebar, Shop Sidebar -->
            
            <!-- Start of Shop Main Content -->
            <div class="main-content">

                <div class="product-wrapper row cols-md-3 cols-sm-2 cols-2">
                   
                   <?php


                   $gelen = $_POST["arama"];
                   if($gelen == null){
                    header("location:index.php");
                }
                $cek = $dbh->query("select * from product where product_name like '%$gelen%' or id like '%$gelen%'",PDO::FETCH_ASSOC);
                if($cek->rowCount()){

                    foreach($cek as $kayit){ 
                      echo '
                      
                      <div class="product-wrap">
                      <div class="product text-center">
                      <figure class="product-media">
                      <a href="urun/'.( $kayit['seo_name']). '  ">
                      <img src="'.$ayar['web_adress'].'/img/'.$kayit['foto'].'" alt="Product" width="300"
                      height="338" />
                      </a>
                      
                      </figure>
                      <div class="product-details">
                      
                      <h3 class="product-name">
                      <a href="urun/'.( $kayit['seo_name']). '">'.$kayit['product_name'].'</a>
                      </h3>
                      
                      <div class="product-pa-wrapper">
                      <div class="product-price">
                      '.para( $kayit['product_price']). '
                      </div>
                      </div>
                      </div>
                      </div>
                      </div>';
                  }
              }

              else{
                echo ' 
                <center> <img src="'.$ayar['web_adress'].'/img/danger.png" style="height: 125px;"> </center><br> <br>
                <center>
                Değerli kullanıcımız, aradığınız isim de bir ürün bulamadık.
                </center>



                ';

            }

            ?>   
            


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
<?php include 'includes/footer.php';?>