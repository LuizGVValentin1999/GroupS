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
    include('../../System/Checker/conection.php');

    $filtro = " WHERE ";
    $filtroTipo = '';
    if ($post['BUSCA'])
     $busca = " NOME LIKE '%".$post['BUSCA']."%'   ";

    if ($post['TIPO'] == "publicosGrupos")
        $filtroTipo .= " TIPO = 'L' ";

    if ($post['TIPO'] == "privadosGrupos")
        $filtroTipo .= " TIPO = 'P' ";

    if ($filtroTipo)
        $filtro .= $filtroTipo;

    if ($filtroTipo && $busca )
        $filtro .= " AND " .$busca ;
    else if ($busca)
        $filtro .= $busca ;
    else if(!$filtroTipo)
        unset($filtro);


        $query = " SELECT * FROM GRUPO {$filtro} ";

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

    while ($info = mysqli_fetch_array($result_user)){
        ?>


                <tr onclick="$(location).attr('href', '../../Group/forum?group=<?=$info['ID']?>');" >
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

function form($post)
{
    session_start();
    include('../../System/Checker/conection.php');

    if ($_SESSION['msg']['erro']){
        echo "<script>aletmsg();</script>";
        exit();
    }
    else{
        $query = "INSERT INTO GRUPO (NOME, DESCRICAO, AREAS_CONHECIMENTO, TIPO, USUARIOCRIOU) VALUES ('{$post['NOME']}', '{$post['DESCRICAO']}', '{$post['AREACONHECIMENTO']}', '{$post['TIPO']}', '{$_SESSION['login']['ID']}');";

        $result_user = mysqli_query($con, $query);
        $idInserido=mysqli_insert_id($con);

        echo "<script> $(location).attr('href', '../../Group/forum?group={$idInserido}'); </script>";
        exit();
    }

}

?>
