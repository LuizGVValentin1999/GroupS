<?php 
@session_start();

if(!$_SESSION['login']['ID']){
    session_destroy();

    header("location:{$checkurl}home");

}

?>