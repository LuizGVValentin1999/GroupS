<?php 
@session_start();


if(!$_SESSION['login']['ID']){
    session_destroy();

    header("location:{$checkurl}home");

}
else if ($_GET['group']){
    include("System/Checker/conection.php");
    $query = " SELECT ID FROM USUARIO_GRUPO WHERE USUARIO = {$_SESSION['login']['ID']} AND GRUPO = {$_GET['group']}";
    $result_row = mysqli_query($con, $query);
    $row = mysqli_num_rows($result_row);
    if(!$row) {
        header("location:{$checkurl}meusGrupos");
    }
}

?>