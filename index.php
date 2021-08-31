<?php
session_start();
$url = (isset($_GET['url'])) ? $_GET['url']:'home';
$url = str_replace(".php", "", $url);
$contb = array_filter(explode('/',$url));
$file = $url =='admin'?'admin.php':"System/View/" .$url .".php";
$checkurl ="";
$checklink ="";
for ($i = 2; $i <= count($contb) ; $i++) { $checkurl = $checkurl."../"; }
for ($i = 3; $i <= count($contb) ; $i++) { $checklink = $checklink."../"; }
?>
<!DOCTYPE HTML>

<html>
	<head>
        <title>Croud</title>
		<meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="<?=$checkurl?>System/Style/css/style.css" />
		<link rel="stylesheet" href="<?=$checkurl?>System/Style/css/main.css" />
		<noscript><link rel="stylesheet" href="<?=$checkurl?>System/Style/css/noscript.css" /></noscript>
    
	</head>
<body class="is-preload">

<?php
include('System/View/navbar.php');
if( $url == "home"){
//  include('System/View/navbar.php');
}
else if(@$_SESSION['adm']){
	include('System/View/Sistema/navbar.php');
}
?>
<div id="wrapper">
<?php

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
