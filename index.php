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
        <title>Group S</title>
        <link href="<?=$checkurl?>System/Style/images/icon.png" rel="icon">
        <link href="<?=$checkurl?>System/Style/images/icon.png" rel="apple-touch-icon">
		<meta charset="utf-8" />
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="<?=$checkurl?>System/Style/css/style.css?n=3" />
		<link rel="stylesheet" href="<?=$checkurl?>System/Style/css/main.css?n=3" />
		<noscript><link rel="stylesheet" href="<?=$checkurl?>System/Style/css/noscript.css?n=3" /></noscript>
    
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
    include $file;
}else{
    include '404.php';
}


?>
</div>
<?php

if( $url != "home"){
?>
<!--<div class="modal" style="display: none" id="modal-Atualizacao">-->
<!--    <div class="modal-sandbox"></div>-->
<!--    <div class="modal-box"  style="width: 100%;">-->
<!--        <div class="modal-header">-->
<!--            <div class="close-modal close">&#10006;</div>-->
<!--            <h1 style="font-size: 2em;">TERMO DE CONSENTIMENTO LIVRE E ESCLARECIDO</h1>-->
<!--        </div>-->
<!--        <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>-->
<!--        <div class="modal-body" >-->
<!--            <div>-->
<!--                <p>Nós, Caroline Mazetto Mendes e Luiz Gustavo Valter Valentin, pesquisadores do Centro Universitário-->
<!--                    Campos de Andrade – UNIANDRADE, estamos convidando você a participar de um estudo intitulado-->
<!--                    “Aplicação web para auxílio a estudos colaborativos”.-->
<!--                </p>-->
<!--                <br/>-->
<!--                <p>-->
<!--                    Para participar da pesquisa, você deverá ler o Termo de Consentimento Livre e Esclarecido (TCLE) disponível no link abaixo. É importante você saber também que após realizar o teste eu vou entrar em contato, dentro de alguns dias, para obter a sua assinatura e entregar a você uma cópia do termo assinado pelos pesquisadores responsáveis.-->
<!--                </p>-->
<!--                <a  class="button" style="letter-spacing:0 !important; width: 100% !important; overflow: hidden; text-overflow: ellipsis; background-color: #2d3978;" download="TCLE.pdf" href="'../../../System/App/Files/TCLE.pdf">Baixar o arquivo TCLE!</a>-->
<!--                <p>-->
<!--                    Após utilizar e testar a aplicação, preencher o questionário.-->
<!--                </p>-->
<!--                <a  class="button" style="letter-spacing:0 !important; width: 100% !important;  overflow: hidden; text-overflow: ellipsis; background-color: #2d3978;" href="https://forms.gle/PpHR1Cg4DiMD15R87">Questionário</a>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<?php } ?>
 			<!-- Scripts -->
 <script src="<?=$checkurl?>System/Style/js/jquery.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/jquery.scrolly.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/jquery.scrollex.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/browser.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/breakpoints.min.js"></script>
<script src="<?=$checkurl?>System/Style/js/util.js"></script>
<script src="<?=$checkurl?>System/Style/js/main.js"></script>
<script src="<?=$checkurl?>System/Style/js/function.js?n=3"></script>
<script src="<?=$checkurl?>System/Style/js/calendario.js?n=3"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dragscroll/0.0.8/dragscroll.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	


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
