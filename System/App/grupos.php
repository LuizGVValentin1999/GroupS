<?php
switch ($_POST['funcao']) {
    case 'busca':
        listagem($_POST);
        break;
    case 'form':
        form($_POST);
        break;
    case 'buscaNosMeus':
        listagemMeusGrupos($_POST);
        break;
    default:
        entrarnogrupo($_GET,$_POST);
        break;
}

function listagem($post)
{
    session_start();
    include('../../System/Checker/conection.php');

    $filtro = " WHERE ";
    $filtroTipo = '';
    $filtroAreasSelecionadas = "AREAS_CONHECIMENTO IN({$_SESSION['login']['AREAS_CONHECIMENTO']})";
    $filtroNaoAreasSelecionadas = "AREAS_CONHECIMENTO NOT IN({$_SESSION['login']['AREAS_CONHECIMENTO']})";
    if ($post['BUSCA'])
     $busca = " NOME LIKE '%".$post['BUSCA']."%'   ";

    if ($post['TIPO'] == "publicosGrupos")
        $filtroTipo .= " TIPO = 'L' ";
    else if ($post['TIPO'] == "privadosGrupos")
        $filtroTipo .= " TIPO = 'P' ";

    if ($filtroTipo)
        $filtro .= $filtroTipo;
    if ($filtroTipo && $busca )
        $filtro .= " AND " .$busca ;
    else if ($busca)
        $filtro .= $busca ;
    else if(!$filtroTipo)
        unset($filtro);


    if ($post['TIPO']=="meusGrupos"){
        $query = " SELECT G.* FROM GRUPO G JOIN USUARIO_GRUPO AS UG ON UG.GRUPO = G.ID AND UG.USUARIO = {$_SESSION['login']['ID']} {$filtro}";
    }
    else{
        if ($filtro){
            $Nfiltro = $filtro." AND ".$filtroNaoAreasSelecionadas;
            $filtro .= "AND ".$filtroAreasSelecionadas;
        }
        else{
            $Nfiltro = " WHERE ".$filtroNaoAreasSelecionadas;
            $filtro = "WHERE ".$filtroAreasSelecionadas;
        }
        $query = " SELECT * FROM GRUPO {$filtro} ";
        $Nquery = "SELECT * FROM GRUPO {$Nfiltro} ";
    }
    $result = mysqli_query($con, $query);
   ?>
      <div class="table-wrapper">
            <table>
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                </tr>
                </thead>
                <tbody>
                <?php

    while ($info = mysqli_fetch_array($result)){
        ?>

            <tr onclick="entrarnogrupo('<?=$info['ID']?>','<?=$info['TIPO']?>','<?=$info['NOME']?>');" >
                <td><?=$info['NOME']?></td>
                <td><?=$info['DESCRICAO']?></td>
                <td><?=$info['TIPO']=='L'?'<span class="icon solid alt fa-user" ></span>':'<span class="icon solid alt fa-user-lock" ></span>';?></td>
            </tr>


    <?php }
    $Nresult = mysqli_query($con, $Nquery);
    while ($info = mysqli_fetch_array($Nresult)){
        ?>
            <tr onclick="entrarnogrupo('<?=$info['ID']?>','<?=$info['TIPO']?>','<?=$info['NOME']?>');" >
                <td><?=$info['NOME']?></td>
                <td><?=$info['DESCRICAO']?></td>
                <td><?=$info['TIPO']=='L'?'<span class="icon solid alt fa-user" ></span>':'<span class="icon solid alt fa-user-lock" ></span>';?></td>
            </tr>
    <?php }

                ?>
                </tbody>
            </table>
      </div>
<?php
}

