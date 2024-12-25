<?php include 'includes/header.php';?>

<title><?=$seo['contact_title'];?></title>
<meta name="description" content="<?=$seo['contact_description'];?>">
<meta name="keywords" content="<?=$seo['contact_keywords'];?>" />
<meta name="author" content="ParsTech">

<?php
if ($_POST) {  
    if($_SESSION['captcha']==$_POST['deger']){


        $name_surname = $_POST['name_surname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        if ($name_surname <> "" && $email <> "" && $phone <> "" && $title <> "" && $description <> "" ) {

            $satir = [
                'name_surname' => $name_surname,
                'email' => $email,
                'phone' => $phone,
                'title' => $title,
                'description' => $description,
            ];

            $sql = "INSERT INTO contact SET name_surname=:name_surname, email=:email, phone=:phone, title=:title, description=:description;";
            $durum = $dbh->prepare($sql)->execute($satir);
            if ($durum) {
                $sonId = $dbh->lastInsertId();
                echo '<script language="javascript">
                alert("  Talebiniz başarı ile alınmıştır. ")
                </script> ';
            }
        }
    }else{
        echo '<script language="javascript">
        alert(" Bir hata oldu... ")
        </script> ';

    }

}
?>
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>


        <!-- Start of Main -->
        <main class="main">
            <!-- Start of Page Header -->
            <div class="page-header">
                <div class="container">
                    <h1 class="page-title mb-0">BİZE ULAŞIN</h1>
                </div>
            </div>
            <!-- End of Page Header -->
 

            <!-- Start of PageContent -->
            <div class="page-content contact-us">
                <div class="container">
                    <section class="content-title-section mb-10">
                      
                    </section>
                    <!-- End of Contact Title Section -->

                    <section class="contact-information-section mb-10">
                        <div class="row owl-carousel owl-theme cols-xl-4 cols-md-3 cols-sm-2 cols-1" data-owl-options="{
                        'items': 4,
                        'nav': false,
                        'dots': false,
                        'loop': false,
                        'margin': 20,
                        'responsive': {
                            '0': {
                                'items': 1
                            },
                            '480': {
                                'items': 2
                            },
                            '768': {
                                'items': 3
                            },
                            '992': {
                                'items': 4
                            }
                        }
                    }">
                            <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-email">
                                    <i class="w-icon-envelop-closed"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">E-mail</h4>
                                    <p><?=$ayar['email'];?></p>
                                </div>
                            </div>
                            <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-headphone">
                                    <i class="w-icon-headphone"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">İrtibat No</h4>
                                    <p><?=$ayar['phone'];?></p> 
                                </div>
                            </div>
                              <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-headphone">
                                    <i class="w-icon-headphone"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">İrtibat No</h4>
                                    <p><?=$ayar['business_phone'];?></p> 
                                </div>
                            </div>
                            <div class="icon-box text-center icon-box-primary">
                                <span class="icon-box-icon icon-map-marker">
                                    <i class="w-icon-map-marker"></i>
                                </span>
                                <div class="icon-box-content">
                                    <h4 class="icon-box-title">Ofis Adresimiz</h4>
                                    <p><?=$ayar['adress'];?></p>
                                </div>
                            </div>
                            
                        </div>
                    </section>
                    <!-- End of Contact Information section -->

                    <hr class="divider mb-10 pb-1">

                    <section class="contact-section">
                        <div class="row gutter-lg pb-3">
                             <div class="col-md-6 mb-8">
                                <figure class="br-lg">
                                    <img src="assets/images/pages/about_us/2.jpg" alt="Banner" width="610" height="500" style="background-color: #CECECC;">
                                </figure>
                            </div>
                            <div class="col-lg-6 mb-8">
                                <form class="form contact-us-form" action="#" method="post">
                                    <div class="form-group">
                                        <label for="username">İsim Soyisim</label>
                                        <input type="text" id="username" name="name_surname"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="email_1">E-Mail Adresiniz</label>
                                        <input type="email" id="email_1" name="email"
                                            class="form-control">
                                    </div>

                                     <div class="form-group">
                                        <label for="email_1">Telefon Numaranız</label>
                                        <input type="email" id="email_1" name="phone"
                                            class="form-control">
                                    </div>
                                     <div class="form-group">
                                        <label for="email_1">Başlık</label>
                                        <input type="email" id="email_1" name="title"
                                            class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label for="message">Açıklama</label>
                                        <textarea id="message" name="description" cols="30" rows="5"
                                            class="form-control"></textarea>
                                    </div>

                                    <center><img src="captcha.php" id="capt"><br><br> 
                                        <input type=button onClick=reload();  value='Yenile' ></center> <br>

                                        <input class="form-control" type="text" name="deger" placeholder="Güvenlik Kodu">

                                    <button type="submit" class="btn btn-dark btn-rounded">Gönder</button>
                                </form>
                            </div>
                        </div>
                    </section>
                    <!-- End of Contact Section -->
                </div>

 
                <!-- End Map Section -->
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->
    <script type="text/javascript">
        function reload() {
            img = document.getElementById("capt");
            img.src = "captcha.php"
        }
    </script>
<style>
    .google-maps {
        position: relative;
        padding-bottom: 15%; // Burası en-boy oranıdır.
        height: 0;
        overflow: hidden;
    }
    .google-maps iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>
<div class="google-maps">
   <iframe src="<?=$ayar['maps_link'];?>" width="100" height="150" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>
<?php include 'includes/footer.php';?>