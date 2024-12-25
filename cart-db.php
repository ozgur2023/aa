<?php 
require_once("xpanel/inc/vt.php");
session_start();

if(!empty($_SESSION["login"]) || !empty($_COOKİE['login'])){ 
	if(!empty($_COOKİE['login'])){
		$uyeid=$_COOKİE['user'];
	}else{
		$uyeid=$_SESSION["user"]->id;

	}

}
function wishlist($product_id){
	global $dbh,$uyeid;

	$product = $dbh->prepare("SELECT * FROM products WHERE id=?");
	$product-> execute(array($product_id));
	$product= $product->fetch(PDO::FETCH_OBJ);
	$cust    =   $dbh->prepare("SELECT * FROM users where id=?  ");
	$cust    -> execute(array($uyeid));
	$cust    =   $cust    -> fetch(PDO::FETCH_OBJ);

	if($cust){
		$kont = $dbh->prepare("SELECT * FROM wishlist WHERE user=? && product=?");
		$kont-> execute(array($cust->id,$product_id));
		$kont= $kont->fetch(PDO::FETCH_OBJ);
		if(!$kont){
			$ekle	=	$dbh->prepare("INSERT INTO wishlist SET user=? , product=?");
			$ekle-> execute(array($cust->id,$product_id));

			$cevap	=	["img"=>$product->foto,"name"=>$product->name];
			echo json_encode($cevap);

		}else{
			$delete = $dbh->prepare("DELETE FROM wishlist WHERE id=?");
			$delete -> execute(array($kont->id));
			
			$cevap	=	["hata"=>"dis","img"=>$product->foto,"name"=>$product->name];
			echo json_encode($cevap);

		}
	}else{

		$cevap	=	["hata"=>"log","img"=>$product->foto,"name"=>$product->name];
		echo json_encode($cevap);

	}

}


function storelist($product_id){
	global $dbh;

	$seller = $dbh->prepare("SELECT * FROM sellers WHERE name_seo=?");
	$seller-> execute(array($product_id));
	$seller= $seller->fetch(PDO::FETCH_OBJ);
	$cust    =   $dbh->prepare("SELECT * FROM customer where cust_key=?  ");
	$cust    -> execute(array($_SESSION['ckey']));
	$cust    =   $cust    -> fetch(PDO::FETCH_OBJ);

	if($cust){
		$kont = $dbh->prepare("SELECT * FROM storelist WHERE cust=? && store=?");
		$kont-> execute(array($cust->id,$seller->id));
		$kont= $kont->fetch(PDO::FETCH_OBJ);
		if(!$kont){
			$ekle	=	$dbh->prepare("INSERT INTO storelist SET cust=? , store=?");
			$ekle-> execute(array($cust->id,$seller->id));

			$cevap	=	["img"=>$seller->foto,"name"=>$seller->store_name];
			echo json_encode($cevap);

		}else{
			$delete = $dbh->prepare("DELETE FROM storelist WHERE id=?");
			$delete -> execute(array($kont->id));
			
			$cevap	=	["hata"=>"dis","img"=>$seller->foto,"name"=>$seller->store_name];
			echo json_encode($cevap);

		}
	}else{

		$cevap	=	["hata"=>"log","img"=>$seller->foto,"name"=>$seller->store_name];
		echo json_encode($cevap);

	}


}





//print_r($_POST);
if(isset($_POST["p"])){

	$islem = $_POST["p"];

	if($islem =="addToCart"){
		$idd = $_POST["key"];

		$varia = array();
		$product = $dbh->prepare("SELECT * FROM products WHERE pro_key=?");
		$product-> execute(array($idd));
		$product= $product->fetch(PDO::FETCH_OBJ);
		$vari=json_decode($product->variation);

		foreach ($vari as $var ) {

			$pvdkont =   $dbh->prepare("SELECT * FROM product_variants WHERE product_id=? && variant_id=? && id=? ");
			$pvdkont    ->  execute(array($product->id,$var,$_POST['var'.$var]));
			$pvdkont    =   $pvdkont     ->fetch(PDO::FETCH_OBJ);
			if($pvdkont){
				$varia[$var] = $_POST['var'.$var];
				$product->price=$pvdkont->option_price;
			}
			//array_push($varia,$_POST['var'.$var]);
		}
		$product->count = $_POST["quantity"];
		$product->varia = json_encode($varia);
		

		if(count($varia)!=count($vari)){}else{
			echo (addToCart($product));
		}
		
		
	}elseif($islem =="removeFromCart"){
		$idd = $_POST["key"];

		echo (removeFromCart($idd));
	}elseif($islem =="incCount"){
		$idd = $_POST["key"];
		
		echo (incCount($idd));

		
	}elseif($islem =="decCount"){
		$idd = $_POST["key"];
		
		echo (decCount($idd));
		
		
	}elseif($islem =="wishlist"){
		$idd = $_POST["key"];
		echo (wishlist($idd));		
	}elseif($islem =="storelist"){
		$idd = $_POST["key"];
		echo (storelist($idd));		
	}
}
if(isset($_GET["p"])){

	$islem = $_GET["p"];

	
	if($islem =="incCount"){
		$idd = $_GET["product_id"];
		if(incCount($idd)){
			header("Location:");
		}
		
		
		
	}elseif($islem =="decCount"){
		$idd = $_GET["product_id"];
		if(decCount($idd)){
			header("Location:");
		}
	}

	

}

