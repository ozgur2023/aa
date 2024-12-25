<?php include 'includes/header.php';?>
<title><?=$ayar['page_title'];?></title>
<meta name="description" content="<?=$ayar['page_description'];?>">
<meta name="keywords" content="<?=$seo['page_keywords'];?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php';?>
<?php include 'includes/navbar2.php';?>
<style>
	.media {
		display: -ms-flexbox;
		display: flex;
		-ms-flex-align: start;
		align-items: flex-start
	}
	.media-body {
		-ms-flex: 1;
		flex: 1
	}
	.card-aligned>div[class*=col-] {
		display: flex;
	}
	.product-box .card{
		position: relative;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-direction: column;
		flex-direction: column;
		min-width: 0;
		word-wrap: break-word;
		background-color: #fff;
		background-clip: border-box;
		border: 1px solid rgba(0,0,0,.125);
		border-radius: 0.25rem
	}
	.product-box .card-footer {display:none !important;}
	.product-box .card-text .yotpo {margin-bottom:0.8rem;}
	.card-aligned .product-box {
		padding-left: .5rem;
		padding-right: .5rem;
	}
	.card-aligned .product-box > .card {margin-bottom:1rem !important;}

	.product-box .card > .edatalayer {
		padding-bottom: 10px!important;
	}
	.product-box .card h3 {
		font-size: 18px;
		text-align: center;
		color:rgb(255, 68, 0);
	}
</style>
<!-- Start of Main-->
<main class="main">
	<div class="container">
		<div class="mt-4">
			<div class="row">
				<div class="col-md-9 mb-4">
					<div class="owl-carousel owl-theme row gutter-no cols-1 animation-slider owl-dot-inner"
					data-owl-options="{
						'nav': false,
						'dots': true,
						'items': 1,
						'autoplay': false
					}">
					<?php 

					$anahizsorgu = $dbh->prepare("SELECT * FROM home_banner");
					$anahizsorgu->execute();
					while ($anahizsonuc = $anahizsorgu->fetch()) {
						$id = $anahizsonuc['id'];
						$title = $anahizsonuc['title']; 
						$description = $anahizsonuc['description'];
						$foto = $anahizsonuc['foto'];    
						$button = $anahizsonuc['button']; 
						$anahizsonuc = cevir("home_banner",$anahizsonuc,$_SESSION["dil"]);
						?>  
						<a href="<?=$anahizsonuc['button'];?>">
							<div class="intro-slide intro-slide2 banner banner-fixed br-sm"
							style="background-image: url(img/<?=$anahizsonuc['foto'];?>); background-color: #EBEDEC;">
							<div class="banner-content y-50">
								<div class="slide-animate" data-animation-options="{
									'name': 'fadeInRightShorter', 'duration': '1s'
								}">

							</h5> 

						</div>
					</div>
				</div>
			</a>
		<?php } ?>
	</div>
</div>
<div class="col-md-3">
	<div class="row">
		<div class="col-md-12 col-xs-6 mb-4">
			<div class="category-banner banner banner-fixed br-sm">
				<figure>
					<a href="<?=$gorsel['one_link'];?>">
						<img src="img/<?=$gorsel['home_one'];?>" alt="banner"
						width="330" height="239" style="background-color: #605959;" />
					</a>
				</figure>

			</div>
		</div>
		<div class="col-md-12 col-xs-6 mb-4">
			<div class="category-banner banner banner-fixed br-sm">
				<figure>
					<a href="<?=$gorsel['two_link'];?>">
						<img src="img/<?=$gorsel['home_two'];?>" alt="banner"
						width="330" height="239" style="background-color: #eff5f5;" />
					</a>
				</figure> 
			</div>
		</div>
	</div>
</div>
</div>
</div>
<!-- End of Intro-wrapper -->

