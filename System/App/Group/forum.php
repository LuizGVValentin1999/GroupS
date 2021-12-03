<?php

switch ($_POST['funcao']) {
    case 'forum':
        lista($_POST);
        break;
    case 'form':
        form($_POST,$_FILES);
        break;
    case 'comentarios':
        comentarios($_POST);
        break;
    case 'formcomentario':
        formcomentario($_POST);
        break;
    case 'like':
        like($_POST);
        break;
    case 'remover':
        remover($_POST);
        break;
    default:
        echo "i equals 2";
        break;
}



function form($post,$files)
{
    if ($post['TEXTO'] || $files['ARQUIVO']['name'] ){
        session_start();
        $areas = implode(',',$post['AREA']);
        include('../../../System/Checker/conection.php');

        if((bool)$files['ARQUIVO']['name']){

            $extensao = explode('.',$files['ARQUIVO']['name'])[1];

            $novo_nome = $_SESSION['login']['ID'].md5(time()). ".".$extensao;

            $diretorio = "../../../System/App/Files/foruns/";

            move_uploaded_file($files['ARQUIVO']['tmp_name'], $diretorio.$novo_nome);


        }

        $i_inset['TEXTO'] =  trim($post['TEXTO']);
        $i_inset['ARQUIVO'] = $novo_nome;
        $i_inset['ARQUIVO_NOME'] = $files['ARQUIVO']['name'];


        $query = "INSERT INTO FORUM (CONTEUDO,GRUPO,USUARIO) VALUES ('".json_encode($i_inset,JSON_UNESCAPED_UNICODE)."', '{$post['GRUPO']}', '". $_SESSION['login']['ID']."');";

        $result_user = mysqli_query($con, $query);
    }
    header('location:../../../Group/forum?group='.$post['GRUPO']);

}

function remover($post){
    session_start();
    include('../../../System/Checker/conection.php');
    $query = "DELETE FROM FORUM WHERE ID={$post['POSTF']};";

    $result_user = mysqli_query($con, $query);
}

function lista($post)
{
    session_start();
    include('../../../System/Checker/conection.php');


    $query = "SELECT F.*, U.USUARIO AS NOME, U.FOTO, C.ID AS CURTIDA, (SELECT COUNT(*) FROM FORUM_COMENTARIO WHERE FORUM = F.ID) AS QTDE_COMENTARIO, (SELECT COUNT(*) FROM FORUM_CURTIDA WHERE FORUM = F.ID) AS QTDE_LIKE 
                FROM FORUM F 
                    JOIN USUARIO AS U ON F.USUARIO = U.ID 
                   LEFT JOIN FORUM_CURTIDA AS C ON C.USUARIO = {$_SESSION['login']['ID']}  AND C.FORUM = F.ID
                WHERE F.GRUPO = {$post['GRUPO']} ORDER BY F.ID DESC";


    $result = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result)){
        $info['CONTEUDO'] = json_decode(preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']),true);
    $date = date_create($info['DATAINCLUSAO']);
    $foto = $info['FOTO']?'../System/App/Files/Users/'.$info['FOTO']:"../System/Style/images/Usuarios/userD.png";
        ?>
        <div class="post post_<?=$info['ID']?>">
            <div class="header-post">
                <div class="user-post" >
                    <div class="profile"style="display: flex; width: 100%" >
                        <img src="<?=$foto?>" alt="Avatar" >
                        <span style="margin-top: auto; margin-bottom: auto; padding-left: 5px; width: 90%"><?=$info['NOME']?></span>
                        <div onclick="$('.opc_<?=$info['ID']?>').toggle()"  ><span class="icon solid alt fa-ellipsis-h" ></span>
                            <ul class="menu opc_<?=$info['ID']?>">
                            <?=$info['USUARIO']==$_SESSION['login']['ID']?
                                "<li onclick='remover(".$info['ID'].")'><a>Excluir</a></li>":
                                "<li><a>Denunciar</a></li>";
                            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="text-post">
                <?php if ($info['CONTEUDO']['ARQUIVO']) {?>
                    <span style="margin: auto; "><?= $info['CONTEUDO']['TEXTO']?></span>
                    <?php }?>
                </div>
            </div>
                <?php if (in_array(end(explode('.',$info['CONTEUDO']['ARQUIVO'])),array('jpg' ,'png', 'gif','raw','bmp','jpge','bit','jpe'))){
                 ?>
                        <div class="blog-card spring-fever" style="background-image: url('../../../System/App/Files/foruns/<?=$info['CONTEUDO']['ARQUIVO']?>');">
                <?php } else if (in_array(end(explode('.',$info['CONTEUDO']['ARQUIVO'])),array('mp4' ,'avi'))) {?>
                        <div class="blog-card spring-fever" style="background: #1a1a1a;" >
                        <video style="width: inherit; height: 80%" controls="controls"  >
                            <source src="../../../System/App/Files/foruns/<?=$info['CONTEUDO']['ARQUIVO']?>" type="video/mp4" />
                            <!--Suportado em IE9, Chrome 6 e Safari 5 -->
                            O seu navegador não suporta a tag vídeo
                        </video>
                <?php } else if ($info['CONTEUDO']['ARQUIVO']) {?>
                        <div class="blog-card spring-fever" >
                         <div class="card-info">
                           <a  class="button" style="letter-spacing:0 !important; width: 91% !important;  overflow: hidden; text-overflow: ellipsis;" download="<?=$info['CONTEUDO']['ARQUIVO_NOME']?>" href="'../../../System/App/Files/foruns/<?=$info['CONTEUDO']['ARQUIVO']?>">Baixar o arquivo <?=$info['CONTEUDO']['ARQUIVO_NOME']?> !</a>
                         </div>
                <?php } else { ?>
                        <div class="blog-card spring-fever" >
                         <div class="card-info">
                             <?= $info['CONTEUDO']['TEXTO']?>
                         </div>
                <?php }?>
                <div class="utility-info">
                    <ul class="utility-list">
                       <li onclick="like(<?=$info['ID']?>)"><span id="like_<?=$info['ID']?>" class="icon <?=$info['CURTIDA']?'solid':''?> fa-thumbs-up iconscolor"></span><a id="qtde_like_<?=$info['ID']?>"><?=$info['QTDE_LIKE']?></a></li>
                        <li onclick="comentarios(<?=$info['ID']?>)"><span class="icon fa-comment-alt iconscolor"></span><a id="qtde_comentario_<?=$info['ID']?>"><?=$info['QTDE_COMENTARIO']?></a></li>
                        <li class="date-post"><span class="icon fa-calendar-alt iconscolor"></span><?=date_format($date,'d-m-y : H:i ' )?>m</li>
                    </ul>
                </div>
                <div class="gradient-overlay"></div>
                  <?php if (!in_array(end(explode('.',$info['CONTEUDO']['ARQUIVO'])),array('jpg' ,'png', 'gif','raw','bmp','jpge','bit','jpe','mp4' ,'avi'))){
                 ?>
                        <div class="color-overlay"></div>
                <?php } ?>
            </div>
            <div class="comentarios comentarios_<?=$info['ID']?>" style="display: none">
                <div class="comentario_<?=$info['ID']?>">

                </div>
                <div class="col-6 col-12-xsmall" style="margin: 1%; top: 80%;">
                    <ul class="actions fit">
                        <input type="hidden" id="GRUPO" name="GRUPO" value="<?=$_GET['group']?>">
                        <li>  <textarea style="width: 100%" type="text" name="COMENTARIO" id="COMENTARIO_<?=$info['ID']?>" value="" placeholder="Texto"  rows="1"></textarea></li>
                        <span style="margin: 1%;" onclick="formcomentario(<?=$info['ID']?>)"  class="icon solid alt fa-paper-plane"></span>
                    </ul>
                </div>
            </div>
        </div>


    <?php

    }
}


