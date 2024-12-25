<?php 

include"xpanel/inc/vt.php"; 
if(isset($_POST['email'])){




   $email = $_POST['email']; 

   if ($email <> "" ) {

    $satir = [
        'email' => $email, 
    ];

    $sql = "INSERT INTO newsletter SET email=:email;";
    $durum = $dbh->prepare($sql)->execute($satir);
    if ($durum) {
        $sonId = $dbh->lastInsertId();
        $_SESSION['alertok']="ok";
        header("location:".htmlspecialchars($_SERVER['HTTP_REFERER']));
        echo '<script language="javascript">
        alert(" Kayıt başarı ile tamamlandı")
        </script> ';
    }
}

}

?>