<?php 
@session_start();

if(!$_SESSION['adm']){
    session_destroy();

    header("location:{$checkurl}home");
}

?>