<?php include 'includes/header.php'; ?>
<link rel="stylesheet" type="text/css" href="designer/css/FancyProductDesigner-all.min.css" />
<title><?= $ayar['page_title']; ?></title>
<meta name="description" content="<?= $ayar['page_description']; ?>">
<meta name="keywords" content="<?= $seo['page_keywords']; ?>" />
<meta name="author" content="ParsTech">
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/navbar2.php'; ?>
<?php
unset($_SESSION['fotolar']);
unset($_SESSION['tasarim']);

if (isset($_GET['id'])) {
	$seoname = $_GET['id'];
	$getirurun = $dbh->query("SELECT * FROM product WHERE seo_name = '$seoname'", PDO::FETCH_OBJ);
	foreach ($getirurun as $urun) {
	}
}
?>
<form id="formgonder" action="sepetim" method="POST" class="col row w-100 mx-auto">
	<input type="hidden" name="savepr" value="1">
	<span id="savepr" class="btn btn-success col-12 d-block shadow-lg">Sepete İlerle</span>
</form>
</div>
<div id="fpd" class="fpd-container fpd-views-inside-left fpd-sidebar fpd-tabs fpd-tabs-side fpd-shadow-3 fpd-right-actions-centered fpd-left-actions-centered fpd-bottom-actions-centered fpd-top-actions-centered fpd-module-visible"></div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="designer/js/fabric-3.0.0.min.js" type="text/javascript"></script>
<script src="designer/js/FancyProductDesigner-all.min.js" type="text/javascript"></script>
<script src="designer/js/FancyProductDesignerPlus.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var opts = {
		stageHeight: 800,
		langJSON: 'designer/lang/default.json',
		designsJSON: 'designer/json/designs_categories.json',
		templatesDirectory: 'designer/html/',
		initialActiveModule: "",
		fonts: [
			{
				name: "Rowdies",
				url: "google"
			},
			{
				name: "Supermercado One",
				url: "google"
			},
			{
				name: "Quintessential",
				url: "google"
			},
			{
				name: "Raleway",
				url: "google"
			},
			{
				name: "Anton",
				url: "google"
			},
			{
				name: "Bebas Neue",
				url: "google"
			},
			{
				name: "Caveat",
				url: "google"
			},
			{
				name: "Teko",
				url: "google"
			},
		],
		customImageParameters: {
			minW: 100,
			minH: 100,
			maxW: 4000,
			maxH: 4000,
			minDPI: 0,
			maxSize: 10,
			autoCenter: true,
			autoSelect: true,
			copyable: true,
			draggable: true,
			resizable: true,
			removable: true,
			rotatable: true,
			zChangeable: true,
			resizeToH: 250,
			resizeToW: 250,
			colors: "#000000",
		},
		customTextParameters: {
			colors: true,
			removable: true,
			resizable: true,
			draggable: true,
			rotatable: true,
			autoCenter: true,
			curvable: true
		},
		mainBarModules: ['products', 'images', 'text', 'designs', 'dynamic-views'],
		actions: {
			"top": ["download", "print", "snap", "preview-lightbox"],
			"right": ["magnify-glass", "zoom", "reset-product", "qr-code"],
			"bottom": ["undo", "redo"],
			"left": ["info", "save", "load"]
		},
		toolbarPlacement: "smart",
		selectedColor: "#fe7c00",
		boundingBoxColor: "#fe7c00",
		outOfBoundaryColor: "red",
		cornerIconColor: "white",
		resizeToH: 250,
		guidedTour: {},
		customImageAjaxSettings: {
			url: 'designer/php/custom-image-handler.php',
			data: {
				saveOnServer: 1,
				uploadsDir: 'customimages',
				uploadsDirURL: 'designer/php/customimages/'
			}
		}
	};
	designer = new FancyProductDesigner($("#fpd"), opts);

	$('#savepr').click(function() {
		designer.getProductDataURL(function(dataURL) {
			$.post("designer/php/designedimages/save_image.php", {
				base64_image: dataURL
			}, function(data) {
				if (data) {
					console.log('Tasarım Yükleme Başarılı');
					$('#formgonder').submit();
				} else {
					console.log('Tasarım Yükleme Başarısız');
					alert('hata');
				}
			});
		});
	});
</script>
<?php
if ($urun->tasarlanabilir == 'true') {
?>
	<script type="text/javascript">
		$('document').ready(function() {
			setTimeout(function() {
				$.post("product_in_db.php", {
					action: 'load',
					id: <?= $urun->id ?>
				}, function(data) {
					designer.loadProduct(JSON.parse(data));
				});
			}, 1000);
		});
	</script>
<?php } ?>