function listagemMeusGrupos($post)
{
    session_start();
    include('../../System/Checker/conection.php');

    $filtro = " WHERE ";
    $filtroTipo = '';
    if ($post['BUSCA'])
        $busca = " G.NOME LIKE '%".$post['BUSCA']."%'   ";

    if ($post['TIPO'] == "publicosGrupos")
        $filtroTipo .= " G.TIPO = 'L' ";

    if ($post['TIPO'] == "privadosGrupos")
        $filtroTipo .= " G.TIPO = 'P' ";

    if ($filtroTipo)
        $filtro .= $filtroTipo;

    if ($filtroTipo && $busca )
        $filtro .= " AND " .$busca ;
    else if ($busca)
        $filtro .= $busca ;
    else if(!$filtroTipo)
        unset($filtro);


    $query = " SELECT G.* FROM GRUPO G JOIN USUARIO_GRUPO AS UG ON UG.GRUPO = G.ID AND UG.USUARIO = {$_SESSION['login']['ID']} {$filtro} ";

    $result_user = mysqli_query($con, $query);?>
    <div class="table-wrapper">
        <table>
            <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Tipo</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $zindex =999;
            while ($info = mysqli_fetch_array($result_user)){
                ?>


                <tr  >
                    <td onclick="$(location).attr('href', '../../System/App/grupos.php?group=<?=$info['ID']?>&funcao=entrarnogrupo');" ><?=$info['NOME']?></td>
                    <td onclick="$(location).attr('href', '../../System/App/grupos.php?group=<?=$info['ID']?>&funcao=entrarnogrupo');" ><?=$info['DESCRICAO']?></td>
                    <td style="display: flex;"><?=$info['TIPO']=='L'?'<span class="icon solid alt fa-user" ></span>':'<span class="icon solid alt fa-user-lock" ></span>';?> <div onclick="$('.opc_<?=$info['ID']?>').toggle()" style=" display:none;position: absolute; right: 10px; z-index: <?=$zindex--?>;" ><span class="icon solid alt fa-ellipsis-h" ></span>
                            <ul class="menu opc_<?=$info['ID']?>">
                                <li><a>Sair do grupo</a></li>
                                <li><a>Excluir Grupo</a></li>
                                <li><a>Denunciar</a></li>
                            </ul>
                        </div></td>
                </tr>


            <?php }
            ?>
            </tbody>
        </table>
    </div>
    <?php
}

function form($post)
{
    session_start();
    include('../../System/Checker/conection.php');

    $post['CODIGO_ACESSO'] = random_str_generator(5);
    if ($_SESSION['msg']['erro']){
        echo "<script>aletmsg();</script>";
        exit();
    }
    else{
        $query = "INSERT INTO GRUPO (NOME, DESCRICAO, AREAS_CONHECIMENTO, TIPO, USUARIOCRIOU,CODIGO_ACESSO) VALUES ('{$post['NOME']}', '{$post['DESCRICAO']}', '{$post['AREACONHECIMENTO']}', '{$post['TIPO']}', '{$_SESSION['login']['ID']}', '{$post['CODIGO_ACESSO']}');";

        $result_user = mysqli_query($con, $query);
        $idInserido=mysqli_insert_id($con);

        $query = "INSERT INTO USUARIO_GRUPO (USUARIO,GRUPO,ADM) VALUES ('{$_SESSION['login']['ID']}', '{$idInserido}', '1');";
        mysqli_query($con, $query);

        echo "<script> $(location).attr('href', '../../Group/forum?group={$idInserido}'); </script>";
        exit();
    }

}


function entrarnogrupo($get,$post)
{
    if ($get)
        $post= $get;
    session_start();
    include('../../System/Checker/conection.php');



    if ($post['group']){
        $query = "SELECT ID FROM USUARIO_GRUPO where USUARIO = '{$_SESSION['login']['ID']}' AND GRUPO = '{$post['group']}'  ";

        $result_row = mysqli_query($con, $query);
        $vinculo_existente = mysqli_num_rows($result_row);
        if ($vinculo_existente){
            if ($get)
                header("Location: ../../Group/forum?group={$post['group']}");
            else
                echo '1';
            exit();
        }
        else{
            $query = "SELECT ID FROM GRUPO where ID = '{$post['group']}' AND (CODIGO_ACESSO = '{$post['CODIGO_ACESSO']}' OR TIPO = 'L' )   ";

            $result_row = mysqli_query($con, $query);
            $acesso_liberado= mysqli_num_rows($result_row);
            if ($acesso_liberado){
                $query = "INSERT INTO USUARIO_GRUPO (USUARIO,GRUPO) VALUES ('{$_SESSION['login']['ID']}', '{$post['group']}');";
                mysqli_query($con, $query);
                header("Location: ../../Group/forum?group={$post['group']}");
                exit();
            }
            else{
                if (!$post['validar']){
                    $_SESSION['msg']['erro'][] = "Código de acesso invalido.";
                    echo "<script>aletmsg();</script>";
                }
                exit();
            }

        }
    }
    header("Location: .$newURL.php");
    exit();
}

function random_str_generator ($len_of_gen_str){
    $chars = "0ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789";
    $var_size = strlen($chars);
    $random_str = '';
    for( $x = 0; $x < $len_of_gen_str; $x++ ) {
        $random_str .= $chars[ rand( 0, $var_size - 1 ) ];
    }
    return $random_str;
}

?>
