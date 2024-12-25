<?php
include 'xpanel/inc/vt.php';
// Ürünü gelen isteğe göre işleme yönlendiriyoruz
if($_POST['action'] == 'store') {
    // Ürün post istediğini alıyoruz
    $id = $_POST['id'];
    $views = $_POST['views'];
    // Ürünü veritabanına kayıt ediyoruz
    $getir = $dbh->query("SELECT * FROM product_json WHERE parent = '$id'",PDO::FETCH_OBJ);
    if ($getir->rowCount()) {
        $guncelle = $dbh->query("UPDATE product_json SET views = '$views' WHERE parent = '$id'");
    }else{
        $ekle = $dbh->query("INSERT INTO product_json SET views = '$views', parent = '$id'");
    }
}
// Ürünü gelen isteğe göre işleme yönlendiriyoruz
else if($_POST['action'] == 'load') {
    // Ürünün ID'değerini alıyoruz
    $id = $_POST['id'];
    // Ürünü seçiyoruz
    $getir = $dbh->query("SELECT * FROM product_json WHERE parent = '$id'",PDO::FETCH_OBJ);
    foreach ($getir as $key) {
    }
    // Sonucu JSON formatında yazdırıyoruz
    header('Content-Type: application/json');
    echo json_encode(stripslashes($key->views));
}

?>