function comentarios($post)
{
   session_start();
    include('../../../System/Checker/conection.php');
    $query = "SELECT C.USUARIO, C.CONTEUDO, C.DATAINCLUSAO, U.USUARIO AS NOME, U.FOTO FROM FORUM_COMENTARIO C  JOIN USUARIO AS U ON C.USUARIO = U.ID WHERE FORUM = {$post['POSTF']} ORDER BY C.ID ASC ";
    $result_user = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result_user)){
        $info['CONTEUDO'] = json_decode(preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']),true);
        $date = date_create($info['DATAINCLUSAO']);
        $foto = $info['FOTO']?'../System/App/Files/Users/'.$info['FOTO']:"../System/Style/images/Usuarios/userD.png";
        ?>
        <div class="container <?=$info['USUARIO']==$_SESSION['login']['ID']?'darker':''?>">
            <img src="<?=$foto?>" alt="Avatar" >
            <span class="blue" style="margin-top: auto; margin-bottom: auto; padding-left: 5px;"><?=$info['NOME']?></span>
            <p class="black"><?=preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']['COMENTARIO'])?></p>
            <span class="time"><?=date_format($date,'d-m-y : H:i ' )?></span>
        </div>
    <?php }


}

function formcomentario($post)
{
    $post['COMENTARIO'] = trim($post['COMENTARIO']);
    if ((string)$post['COMENTARIO']) {
        session_start();
        $areas = implode(',', $post['AREA']);
        include('../../../System/Checker/conection.php');

        $i_inset['COMENTARIO'] = $post['COMENTARIO'];
        $query = "INSERT INTO FORUM_COMENTARIO (FORUM, USUARIO, CONTEUDO) VALUES ('{$post['POSTF']}', '{$_SESSION['login']['ID']}', '" . json_encode($i_inset,JSON_UNESCAPED_UNICODE) ."');";

        mysqli_query($con, $query);
    }
}

function like($post)
{

    session_start();
    $areas = implode(',', $post['AREA']);
    include('../../../System/Checker/conection.php');

    $query = "SELECT ID FROM FORUM_CURTIDA where USUARIO = '{$_SESSION['login']['ID']}' AND FORUM = '{$post['POSTF']}';";

    $result_row = mysqli_query($con, $query);
    $like_existente = mysqli_num_rows($result_row);

    if (!$like_existente){
        $query = "INSERT INTO FORUM_CURTIDA (FORUM, USUARIO) VALUES ('{$post['POSTF']}', '{$_SESSION['login']['ID']}');";
        echo 1;
    }
    else{
        $query = "DELETE FROM FORUM_CURTIDA WHERE  USUARIO = '{$_SESSION['login']['ID']}' AND FORUM = '{$post['POSTF']}';";
    }

        mysqli_query($con, $query);

}