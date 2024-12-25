<?php include 'includes/header.php';?>
<title>Müşteri Giriş Paneli</title> 
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/page-navbar.php';?>



<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include 'xpanel/inc/smsyolla.php';



$smtp_settings = $dbh -> prepare("SELECT * FROM smtp_settings WHERE id = ?");
$smtp_settings-> execute(array(1));
$smtp_settings = $smtp_settings->fetch(PDO::FETCH_OBJ);




if (isset($_POST['giris'])){
 $mail           =   $_POST["mail"];
 $password   =   md5($_POST["password"]);
 $remember   =   @$_POST["remember"];


 $ksorgu     =   $dbh->prepare("SELECT * FROM users WHERE mail=? && password=?");
 $ksorgu     ->  execute(array($mail,$password));
 $kbilgi     =   $ksorgu     ->fetch(PDO::FETCH_OBJ);

 if ( empty($mail) || empty($_POST["password"]) ) {
  $hata= "Tüm alanları doldurunuz";
}elseif(!$ksorgu->rowCount()){
  $hata= "Bilgileriniz hatalıdır. Lütfen tekrar deneyiniz.";

}else{

  $_SESSION["login"]   =   true;
  $_SESSION["user"]       =   $kbilgi;

  if( @$remember == "on" ) { 
    setcookie('user',$kbilgi->id,time()+60*60*24*7);
    setcookie('login',true,time()+60*60*24*7);


}

$basarili=1;
header("Refresh: 2; url=index.php");

//header("Refresh: 2; url=index.php");

}
}?>


<?php 

