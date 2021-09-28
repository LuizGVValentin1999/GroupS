<?php

switch ($_POST['funcao']) {
    case 'busca':
        chat($_POST);
        break;
    case 'form':
        form($_POST);
        break;
    default:
        echo "i equals 2";
        break;
}

function form($post)
{
    session_start();
    $areas = implode(',',$post['AREA']);
    include('../../../System/Checker/conection.php');


    $query = "INSERT INTO CHAT (MENSAGEM, IMAGEM, ARQUIVO, GRUPO, USUARIO) VALUES ('".$post['MENSAGEM']."', '', '', '1', '".$_SESSION['login']['ID']."');";

    $result_user = mysqli_query($con, $query);
    header("Location: ../../../Group/chat");
}

function chat($post)
{
    session_start();
    include('../../../System/Checker/conection.php');

    $query = "SELECT * FROM CHAT ";


    $result_user = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result_user)){
        ?>
        <div class="container <?=$info['USUARIO']==$_SESSION['login']['ID']?'darker':''?>">
            <img src="../System/Style/images/Usuarios/userD.png" alt="Avatar" style="width:100%;">
            <p class="black"><?=$info['MENSAGEM']?></p>
            <span class="time"><?=$info['DATAINCLUSAO']?></span>
        </div>

    <?php }
}