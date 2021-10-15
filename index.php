<?php
date_default_timezone_set('america/sao_paulo');
clearstatcache();
session_start();
$url = (isset($_GET['url'])) ? $_GET['url']:'home';
$url = str_replace(".php", "", $url);
$contb = array_filter(explode('/',$url));
$file = $url =='admin'?'admin.php':"System/View/" .$url .".php";
$checkurl ="";
$checklink ="";
$_SESSION['URL-BASE'] = "https://groups.lvalentin.com.br/";
for ($i = 2; $i <= count($contb) ; $i++) { $checkurl = $checkurl."../"; }
for ($i = 0; $i <= count($contb) ; $i++) { $checklink = $checklink."../"; }
?>
<!DOCTYPE HTML>

<html lang="pt-br">
	<head>
        <title>Croud</title>
		<meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="<?=$checkurl?>System/Style/css/style.css" />
		<link rel="stylesheet" href="<?=$checkurl?>System/Style/css/main.css" />
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
		<noscript><link rel="stylesheet" href="<?=$checkurl?>System/Style/css/noscript.css" /></noscript>
    
	</head>
<body class="is-preload">
<div class="alert" id="alert">

</div>
<?php


if( $url != "home"){
    include('System/Checker/chekerlogin.php');
    include('System/View/navbar.php');
}

?>
<div id="wrapper">
<?php
if( strpos($url,"Group") !== false )
    include('System/View/navbarSistema.php');
if(is_file($file)){
	if($url != "home"){
		// include('System/Checker/chekerlogin.php');
	}
    include $file;
}else{
    include '404.php';
}


?>
</div>

 			<!-- Scripts -->
 <script src="<?=$checkurl?>System/Style/js/jquery.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/jquery.scrolly.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/jquery.scrollex.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/browser.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/breakpoints.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/util.js"></script>
<script src="<?=$checkurl?>System/Style/js/main.js"></script>
<script src="<?=$checkurl?>System/Style/js/function.js"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragscroll/0.0.8/dragscroll.min.js"></script>
	


	<script>
	<?php 
	if(@$_SESSION['callback']){
		foreach($_SESSION['callback'] as $callback){
	echo $callback;
		}	
	}
	unset($_SESSION['callback']);
	?>
	</script>
	</body>
</html>
