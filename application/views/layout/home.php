<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo isset($metaTitle)?(($metaTitle!='')?$metaTitle:META_TITLE):META_TITLE; ?></title>
<meta name="description" content="<?php echo isset($metaDes)?(($metaDes!='')?$metaDes:META_DES):META_DES; ?>" />
<meta name="keywords" content="<?php echo isset($metaKey)?(($metaKey!='')?$metaKey:META_KEYWORDS):META_KEYWORDS; ?>" />
 
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="<?php echo BASE_URL;?>assets/favicon.ico" />

<!---------------------- BootStrap ------------------->
<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/bootstrap-theme.min.css">

<!---------------------- Jquerry UI ------------------->
<link href="<?php echo BASE_URL;?>assets/css/jquery-ui.css" rel="stylesheet">

<!---------------------- Google Font ----------------->
<link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic' rel='stylesheet' type='text/css'>

<!---------------------- Font awesome ----------------->

<link href="<?php echo BASE_URL;?>assets/css/thrnprf.css" rel="stylesheet">
<!--[if lt IE 8]><!-->
	<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/thrnprf-ie7.css">
<!--<![endif]-->

<!---------------------- Scrollbar (mCustomScrollbar) ----------------->
<link href="<?php echo BASE_URL;?>assets/css/jquery.mCustomScrollbar.css" rel="stylesheet">

<!----------------- Toggle menu ------------------------->
<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/jquery.sidr.light.css">

<!----------------- uniform.js ------------------------->
<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/uniform.default.css">

<!---------------------- Custom Css ----------------->
<link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/main.css">

<script src="<?php echo BASE_URL;?>assets/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo BASE_URL;?>assets/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
<script src="<?php echo BASE_URL;?>assets/js/vendor/bootstrap.min.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/jquery-ui.js"></script>
<script language="javascript">
var BASE_URL = "<?php echo BASE_URL;?>";

</script>
</head>
<body>
<!--[if lt IE 7]>
    <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
	<!------- Header ------>
	<!-- <a href="javascript:void(0)" class="toggle-menu"><i class="cf icon-align-justify"></i></a> -->
	<?php echo  $this->load->view('header');?>
	<!-------- banner ---------->
	<?php echo  $this->load->view('banners');?>
	<!-------- End banner ---------->
	
	 <?php echo $content_for_layout;?>
	
	<!---------------- Footer ----------------->
	<?php echo  $this->load->view('footer');?>
	<!---------------- End Footer ----------------->
<script src="<?php echo BASE_URL;?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/slider.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/jquery.mCustomScrollbar.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/jquery.mousewheel.js"></script>
<!--<script src="<?php echo BASE_URL;?>assets/js/zebra_pin.js"></script> -->
<script src="<?php echo BASE_URL;?>assets/js/retina.min.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/responsive-tabs.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/jquery.uniform.js"></script>
<script src="<?php echo BASE_URL;?>assets/js/main.js"></script>
</body>
</html>
