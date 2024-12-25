<?php include 'includes/header.php';?>
<title><?=$seo['waiter_title'];?></title>
<meta name="description" content="<?=$seo['waiter_description'];?>">
<meta name="keywords" content="<?=$seo['waiter_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>




        <!-- Start of Main -->
        <main class="main">
            <!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">KATEGORİLERİMİZ</h1>
                </div>
            </div>
            <!-- End of Page Header --> 
           
            <br>
            <!-- Start of Page Content -->
            <div class="page-content mb-10 pb-2">
                <div class="container">

                    <section class="category-section category-2cols-simple mb-10 pb-1"> 
                        <div class="owl-theme row cols-lg-3 cols-sm-2 cols-1" data-owl-options="{
                            'nav': false,
                            'dots': false,
                            'margin': 20,
                            'responsive': {
                                '0': {
                                    'items': 1
                                },
                                '576': {
                                    'items': 2
                                },
                                '992': {
                                    'items': 3
                                }
                            }
                        }">

                        <?php 
                                  $cek = $dbh->query("SELECT * FROM category WHERE parent = 0 ORDER BY sira ASC", PDO::FETCH_ASSOC);
                                  $say=1;
                                  foreach ($cek as $ak) { ?>

                            <div class="category-wrap" style="padding: 15px;">
                                <div class="category category-absolute category-default overlay-zoom">
                                    <a href="kategori/<?=$ak['category_s_name']?>">
                                        <figure>
                                            <img src="<?=$ayar['web_adress'];?>/img/<?=$ak['category_icon']?>" alt="Category Banner"
                                                width="400" height="200" style="background-color: #423D39;" />
                                        </figure>
                                    </a>
                                    <div class="category-content y-50">
                                        <h4 class="category-title text-white font-weight-bolder"> <?=$ak['category_name']?></h4> 
                                        <a href="kategori/<?=$ak['category_s_name']?>" class="btn btn-white btn-link btn-underline">Alışverişe Başla</a>
                                    </div>
                                </div>
                            </div>
                          <?php } ?>
                        </div>
                    </section>
                </div>
            </div>
            <!-- End of Page Content -->
        </main>
        <!-- End of Main -->
<?php include 'includes/footer.php';?>