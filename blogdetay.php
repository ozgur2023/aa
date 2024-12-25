<?php include 'includes/header.php';?>
<?php
$hizmet = $dbh->query("SELECT * FROM news ", PDO::FETCH_ASSOC);
if ($hizmet->rowCount()) {
    foreach ($hizmet as $hizmet) {
     $hizmet = cevir("news",$hizmet,$_SESSION["dil"]);

     if(seo($hizmet["news_name"]) == $_GET["id"]){
         $hizmet = cevir("news",$hizmet,$_SESSION["dil"]);
         break;
     }
 }
}              
?>
<title><?=$hizmet['page_title'];?></title>
<meta name="description" content="<?=$hizmet['page_description'];?>">
<meta name="keyword" content="<?=$hizmet['page_keywords'];?>">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>


<!-- Start of Main -->
<main class="main">
    <!-- Start of Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0"><?=$hizmet['news_name'];?></h1>
        </div>
    </div>
    <!-- End of Page Header -->
    <br>

    <!-- Start of Page Content -->
    <div class="page-content mb-8">
        <div class="container">
            <div class="row gutter-lg">
                <div class="main-content post-single-content">
                    <div class="post post-grid post-single">
                        <figure class="post-media br-sm">
                            <img src="<?=$ayar['web_adress'];?>/img/<?=$hizmet['foto'];?>" alt="Blog" width="930" height="500" />
                        </figure>
                        <div class="post-details">

                            <h2 class="post-title"><center><?=$hizmet['news_name'];?></center></h2>
                            <div class="post-content">
                                <p>
                                    <?=$hizmet['news_description'];?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- End Post -->


                     

                </div>
                <!-- End of Main Content -->
                <aside class="sidebar right-sidebar blog-sidebar sidebar-fixed sticky-sidebar-wrapper">
                    <div class="sidebar-overlay">
                        <a href="#" class="sidebar-close">
                            <i class="close-icon"></i>
                        </a>
                    </div>
                    <a href="#" class="sidebar-toggle">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div class="sidebar-content">
                        <div class="sticky-sidebar">

                            <!-- End of Widget categories -->
                            <div class="widget widget-posts">
                                <h3 class="widget-title bb-no">Popüler Yazılar</h3>
                                <div class="widget-body">
                                    <div class="owl-carousel owl-theme owl-nav-top row cols-1" data-owl-options="{
                                    'nav': true,
                                    'dots': false,
                                    'margin': 20
                                }">
                                <div class="widget-col">
                                 <?php 

                                 $anahizsorgu = $dbh->prepare("SELECT * FROM news WHERE dash=1");
                                 $anahizsorgu->execute();
                                 while ($anahizsonuc = $anahizsorgu->fetch()) {
                                    $id = $anahizsonuc['id'];
                                    $title = $anahizsonuc['news_name']; 
                                    $news_description = $anahizsonuc['news_description'];
                                    $foto = $anahizsonuc['foto'];     
                                    $date = $anahizsonuc['date'];
                                    $phpdate = strtotime( $date );
                                    $mysqldate = date( 'd', $phpdate );
                                    $mysqldatex = date( 'm', $phpdate );
                                    $mysqldatexx = date( 'Y', $phpdate );
                                    ?>  
                                    <div class="post-widget mb-4">
                                        <figure class="post-media br-sm">
                                            <img src="<?=$ayar['web_adress'];?>/img/<?=$anahizsonuc['foto'];?>" alt="Blog" width="150" height="150" />
                                        </figure>
                                        <div class="post-details">
                                            <div class="post-meta">
                                                <a href="<?=$ayar['web_adress'];?>/haber/<?=seo($anahizsonuc['news_name']) ?>" class="post-date"><?=$mysqldate?>.<?=$mysqldatex?>.<?=$mysqldatexx?></a>
                                            </div>
                                            <h4 class="post-title">
                                                <a href="<?=$ayar['web_adress'];?>/haber/<?=seo($anahizsonuc['news_name']) ?>"><?=$anahizsonuc['news_name'];?></a>
                                            </h4>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>

                        </div>
                    </div>
                </div>

                <!-- End of Widget custom block -->
                <div class="widget widget-tags">
                    <h3 class="widget-title bb-no">Anahtar Kelimeler</h3>
                    <div class="widget-body tags">
                       <?php
                       $kelimeler = explode(',', $hizmet['page_keywords']);
                       foreach ($kelimeler as $anahtar=>$deger) {
                        echo '<a href=""  class="tag">'.$deger.'</a>';
                    } ?>  


                </div>
            </div>

                 <div class="widget widget-tags">
                    <h3 class="widget-title bb-no">Paylaş</h3>
                    <div class="widget-body tags">
                        <a class="tag" href="mailto:?body=https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];  ?>"><i class="far fa-envelope-open"></i></a>
 
    <a class="tag" href="whatsapp://send?text=https://<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];  ?>&t=aa"><i class="fab fa-whatsapp"></i></a>

                    
                </div>
            </div>

        </div>
    </div>
</aside>
</div>
</div>
</div>
<!-- End of Page Content -->
</main>
<!-- End of Main -->
<?php include 'includes/footer.php';?>