if (isset($_POST['kayit'])){

  $name         =   $_POST["name_surname"];
  $mail         =   $_POST["email"];
  $password     =   $_POST["password"];
  $password2    =   $_POST["password2"];
  $phone        =   str_replace(" ", "", $_POST["phone"]);

  $msorgu     =   $dbh->prepare("SELECT * FROM users WHERE mail=?");
  $msorgu     ->  execute(array($mail));
  $tsorgu     =   $dbh->prepare("SELECT * FROM users WHERE phone=?");
  $tsorgu     ->  execute(array($phone));

  if(!filter_var($mail,FILTER_VALIDATE_EMAIL)) {
   $hata=  "Girdiğiniz mail formatı hatalı.";
}elseif($msorgu->rowCount()){
   $hata=  "Bu mail adresi daha önce kullanılmış.";

}elseif (strlen($password)<6) {
   $hata=  "Parolanız en az 6 karakterden oluşmalı.";

}elseif($tsorgu->rowCount()){
  $hata=  "Bu telefon numarası daha önce kullanılmış.";
}elseif ($password!=$password2) {
 $hata=  "Şifreler Uyuşmamakta.";
}else{
  $password   =   md5($_POST["password"]);
  $insert =   $dbh->prepare("INSERT INTO users SET name=?, mail=?,  password=?, phone=? ");
  $insert-> execute(array($name,$mail,$password,$phone));
  $sonId = $dbh->lastInsertId();
  $eposta=$mail;

  $ksorgu     =   $dbh->prepare("SELECT * FROM users WHERE id=?");
  $ksorgu     ->  execute(array($sonId));
  $kbilgi     =   $ksorgu     ->fetch(PDO::FETCH_OBJ);



  $_SESSION["login"]   =   true;
  $_SESSION["user"]       =   $kbilgi;

  setcookie('user',$kbilgi->id,time()+60*60*24*7);
  setcookie('login',true,time()+60*60*24*7);



  if($sms_setting->kayit==1){
    smsyolla($phone,'Degerli kullanici kayıt oluşturulmuştur, Bizi tercih ettiginiz icin tesekkür ederiz. ');
}





$mailm= '<!DOCTYPE html>
<html lang="tr" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting"> 
<title>Üyeliğiniz Oluşturuldu</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">

<style>
html,
body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
}

        * {
-ms-text-size-adjust: 100%;
-webkit-text-size-adjust: 100%;
}

div[style*="margin: 16px 0"] {
  margin:0 !important;
}

table,
td {
  mso-table-lspace: 0pt !important;
  mso-table-rspace: 0pt !important;
}

table {
  border-spacing: 0 !important;
  border-collapse: collapse !important;
  table-layout: fixed !important;
  margin: 0 auto !important;
}
table table table {
  table-layout: auto;
}

img {
  -ms-interpolation-mode:bicubic;
}
        *[x-apple-data-detectors],
.x-gmail-data-detectors,   
.x-gmail-data-detectors *,
.aBn {
  border-bottom: 0 !important;
  cursor: default !important;
  color: inherit !important;
  text-decoration: none !important;
  font-size: inherit !important;
  font-family: inherit !important;
  font-weight: inherit !important;
  line-height: inherit !important;
}


.a6S {
  display: none !important;
  opacity: 0.01 !important;
}

img.g-img + div {
  display:none !important;
}


.button-link {
  text-decoration: none !important;
}

@media only screen and (min-device-width: 375px) and (max-device-width: 413px) { 
  .email-container {
    min-width: 375px !important;
}
}

</style>


<style>

.button-td,
.button-a {
  transition: all 100ms ease-in;
}
.button-td:hover,
.button-a:hover {
  background: #555555 !important;
  border-color: #555555 !important;
}

@media screen and (max-width: 480px) {

  .fluid {
    width: 100% !important;
    max-width: 100% !important;
    height: auto !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

.stack-column,
.stack-column-center {
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    direction: ltr !important;
}
.stack-column-center {
    text-align: center !important;
}

.center-on-narrow {
    text-align: center !important;
    display: block !important;
    margin-left: auto !important;
    margin-right: auto !important;
    float: none !important;
}
table.center-on-narrow {
    display: inline-block !important;
}

.email-container p {
    font-size: 17px !important;
    line-height: 22px !important;
}
}

</style>


</head>
<body width="100%" bgcolor="#F1F1F1" style="margin: 0; mso-line-height-rule: exactly;">
<center style="width: 100%; background: #F1F1F1; text-align: left;">




<div style="max-width: 680px; margin: auto;" class="email-container">

<table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px;" class="email-container">

<tr>
<td bgcolor="#17A2B8">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
<td style="padding: 30px 40px 30px 40px; text-align: center;" align="center">
<img src="'.$ayar["web_adress"].'/img/'.$ayar["foto"].'" alt="alt_text" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
</td>
</tr>
</table>
</td>
</tr>

<tr>
<td background="background.png" bgcolor="#222222" align="center" valign="top" style="text-align: center; background-position: center center !important; background-size: cover !important;">

<div>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:500px; margin: auto;">

<tr>
<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
</tr>

<tr>
<td align="center" valign="middle">

<table>
<tr>
<td valign="top" style="text-align: center; padding: 20px 0 10px 20px;">

<h1 style="margin: 0; font-family: Open Sans, sans-serif; font-size: 30px; line-height: 36px; color: #ffffff; font-weight: bold;">ÜYELİĞİNİZ OLUŞTURULDU</h1>
</td>
</tr>

</table>

</td>
</tr>

<tr>
<td height="20" style="font-size:20px; line-height:20px;">&nbsp;</td>
</tr>

</table>

</div>

</td>
</tr>

<tr>
<td bgcolor="#ffffff">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
<br><br>
<tr>
<td style="padding: 0px 40px 20px 40px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; text-align: left; font-weight:normal;">
<p style="margin: 0;">Değerli kullanıcımız, <br>
Üyeliğiniz başarı ile oluşturuldu.</p>
</td>
</tr>
 


</table>
</td>
</tr>


<tr>
<td bgcolor="#17A2B8">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
<td style="padding: 40px 40px 5px 40px; text-align: center;">
<h1 style="margin: 0; font-family: Open Sans, sans-serif; font-size: 20px; line-height: 24px; color: #ffffff; font-weight: bold;">İLETİŞİM BİLGİLERİMİZ</h1>
</td>
</tr>
<tr>
<td style="padding: 0px 40px 20px 40px; font-family: sans-serif; font-size: 17px; line-height: 23px; color: #aad4ea; text-align: center; font-weight:normal;">

</td>
</tr>
<tr>
<td valign="middle" align="center" style="text-align: center; padding: 0px 20px 40px 20px;">


<table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0" class="center-on-narrow">
<tr>
<td style="border-radius: 50px; background: #ffffff; text-align: center;" class="button-td">
<a href="'.$ayar["web_adress"].'/bize-ulasin" style="background: #ffffff; border: 15px solid #ffffff; font-family: Open Sans, sans-serif; font-size: 14px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 50px; font-weight: bold;" class="button-a">
<span style="color:#17A2B8;" class="button-link">&nbsp;&nbsp;&nbsp;&nbsp;BİZE ULAŞIN&nbsp;&nbsp;&nbsp;&nbsp;</span>
</a>
</td>
</tr>
</table>


</td>
</tr>

</table>
</td>
</tr>


<tr>
<td bgcolor="#ffffff">
<table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
<td style="padding: 40px 40px 10px 40px; font-family: sans-serif; font-size: 12px; line-height: 18px; color: #666666; text-align: center; font-weight:normal;">
<p style="margin: 0; font-weight: 700; font-size: 16px">Hızlı Linkler</p>
</td>
</tr>
<tr>
<td style="padding: 0px 40px 10px 40px; font-family: sans-serif; font-size: 12px; line-height: 18px; color: #666666; text-align: center; font-weight:normal;"> 
</td>
</tr>
<tr>
<td style="padding: 0px 40px 10px 40px; font-family: sans-serif; font-size: 12px; line-height: 18px; color: #666666; text-align: center; font-weight:normal;">
<p style="margin: 0;"><a href="'.$ayar["web_adress"].'/bize-ulasin" style="color: #111111; font-weight: 700;">İletişim Bilgileri</a> | <a href="'.$ayar["web_adress"].'/kategorilerimiz" style="color: #111111; font-weight: 700;"> Ürünlerimiz</a> | <a href="'.$ayar["web_adress"].'/hesabim" style="color: #111111; font-weight: 700;"> Müşteri Paneli</a></p>
</td>
</tr>
<tr>
<td style="padding: 0px 40px 40px 40px; font-family: sans-serif; font-size: 12px; line-height: 18px; color: #666666; text-align: center; font-weight:normal;">
<p style="margin: 0;">'.$ayar["copyright"].'</p>
</td>
</tr>

</table>
</td>
</tr>

</table>

</div>

</center>

</body>

</html>
';



$mail = new PHPMailer(true);              
try {
  $user= $smtp_settings->smtp_user;
  $mail->SMTPDebug = 0;               
  $mail->isSMTP();                    
  $mail->SMTPAuth = true;                 
  $mail->Username = $smtp_settings->smtp_user;    
  $mail->Password = $smtp_settings->smtp_password;              
  $mail->Host =$smtp_settings->smtp_server;           
  $mail->Port = $smtp_settings->smtp_port;                    
  $mail->SMTPSecure =  $smtp_settings->smtp_secure;                 
  $mail->SMTPOptions = array(
    'ssl' => [
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true,
  ],
);
  $mail->SetLanguage('tr', 'PHPMailer/language/');

  $mail->setFrom($user, 'Üyeliğiniz Oluşturuldu');    
  $mail->addAddress($eposta);             

  $mail->isHTML(true);                                  
  $mail->Subject = 'Üyeliğiniz Oluşturuldu';                    
  $mail->Body    = "$mailm";       
  $mail->CharSet = 'utf-8';
  $mail->send();



  //echo 'Mesaj gönderildi';
  //header("location:".htmlspecialchars($_SERVER['HTTP_REFERER']));

} catch (Exception $e) {
  //echo 'Mesaj gönderilmedi. Hata: ', $mail->ErrorInfo;
}



$basarili=1;
header("Refresh: 2; url=hesabim");


   // header("Refresh: 2; url=uye-girisi.php");

}

}

