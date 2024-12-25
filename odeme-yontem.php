<?php include 'includes/header.php';?>
<title><?=$seo['category_title'];?></title>
<meta name="description" content="<?=$seo['category_description'];?>">
<meta name="keywords" content="<?=$seo['category_keywords'];?>" />
<meta name="author" content="ParsTech">

<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>


        <!-- Start of Main -->
        <main class="main">
            <!-- Start of Page Header -->
          <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">ÖDEME YÖNTEMLERİ</h1>
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
                        <?=$omethod['payment_title'];?>
                        </h2>
                        <p class=" mx-auto text-center"><?=$omethod['payment_description'];?></p>
                            

                                <div class="tab-pane mb-4" id="account-orders" style="background-color: #eee; padding-top: .8rem; padding: 15px;">
                    <div class="icon-box icon-box-side icon-box-light">
                        <span class="icon-box-icon icon-orders">
                            <i class="w-icon-orders"></i>
                        </span>
                        <div class="icon-box-content">
                            <h4 class="icon-box-title text-capitalize ls-normal mb-0">BANKA HESAP BİLGİLERİMİZ</h4>
                        </div>
                    </div>

                    <table class="shop-table account-orders-table mb-6">
                        <thead>
                            <tr>
                                <th class="order-id">Banka Adı</th>
                                <th class="order-date">Hesap Sahibi</th>
                                <th class="order-status">İban No</th>  
                            </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $cek = $dbh->query("SELECT * FROM bank", PDO::FETCH_ASSOC);

                          foreach ($cek as $ak) { ?>
                            <tr style="background-color: #fff">
                                <td class="order-id"><?=$ak['bank_name']?></td>
                                <td class="order-date"><?=$ak['bank_account']?></td>
                                <td class="order-status"><?=$ak['bank_iban']?></td>

                              
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table> 
                </div>


                    </section>

                  
                 
                </div>

               
 
            </div>
        </main>
        <!-- End of Main -->

       <?php include 'includes/footer.php';?>