<?php if($menu[9]['status']==1){ ?> 
	<!-- Start of Shop Category -->
	<div class="shop-default-category category-ellipse-section mb-6">
		<div class="owl-carousel owl-theme row gutter-lg cols-xl-8 cols-lg-7 cols-md-6 cols-sm-4 cols-xs-3 cols-2"
		data-owl-options="{
			'nav': false,
			'dots': true,
			'margin': 20,
			'responsive': {
				'0': {
					'items': 2
				},
				'480': {
					'items': 3
				},
				'576': {
					'items': 4
				},
				'768': {
					'items': 6
				},
				'992': {
					'items': 7
				},
				'1200': {
					'items': 8,
					'margin': 30
				}
			}
		}">
		<?php 

		$anahizsorgu = $dbh->prepare("SELECT * FROM gallery");
		$anahizsorgu->execute();
		while ($anahizsonuc = $anahizsorgu->fetch()) {
			$id = $anahizsonuc['id'];
			$title = $anahizsonuc['title'];  
			$foto = $anahizsonuc['foto'];    
			$button = $anahizsonuc['button'];  
			?>  
			<div class="category-wrap">
				<div class="category category-ellipse">
					<figure class="category-media">
						<a href="<?=$anahizsonuc['button'];?>">
							<img src="img/<?=$anahizsonuc['foto'];?>" alt="story"
							width="190" height="190" style="background-color: #D3D8DE;" />
						</a>
					</figure>
					<div class="category-content">
						<h4 class="category-name">
							<a href="<?=$anahizsonuc['button'];?>"><?=$anahizsonuc['title'];?></a>
						</h4>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<!-- End of Shop Category -->
<?php } ?>
  
		<?php if($menu[10]['status']==1){ ?> 
			<div class="title-link-wrapper title-deals appear-animate mb-4">
				<h2 class="title title-link" >Öne Çıkan Ürünler</h2> 
			</div>
			<div class="owl-carousel owl-theme appear-animate row cols-lg-5 cols-md-4 cols-sm-3 cols-2 mb-6"
			data-owl-options="{
				'nav': false,
				'dots': true,
				'margin': 20,
				'responsive': {
					'0': {
						'items': 2
					},
					'576': {
						'items': 3
					},
					'768': {
						'items': 4
					},
					'992': {
						'items': 5
					}
				}
			}">
			<?php 
			$hatus  = $dbh->prepare("SELECT * FROM vitrin_urun where vitrin_id=1 order by sira ");
			$hatus-> execute(array());
			$hatus  = $hatus->fetchAll(PDO::FETCH_OBJ);
			$i=0;
			foreach ($hatus as $hat ) {

				$product  =   $dbh->prepare("SELECT * FROM product WHERE id=? ");
				$product     ->  execute(array($hat->urun_id));
				$ur     =   $product     ->fetch(PDO::FETCH_OBJ);
				$wk  =   $dbh->prepare("SELECT * FROM wishlist WHERE user=? && product=? ");
				$wk     ->  execute(array($uyeid,$ur->id));
				$wk     =   $wk     ->fetch(PDO::FETCH_OBJ);
				?>
				<div class="product-wrap">
					<div class="product text-center">
						<figure class="product-media">
							<a href="urun/<?=$ur->seo_name?>">
								<img style="height:250px;" src="img/<?=$ur->foto?>" alt="Product"> 
							</a>
							<div class="product-action-vertical"> 
								<a href="#"  id="<?=$ur->id?>" title="" onclick="wishlist.add(this);" class="btn-product-icon  <?php if($wk){echo"wisa";} ?>  btn-wishlist w-icon-heart"
									title="Favorilere Ekle"></a>
									<a href="urun/<?=$ur->seo_name?>" class="btn-product-icon  w-icon-search"
										title="Ürün Detay"></a> 
									</div>
								</figure>
								<div class="product-details">
									<h4 class="product-name"><a href="urun/<?=$ur->seo_name?>"><?=substr($ur->product_name,0,58)?></a></h4> 
									<div class="product-price">
										<ins class="new-price"><?=para($ur->product_price)?> </ins>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
					<!-- End of Product Wrap -->

				</div>
				<!-- End of Prodcut Deals Wrapper -->
			<?php } ?>


			<?php if($menu[13]['status']==1){ ?> 
				<div class="category-banner-wrapper appear-animate row mb-5">
					<div class="col-md-6 mb-4">
						<div class="banner banner-fixed br-sm">
							<figure>
								<a href="<?=$gorsel['three_link'];?>">
									<img src="img/<?=$gorsel['home_three'];?>" alt="banner"
									width="680" height="180" style="background-color: #EAEAEA;" />
								</a>
							</figure> 
						</div>
					</div>
					<div class="col-md-6 mb-4">
						<div class="banner banner-fixed br-sm">
							<figure>
								<a href="<?=$gorsel['four_link'];?>">
									<img src="img/<?=$gorsel['home_four'];?>" alt="banner"
									width="680" height="180" style="background-color: #EAEAEA;" />
								</a>
							</figure> 
						</div>
					</div>
				</div>
				<!-- End of Category Banner Wrapper --> 
			<?php } ?>

			<?php if($menu[11]['status']==1){ ?> 
				<div class="title-link-wrapper title-deals appear-animate mb-4">
					<h2 class="title title-link">Çok Satan Ürünler</h2> 
				</div>
				<div class="owl-carousel owl-theme appear-animate row cols-lg-5 cols-md-4 cols-sm-3 cols-2 mb-6"
				data-owl-options="{
					'nav': false,
					'dots': true,
					'margin': 20,
					'responsive': {
						'0': {
							'items': 2
						},
						'576': {
							'items': 3
						},
						'768': {
							'items': 4
						},
						'992': {
							'items': 5
						}
					}
				}">
				<?php 
				$hatus  = $dbh->prepare("SELECT * FROM vitrin_urun where vitrin_id=2 order by sira ");
				$hatus-> execute(array());
				$hatus  = $hatus->fetchAll(PDO::FETCH_OBJ);
				$i=0;
				foreach ($hatus as $hat ) {

					$product  =   $dbh->prepare("SELECT * FROM product WHERE id=? ");
					$product     ->  execute(array($hat->urun_id));
					$ur     =   $product     ->fetch(PDO::FETCH_OBJ);

					?>
					<div class="product-wrap">
						<div class="product text-center">
							<figure class="product-media">
								<a href="urun/<?=$ur->seo_name?>">
									<img style="height:250px;" src="img/<?=$ur->foto?>" alt="Product" > 
								</a>
								<div class="product-action-vertical">
									<a href="#"  id="<?=$ur->id?>" title="" onclick="wishlist.add(this);" class="btn-product-icon  <?php if($wk){echo"wisa";} ?>  btn-wishlist w-icon-heart"
										title="Favorilere Ekle"></a>
										<a href="urun/<?=$ur->seo_name?>" class="btn-product-icon  w-icon-search"
											title="Ürün Detay"></a> 
										</div>
									</figure>
									<div class="product-details">
										<h4 class="product-name"><a href="urun/<?=$ur->seo_name?>"><?=$ur->product_name?></a></h4>

										<div class="product-price">
											<ins class="new-price"><?=para($ur->product_price)?></ins>
										</div>
									</div>
								</div>
							</div>
							<!-- End of Product Wrap -->
						<?php } ?>
						<!-- End of Product Wrap -->
					</div>
					<!-- End of Prodcut Deals Wrapper -->
				<?php } ?>
			</div>

			<!-- End of Container -->


			<div class="container mt-10 pt-2">
				<?php if($menu[14]['status']==1){ ?> 
					<div class="col-md-12 mb-4">
						<div class="banner banner-fixed br-sm">
							<figure>
								<a href="<?=$gorsel['five_link'];?>">
									<img src="img/<?=$gorsel['home_five'];?>" alt="banner"
									width="420" height="180" style="background-color: #EAEAEA;" />
								</a>
							</figure> 
						</div>
					</div>
				<?php } ?>
				<!-- End of Banner Simple -->
				<?php if($menu[12]['status']==1){ ?> 
					<div class="title-link-wrapper title-deals appear-animate mb-4">
						<h2 class="title title-link">En Çok Görüntülenen Ürünler</h2> 
					</div>
					<div class="owl-carousel owl-theme appear-animate row cols-lg-5 cols-md-4 cols-sm-3 cols-2 mb-6"
					data-owl-options="{
						'nav': false,
						'dots': true,
						'margin': 20,
						'responsive': {
							'0': {
								'items': 2
							},
							'576': {
								'items': 3
							},
							'768': {
								'items': 4
							},
							'992': {
								'items': 5
							}
						}
					}">
					<?php 
					$hatus  = $dbh->prepare("SELECT * FROM vitrin_urun where vitrin_id=3 order by sira ");
					$hatus-> execute(array());
					$hatus  = $hatus->fetchAll(PDO::FETCH_OBJ);
					$i=0;
					foreach ($hatus as $hat ) {

						$product  =   $dbh->prepare("SELECT * FROM product WHERE id=? ");
						$product     ->  execute(array($hat->urun_id));
						$ur     =   $product     ->fetch(PDO::FETCH_OBJ);

						$sl  =   $dbh->prepare("SELECT * FROM sellers WHERE id=? ");
						$sl     ->  execute(array($ur->seller));
						$sl     =   $sl     ->fetch(PDO::FETCH_OBJ);


						$cntry  =   $dbh->prepare("SELECT * FROM countries WHERE id=? ");
						$cntry     ->  execute(array($sl->country));
						$cntry    =   $cntry     ->fetch(PDO::FETCH_OBJ);
						?>
						<div class="product-wrap">
							<div class="product text-center">
								<figure class="product-media">
									<a href="urun/<?=$ur->seo_name?>">
										<img style="height:250px;" src="img/<?=$ur->foto?>" alt="Product">

									</a>
									<div class="product-action-vertical">
										<a href="#"  id="<?=$ur->id?>" title="" onclick="wishlist.add(this);" class="btn-product-icon  <?php if($wk){echo"wisa";} ?>  btn-wishlist w-icon-heart"
											title="Favorilere Ekle"></a>
											<a href="urun/<?=$ur->seo_name?>" class="btn-product-icon  w-icon-search"
												title="Ürün Detay"></a> 
											</div>
										</figure>
										<div class="product-details">
											<h4 class="product-name"><a href="urun/<?=$ur->seo_name?>"><?=$ur->product_name?></a></h4>

											<div class="product-price">
												<ins class="new-price"><?=para($ur->product_price)?><ins>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>

							</div>
						<?php } ?>
						<!-- End of Prodcut Deals Wrapper -->

						
	<div class="container mt-10 pt-2 mb-3" style="padding-left:5px;padding-right:5px">
		<div class="row card-aligned">
			<?php $getirKategori = $dbh->query("SELECT * FROM category WHERE parent = 0 ORDER BY sira ASC",PDO::FETCH_OBJ); foreach($getirKategori as $anakat){ ?>
				<div class="col-6 col-md-12 col-lg-3 product-box p22">
					<div class="card w-100 product-hover-none mb-4">
						<a href="kategori/<?=$anakat->category_s_name?>" class="edatalayer text-center" style="padding:10px" data-list="product-listing-page" data-position="1" data-purl="">
							<picture>
								<source type="image/svg" data-srcset="img/<?=$anakat->category_background_image?>" srcset="img/<?=$anakat->category_background_image?>">
									<img data-src="img/<?=$anakat->category_background_image?>" alt="<?=$anakat->category_name?>" onerror="this.parentNode.classList.add('imgPlaceHolder'); this.classList.add('noImageCls');" title="<?=$anakat->category_name?>" class="card-img-top lazyloaded" width="" height="" src="img/<?=$anakat->category_background_image?>" style="height: 75px;">
								</picture>
							</a>
							<div class="card-body px-2 px-md-3 pb-0">
								<h3 class="card-title text-info"><?=$anakat->category_name?></h3>
								<div class="card-text"></div>
							</div>
							<div class="card-footer d-flex align-items-center justify-content-between px-2 px-md-3 pb-3 border-0 bg-transparent">
								<a href="#" class="btn btn-info btn-sm edatalayer order-1" data-list="product-listing-page" data-position="1" data-purl="">Detaylar <i class="far fa-chevron-right pl-1"></i>
								</a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>


						<?php if($menu[15]['status']==1){ ?> 
							<div class="title-link-wrapper appear-animate mb-4">
								<h2 class="title title-link title-blog">Blog Yazıları</h2>
								<a href="<?=$ayar['web_adress'];?>/blog" class="font-weight-bold font-size-normal ls-normal">Tümü gör</a>
							</div>
							<div class="owl-carousel owl-theme post-wrapper appear-animate row cols-lg-4 cols-md-3 cols-sm-2 cols-1 mb-3"
							data-owl-options="{
								'items': 4,
								'nav': false,
								'dots': true,
								'loop': false,
								'margin': 20,
								'responsive': {
									'0': {
										'items': 1
									},
									'576': {
										'items': 2
									},
									'768': {
										'items': 3
									},
									'992': {
										'items': 4,
										'dots': false
									}
								}
							}">
							<?php 

							$anahizsorgu = $dbh->prepare("SELECT * FROM news WHERE dash=1");
							$anahizsorgu->execute();
							while ($anahizsonuc = $anahizsorgu->fetch()) {
								$id = $anahizsonuc['id'];
								$title = $anahizsonuc['news_name']; 
								$news_description = $anahizsonuc['news_description'];
								$foto = $anahizsonuc['foto'];     
								?>  
								<div class="post text-center overlay-zoom">
									<figure class="post-media br-sm">
										<a href="yazi/<?=seo($anahizsonuc['news_name']) ?>">
											<img src="img/<?=$anahizsonuc['foto'];?>" alt="Post" width="280" height="180"
											style="background-color: #546B73;" />
										</a>
									</figure>
									<div class="post-details">

										<h4 class="post-title"><a href="yazi/<?=seo($anahizsonuc['news_name']) ?>"><?=$anahizsonuc['news_name'];?></a></h4>
										<a href="yazi/<?=seo($anahizsonuc['news_name']) ?>" class="btn btn-link btn-dark btn-underline">Devamını oku<i
											class="w-icon-long-arrow-right"></i></a>
										</div>
									</div>
								<?php } ?>
							</div>
							<!-- Post Wrapper -->
						<?php } ?>


					</div>
				</main>
				<!-- End of Main -->
				<?php include 'includes/footer.php';?>