?>
<!-- Plugin CSS -->

<!-- Default CSS --> 

<!-- Start of Main -->
<main class="main login-page">
    <!-- Start of Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title mb-0">Müşteri Paneli</h1>
        </div>
    </div>
    <!-- End of Page Header -->

   
    <!-- End of Breadcrumb -->
    <div class="page-content">
        <div class="container">

            <div class="login-popup" style="margin: 4.2rem auto 5rem; box-shadow: 0 0 10px rgb(0 0 0 / 10%);">

               <?php if($basarili==1){ ?>


                <div class="alert alert-simple alert-primary alert-icon mb-4">
                  <i class="fas fa-check"></i>
                 Oturumunuz başarı ile açılmıştır. Yönlendiriliyorsunuz.
                  <button type="button" class="btn btn-link btn-close">
                    <i class="d-icon-times"></i>
                </button>
            </div>


        <?php }elseif(!empty($hata)){ ?>


            <div class="alert alert-light alert-danger alert-icon alert-inline mb-4">
              <i class="fas fa-exclamation-triangle"></i>
              <h4 class="alert-title"> </h4>
              <?=$hata?>!
              <button type="button" class="btn btn-link btn-close">
                <i class="d-icon-times"></i>
            </button>
        </div>



    <?php  } ?>
    <div class="tab tab-nav-boxed tab-nav-center tab-nav-underline">
        <ul class="nav nav-tabs text-uppercase" role="tablist">
            <li class="nav-item">
                <a href="#sign-in" class="nav-link active">GİRİŞ YAP</a>
            </li>
            <li class="nav-item">
                <a href="#sign-up" class="nav-link">KAYIT OL</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="sign-in">
                <form method="post">
                    <div class="form-group">
                        <label>E-Mail Adresiniz *</label>
                        <input type="text" class="form-control" name="mail" id="username" required>
                    </div>
                    <div class="form-group mb-0">
                        <label>Oturum Şifreniz *</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="form-checkbox d-flex align-items-center justify-content-between">
                        <input type="checkbox" class="custom-checkbox" id="remember1" name="remember" >
                        <label for="remember1">Beni Hatırla</label>
                        <a href="sifremi-unuttum">Şifremi Unuttum ?</a>
                    </div>
                    <button type="submit" name="giris" class="btn btn-primary">OTURUMU AÇ</button>
                </form>
            </div>


            
            
            
            
            <div class="tab-pane" id="sign-up">
                <form method="post">
                  <div class="form-group mb-5">
                        <label>İsim Soyisim *</label>
                        <input type="text" class="form-control" name="name_surname" id="first-name" required>
                    </div>
                    <div class="form-group">
                        <label>E-Mail Adresiniz *</label>
                        <input type="text" class="form-control" name="email" id="email_1" required>
                    </div>
                    <div class="form-group mb-5">
                        <label>Şifreniz *</label>
                        <input type="password" class="form-control" name="password" id="password_1" required>
                    </div>
                    <div class="form-group mb-5">
                        <label>Şifreyi Tekrarlayın *</label>
                        <input type="password" class="form-control" name="password2" id="password_1" required>
                    </div>

                    <div class="form-group mb-5">
                        <label>Telefon Numaranız *</label>
                        <input type="text" class="form-control" name="phone" id="phone-number" required>
                    </div>

                     
                    <div class="form-checkbox d-flex align-items-center justify-content-between mb-5">
                        <input type="checkbox" class="custom-checkbox" id="remember" name="remember" required="">
                        <label for="remember" class="font-size-md">Kullanıcı hizmet sözleşmesini okudum ve kabul ediyorum. <a  href="<?=$ayar['web_adress'];?>/sozlesmeler" class="text-primary font-size-md">Buraya tıklayarak sözleşmeyi okuyabilirsiniz.</a></label>
                    </div>
                    <button type="submit" name="kayit" class="btn btn-primary">KAYIT OL</button>
                </form>
            </div>

        </div>
     
    </div>
</div>
</div>
</div>
</main>
<!-- End of Main -->
<?php include 'includes/footer.php';?>