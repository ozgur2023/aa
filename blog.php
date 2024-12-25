<?php include 'includes/header.php';?>
<title><?=$seo['menu_title'];?></title>
<meta name="description" content="<?=$seo['menu_description'];?>">
<meta name="keywords" content="<?=$seo['menu_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>


<!-- Start of Main -->
<main class="main">
    <!-- Start of Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">KAMPANYA & DUYURULAR</h1>
        </div>
    </div>
    <!-- End of Page Header -->

    

    <!-- Start of Page Content -->
    <div class="page-content">
        <div class="container">
          
            <br>
            <div class="row grid cols-lg-3 cols-md-2 mb-2" data-grid-options="{
            'layoutMode': 'fitRows'
        }">
         <?php 

                $anahizsorgu = $dbh->prepare("SELECT * FROM news");
                $anahizsorgu->execute();
                while ($anahizsonuc = $anahizsorgu->fetch()) {
                    $id = $anahizsonuc['id'];
                    $title = $anahizsonuc['news_name']; 
                    $news_description = $anahizsonuc['news_description'];
                    $foto = $anahizsonuc['foto'];     
                    ?>  
        <div class="grid-item fashion">
            <article class="post post-mask overlay-zoom br-sm">
                <figure class="post-media">
                    <a href="yazi/<?=seo($anahizsonuc['news_name']) ?>">
                        <img src="img/<?=$anahizsonuc['foto'];?>" width="600"
                        height="420" alt="blog">
                    </a>
                </figure>
                <div class="post-details">
                    <div class="post-details-visible">    
                        <h4 class="post-title text-white"><a href="yazi/<?=seo($anahizsonuc['news_name']) ?>"><?=$anahizsonuc['news_name'];?></a>
                        </h4>


                    </div>
                    <div class="post-meta">
                       
                    <?php echo substr($anahizsonuc['news_description'],0,90); ?>..
                       
                    </div>
                </div>
            </article>
        </div>
         <?php } ?>
          
         
       
    </div>
    
</div>
</div>
<!-- End of Page Content -->
</main>
<!-- End of Main -->
<?php include 'includes/footer.php';?>