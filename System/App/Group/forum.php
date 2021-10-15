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

}

function lista($post)
{
    session_start();
    include('../../../System/Checker/conection.php');


    $query = "SELECT *  FROM FORUM F JOIN USUARIO AS U ON F.USUARIO = U.ID  WHERE F.GRUPO = {$post['GRUPO']} ORDER BY F.ID DESC";

    $result = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result)){
        $info['CONTEUDO'] = json_decode(preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']),true);

        if ($info['CONTEUDO']['ARQUIVO']){
        ?>
        <div class="post">
            <div class="header-post">
                <div class="user-post">
                    <div class="profile"style="display: flex;" >
                        <img src="../System/Style/images/Usuarios/userD.png" alt="Avatar" style="width:12%; float: left; border-radius: 50%;">
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
                <?php } else {?>
                        <div class="blog-card spring-fever" >
                         <div class="card-info">
                           <a  class="button" style="letter-spacing:0 !important; width: 410px !important;  overflow: hidden; text-overflow: ellipsis;" download="<?=$info['CONTEUDO']['ARQUIVO_NOME']?>" href="'../../../System/App/Files/foruns/<?=$info['CONTEUDO']['ARQUIVO']?>">Baixar o arquivo <?=$info['CONTEUDO']['ARQUIVO_NOME']?> !</a>
                         </div>
                <?php }?>
                <div class="utility-info">
                    <ul class="utility-list">
                        <li><span class="licon icon-like"></span><a href="#">2</a></li>
                        <li><span class="licon icon-com"></span><a href="#">12</a></li>
                        <li class="date-post"><span class="licon icon-dat"></span>03 jun 2017</li>
                    </ul>
                </div>
                <div class="gradient-overlay"></div>
                  <?php if (!in_array(end(explode('.',$info['CONTEUDO']['ARQUIVO'])),array('jpg' ,'png', 'gif','raw','bmp','jpge','bit','jpe'))){
                 ?>
                        <div class="color-overlay"></div>
                <?php } ?>
            </div>
        </div>

    <?php }
    else{
        ?>

        <div class="post">
            <div class="header-post">
                <div class="user-post">
                    <div class="profile"style="display: flex;" >
                        <img src="../System/Style/images/Usuarios/userD.png" alt="Avatar" style="width:12%; float: left; border-radius: 50%;">
                        <span style="margin-top: auto; margin-bottom: auto; padding-left: 5px;"><?=$info['NOME']?></span>
                    </div>
                </div>
                <div class="text-post">
                    <span style="margin: auto; "></span>
                </div>
            </div>
            <div class="blog-card spring-fever">
                <div class="card-info">
                    <?= $info['CONTEUDO']['TEXTO']?>
<!--                    <a href="#">Read Article<span class="licon icon-arr icon-black"></span></a>-->
                </div>
                <div class="utility-info">
                    <ul class="utility-list">
                        <li><span class="licon icon-like"></span><a href="#">2</a></li>
                        <li><span class="licon icon-com"></span><a href="#">12</a></li>
                        <li class="date-post"><span class="licon icon-dat"></span>03 jun 2017</li>
                    </ul>
                </div>
                <div class="gradient-overlay"></div>
                <div class="color-overlay"></div>
            </div>
        </div>


        <?php
    }
    }
}
