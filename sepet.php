<?php include 'includes/header.php';?>
<title><?=$seo['count_title'];?></title>
<meta name="description" content="<?=$seo['count_description'];?>">
<meta name="keywords" content="<?=$seo['count_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>
<?php
if (isset($_POST['savepr'])) {
    $_SESSION['yuklenenfotolar'][] = $_SESSION['fotolar'];
    $_SESSION['yuklenentasarimlar'][] = json_decode($_SESSION['tasarim']);
}
?>
<!-- Start of Main -->
<main class="main cart">
    <!-- Start of Breadcrumb -->
    <br>
    <!-- End of Breadcrumb -->
    <!-- Start of PageContent -->
    <div class="page-content">
        <div class="container">
            <div class="row gutter-lg mb-10">
                <div class="col-lg-12 pr-lg-4 mb-6">
                    <table class="shop-table cart-table">
                        <thead>
                            <tr>
                                <th class="product-name"><span>Ürün Adı</span></th>
                                <th></th>
                                <th class="product-price"><span>B. Fiyatı</span></th>
                                <th class="product-quantity"><span>Miktar</span></th>
                                <th class="product-subtotal"><span>Toplam Fiyat</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //print_r($_SESSION['sepet']);
                            $toplam2=0;
                            $kargo_toplam = 0;
                            $kdv_toplam = 0;
                            if(count($_SESSION['sepet']) > 0){
                                foreach ($_SESSION['sepet'] as $siparis => $siparisdetay) {
                                    $array=$siparisdetay;
                                    $urun_getir = $dbh -> prepare("SELECT * FROM product WHERE id = ?");
                                    $urun_getir-> execute(array($siparisdetay["id"]));
                                    $urun = $urun_getir->fetch(PDO::FETCH_ASSOC);
                                    if(!empty($siparisdetay['size'])){
                                        $porsiyon = $dbh -> prepare("SELECT * FROM product_serving WHERE id = ?");
                                        $porsiyon-> execute(array($siparisdetay['size']));
                                        $porsiyon = $porsiyon->fetch(PDO::FETCH_ASSOC);
                                        $fiyat = $porsiyon["price"];
                                        //$fiyat = $urun["product_price"]+$porsiyon["serving_price"];
                                        $porsiyon_name= "/".$porsiyon["name"]." Beden";
                                        $stok=$porsiyon['stok'];
                                    }else{
                                        $porsiyon_name="";
                                        $fiyat = $siparisdetay['amount'];
                                        $stok=$urun['stock_quantity'];
                                    }
                                    $baslikseo  = seo( $urun['product_name']); 
                                    $toplam = $fiyat  ;  
                                    $toplamu = $fiyat*$array["qty"]  ;  
                                    $toplam2 += $toplamu;
                                    ?>
                                    <tr>
                                        <td class="product-thumbnail">
                                            <div class="p-relative">
                                                <a href="urun/<?=$urun['seo_name']?>">
                                                    <figure>
                                                        <img alt="product" src="img/<?=$urun['foto']?>" width="300" height="338">
                                                    </figure>
                                                </a>
                                                <a  href='sepetekle.php?tip=sil&urun=<?=$siparis; ?>'> <button type="submit" class="btn btn-close"><i
                                                    class="fas fa-times"></i></button></a>
                                                </div>
                                            </td>
                                            <td class="product-name">
                                                <a href="product-default.html">
                                                  <a><?=$urun["product_name"];?> <b><?=$porsiyon_name?></b> </a>
                                              </a>
                                          </td>
                                          <td class="product-price"><span class="amount"> <?=para($toplam)?></span></td>
                                          <td class="product-quantity">
                                            <div class="input-group">
                                                <input class=" form-control" type="number" id="qty<?=$siparis?>" disabled value='<?=$array["qty"]?>'     type="number" min="1"
                                                max="<?=$stok?>">
                                                <button class=" w-icon-plus"  onclick="arttir(<?=$siparis?>,<?= $fiyat;?>)"></button>
                                                <button class=" w-icon-minus" onclick="azalt(<?=$siparis?>,<?= $fiyat;?>)"></button>
                                            </div>
                                        </td>
                                        <td class="product-subtotal">
                                            <span class="amount"><?=para($toplamu)?></span>
                                        </td>
                                    </tr>
                                <?php } 
                            }else{ ?>
                                <tr><td colspan="5"><center>
                                    <p><font color="#e4b95b"><?php echo $dil['012'];?>..</font></p></center> </td> </tr>          
                                <?php } ?>
                            </tbody>
                        </table>
                        <br>
                        <div class="cart-action mb-6">
                            <a href="<?=$ayar['web_adress'];?>/kategoriler" class="btn btn-dark btn-rounded btn-icon-left btn-shopping mr-auto"><i class="w-icon-long-arrow-left"></i>ALIŞVERİŞE DEVAM ET</a> 
                            <a href="<?=$ayar['web_adress'];?>/siparis-tamamla" class="btn btn-success btn-rounded btn-icon-left btn-shopping mr-auto" name="update_cart" value="Update Cart">SİPARİŞİ TAMAMLA</a>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!-- End of PageContent -->
    </main>
    <!-- End of Main -->
    <?php include 'includes/footer.php';?>
    <script type="text/javascript">
        function azalt(id,tutar){
            var deger= $('#qty'+id).val();
            if(parseInt(deger)>1){
                deger--;
                $("#qty"+id).val(deger);
                $('#amount'+id).text(deger*tutar);
                
                var tutart= Number($('#toplamtutar').text());
                var islem = tutart-tutar;
                $("#toplamtutar").text(islem);
                $.ajax({
                    type: "POST",
                    url: "adet.php",
                    data:'id='+id+'&adet='+deger,
                    success: function(data){
                        location.reload();
                    }
                });
            }
        }
        function arttir(id,tutar){
            var degera= $('#qty'+id).val();
            var maxa = $('#qty'+id).attr("max");
            if(parseInt(degera)<parseInt(maxa)){
                degera++;
                $("#qty"+id).val(degera);
                $('#amount'+id).text(degera*tutar);
                var tutart= Number($('#toplamtutar').text());
                var islem = tutart+tutar;
                $("#toplamtutar").text(islem);
                $.ajax({
                    type: "POST",
                    url: "adet.php",
                    data:'id='+id+'&adet='+degera,
                    success: function(data){
                        location.reload();
                    }
                });
            }
        }
    </script>
