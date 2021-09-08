<?php
switch ($_POST['funcao']) {
    case 'busca':
        listagem($_POST);
        break;
    case 'form':
        form($_POST);
        break;
    default:
        echo "i equals 2";
        break;
}

function listagem($post)
{
    include('../../../System/Checker/conection.php');
    if ($post['BUSCA'])
        $query = " SELECT * FROM AREAS_CONHECIMENTO WHERE NOME LIKE '%".$post['BUSCA']."%'  ";
    else
        $query = " SELECT * FROM AREAS_CONHECIMENTO ";

    $result_user = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result_user)){
        ?>
        <input type="checkbox" value="<?=$info['ID']?>" id="area_<?=$info['ID']?>" name="AREA[<?=$info['ID']?>]">
        <a onclick="$('#area_<?=$info["ID"]?>').click(); $( '#area_overlay_<?=$info["ID"]?>').toggleClass('area_check'); " style=" --bg-color: <?=$info['BG']?>; --bg-color-light: <?=$info['COR']?>; --text-color-hover: #4C5656; --box-shadow-color: <?=$info['BG']?>" class="card education">
           <div id="area_overlay_<?=$info['ID']?>" class="overlay"></div>
            <div style="background-image: url('../../System/App/Files/Img/<?=$info['CAMINHO']?>'); background-size: 100% 100%; " class="circle">
                <svg width="71px" height="76px" viewBox="29 14 71 76"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                </svg>
            </div>
            <p><?=$info['NOME']?></p>

        </a>

    <?php }
}

function form($post)
{
    session_start();
     $areas = implode(',',$post['AREA']);
    include('../../../System/Checker/conection.php');


    $query = "UPDATE USUARIO SET `AREAS_CONHECIMENTO` = '".$areas."' WHERE (`ID` = '".$_SESSION['login']['ID']."');";

    $result_user = mysqli_query($con, $query);
    header("Location: ../../../GroupS/grupos");
}

?>
