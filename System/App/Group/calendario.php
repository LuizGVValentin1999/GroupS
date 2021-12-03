<?php


switch ($_POST['funcao']) {
    case 'calendario':
        calendario($_POST);
        break;
    case 'form':
        form($_POST);
        break;
    case 'evento':
        evento($_POST);
        break;
    default:
        echo "i equals 2";
        break;
}

function calendario($post){
    session_start();
    include('../../../System/Checker/conection.php');
    $query = "SELECT * FROM CALENDARIO WHERE GRUPO = {$post['GRUPO']} ORDER BY ID DESC ";
    $result_user = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result_user)){
        $info['CONTEUDO'] = json_decode(preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']),true);
        $date_inicio = date_create($info['CONTEUDO']['INICIO']);
        $date_fim = date_create($info['CONTEUDO']['FIM']);
        echo "<script>data.push({ onclickk:'evento({$info['ID']});', class:'calendario_{$info['ID']}', title: '{$info['CONTEUDO']['NOME']}', start: new Date(".date_format($date_inicio,'Y' ).", ".date_format($date_inicio,'m-1' ).", ".date_format($date_inicio,'d' ).", ".date_format($date_inicio,'H' ).", ".date_format($date_inicio,'i' )."), end: new Date(".date_format($date_fim,'Y' ).", ".date_format($date_fim,'m-1' ).", ".date_format($date_fim,'d' ).", ".date_format($date_fim,'H' ).", ".date_format($date_fim,'i' )."), allDay: false  });</script>";
    }
}

function evento($post){
    session_start();
    include('../../../System/Checker/conection.php');
    $query = "SELECT * FROM CALENDARIO WHERE ID = {$post['EVENTO']} AND GRUPO = {$post['GRUPO']} ORDER BY INICIO DESC ";
    $result_user = mysqli_query($con, $query);
    while ($info = mysqli_fetch_array($result_user)){
        $info['CONTEUDO'] = json_decode(preg_replace( "/\r|\n/", '<br>', $info['CONTEUDO']),true);
        $date_inicio = date_create($info['CONTEUDO']['INICIO']);
        $date_fim = date_create($info['CONTEUDO']['FIM']);
        ?>
        <div style="text-align: center;" >
            <h4>Descrição</h4>
            <p> <?=$info['CONTEUDO']['DESCRICAO']?></p>
            <hr style="border: blue">
            <div class="row">
                <div class="col-6 col-12-small">
                    <h4>Inicio</h4>
                    <p> <?= date_format($date_inicio,'d-m-y : H:i ' ).'m'?></p>
                </div>
                <div class="col-6 col-12-small">
                    <h4>Fim</h4>
                    <p> <?= date_format($date_fim,'d-m-y : H:i ' ).'m'?></p>
                </div>
            </div>
        </div>
        <script>setTimeout($('#nomeEvento').html('Evento : <?=$info['CONTEUDO']['NOME']?>'))</script>
<?php
    }
}

function form($post){
    session_start();
    include('../../../System/Checker/conection.php');


    $date_inicio = date_create($post['INICIO']);
    $date_fim = date_create($post['FIM']);
    if (!$post['NOME']){
        $_SESSION['msg']['erro'][] =  "informe o nome do evento";
    }
    if (!$post['DESCRICAO']){
        $_SESSION['msg']['erro'][] =  "informe a descrição do evento";
    }
    if (!$post['INICIO']){
        $_SESSION['msg']['erro'][] =  "informe data de inicio";
    }
    if (!$post['FIM']){
        $_SESSION['msg']['erro'][] =  "informe data de fim";
    }
    elseif ($date_inicio>$date_fim){
        $_SESSION['msg']['erro'][] =  "Data de inicio não pode der maior que a de fim ";
    }


    if ($_SESSION['msg']['erro']){
        echo "<script>aletmsg();</script>";
        exit();
    }
    else{
        $i_inset['NOME'] = $post['NOME'];
        $i_inset['DESCRICAO'] = $post['DESCRICAO'];
        $i_inset['INICIO'] = $post['INICIO'];
        $i_inset['FIM'] = $post['FIM'];
        $query = "INSERT INTO CALENDARIO (CONTEUDO,GRUPO,USUARIO, INICIO, FIM ) VALUES ('".json_encode($i_inset,JSON_UNESCAPED_UNICODE)."', '{$post['GRUPO']}', '". $_SESSION['login']['ID']."', '".date_format($date_inicio,'Y-m-d H:i:s')."', '".date_format($date_fim,'Y-m-d H:i:s')."');";

        mysqli_query($con, $query);
        echo "1";
        exit();
    }
}
