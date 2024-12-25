<?php include 'includes/header.php';?>
<title><?=$seo['about_title'];?></title>
<meta name="description" content="<?=$seo['about_description'];?>">
<meta name="keywords" content="<?=$seo['about_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>


        <!-- Start of Main -->
        <main class="main">
            <!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">HAKKIMIZDA</h1>
                </div>
            </div>
            <!-- End of Page Header -->
 
            <!-- End of Breadcrumb -->
            <br>
            <!-- Start of Page Content -->
            <div class="page-content">
                <div class="container">
                    <section class="introduce mb-10 pb-10">
                        <h2 class="title title-center">
                        <?=$hakkimizda['about_title'];?>
                        </h2>
                        <p class=" mx-auto text-center"><?=$hakkimizda['about_description'];?></p>
                        <figure class="br-lg">
                           <center> <img src="img/<?=$hakkimizda['foto'];?>" alt="Banner" 
                                width="1240" height="540" style="background-color: #D0C1AE;" />
                            </center>
                        </figure>
                    </section>

                  
                 
                </div>

               
 
            </div>
        </main>
        <!-- End of Main -->

       <?php include 'includes/footer.php';?>