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
    $post['MENSAGEM'] = trim($post['MENSAGEM']);
    if ((string)$post['MENSAGEM']) {
        session_start();
        $areas = implode(',', $post['AREA']);
        include('../../../System/Checker/conection.php');


        $query = "INSERT INTO CHAT (MENSAGEM, IMAGEM, ARQUIVO, GRUPO, USUARIO) VALUES ('" . $post['MENSAGEM'] . "', '', '', ' {$post['GRUPO']}', '" . $_SESSION['login']['ID'] . "');";

        $result_user = mysqli_query($con, $query);
    }
}

function chat($post)
{
    session_start();
    include('../../../System/Checker/conection.php');
    $query = "SELECT C.USUARIO, C.MENSAGEM, C.DATAINCLUSAO, U.USUARIO AS NOME, U.FOTO FROM CHAT C  JOIN USUARIO AS U ON C.USUARIO = U.ID WHERE GRUPO = {$post['GRUPO']} ORDER BY C.ID ASC LIMIT 100 OFFSET ".(int)$_SESSION['CHAT']['OFFSET'];
    $result_user = mysqli_query($con, $query);
    $atualiza = false;
    while ($info = mysqli_fetch_array($result_user)){
        $_SESSION['CHAT']['OFFSET']++;
        $atualiza = true;
        $date = date_create($info['DATAINCLUSAO']);
        $foto = $info['FOTO']?'../System/App/Files/Users/'.$info['FOTO']:"../System/Style/images/Usuarios/userD.png";
        ?>
        <div class="container <?=$info['USUARIO']==$_SESSION['login']['ID']?'darker':''?>">
            <img src="<?=$foto?>" alt="Avatar" style="width:100%;">
            <span class="blue" style="margin-top: auto; margin-bottom: auto; padding-left: 5px;"><?=$info['NOME']?></span>
            <p class="black"><?=preg_replace( "/\r|\n/", '<br>', $info['MENSAGEM'])?></p>
            <span class="time"><?=date_format($date,'d-m-y : H:i ' )?></span>
        </div>
    <?php }
    if ($atualiza == false)
        echo "1";
          exit();
}
