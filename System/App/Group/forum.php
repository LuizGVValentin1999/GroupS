<?php

switch ($_POST['funcao']) {
    case 'forum':
        lista($_POST);
        break;
    case 'form':
        form($_POST,$_FILES);
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
        var_dump($_SESSION['login']['ID']);
    }
    header('location:../../../Group/forum?group='.$post['GRUPO']);

}

function lista($post)
{
    session_start();
    include('../../../System/Checker/conection.php');


    $query = "SELECT *  FROM FORUM F JOIN USUARIO AS U ON F.USUARIO = U.ID  WHERE F.GRUPO = {$post['GRUPO']} ORDER BY F.ID DESC";

    $result = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result)){
        $info['CONTEUDO'] = json_decode(preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']),true);

        ?>
        <div class="post">
            <div class="header-post">
                <div class="user-post">
                    <div class="profile"style="display: flex;" >
                        <img src="../System/Style/images/Usuarios/userD.png" alt="Avatar" style="width:3em; float: left; border-radius: 50%;">
                        <span style="margin-top: auto; margin-bottom: auto; padding-left: 5px;"><?=$info['NOME']?></span>
                    </div>
                </div>
                <div class="text-post">
                    <span style="margin: auto; "><?= $info['CONTEUDO']['TEXTO']?></span>
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
                       <li><span class="icon fa-thumbs-up iconscolor"></span><a href="#">2</a></li>
                        <li><span class="icon fa-comment-alt iconscolor"></span><a href="#">12</a></li>
                        <li class="date-post"><span class="icon fa-calendar-alt iconscolor"></span>03 jun 2017</li>
                    </ul>
                </div>
                <div class="gradient-overlay"></div>
                  <?php if (!in_array(end(explode('.',$info['CONTEUDO']['ARQUIVO'])),array('jpg' ,'png', 'gif','raw','bmp','jpge','bit','jpe','mp4' ,'avi'))){
                 ?>
                        <div class="color-overlay"></div>
                <?php } ?>
            </div>
            <div class="comentarios">
                <div class="container <?=$info['USUARIO']==$_SESSION['login']['ID']?'darker':''?>">
                    <img src="../System/Style/images/Usuarios/userD.png" alt="Avatar" style="width:100%;">
                    <span class="blue" style="margin-top: auto; margin-bottom: auto; padding-left: 5px;"><?=$info['NOME']?></span>
                    <p class="black"><?=preg_replace( "/\r|\n/", '<br>', $info['MENSAGEM'])?> dd dsa dsads dsad </p>
                    <span class="time"><?=$info['DATAINCLUSAO']?></span>
                </div>
                <div class="col-6 col-12-xsmall" style="margin: 1%; top: 80%;">
                    <ul class="actions fit">
                        <input type="hidden" id="GRUPO" name="GRUPO" value="<?=$_GET['group']?>">
                        <li>  <textarea style="width: 100%" type="text" name="MENSAGEM" id="MENSAGEM" value="" placeholder="Texto"  rows="1"></textarea></li>
                        <span style="margin: 1%;" onclick="enviar()"  class="icon solid alt fa-paper-plane"></span>
                    </ul>
                </div>
            </div>
        </div>


    <?php

    }
}
