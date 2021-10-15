<?php
switch ($_POST['funcao']) {
    case 'login':
        login($_POST);
        break;
    case 'cadastrar':
        cadastrar($_POST);
        break;
    default:
        echo "i equals 2";
        break;
}

function login($post){
    session_start();
    include('../../System/Checker/conection.php');

    if(empty($_POST['USUARIO']) || empty($_POST['SENHA'])) {
        echo'login invalido';
        exit();
    }

    $user = mysqli_real_escape_string($con, $_POST['USUARIO']);
    $password = mysqli_real_escape_string($con, $_POST['SENHA']);

    $query = "SELECT * FROM USUARIO where USUARIO = '{$user}' AND SENHA = md5('{$password}')";
    $result_user = mysqli_query($con, $query);
    $result = mysqli_fetch_assoc($result_user);

    $result_row = mysqli_query($con, $query);
    $row = mysqli_num_rows($result_row);

    if($row == 1 ) {
        $_SESSION['login'] = $result;
        $_SESSION['adm'] = 1;
        echo '1';
//        header("Location: ../../../Sistema/home");
        exit();
    }
    else{
        echo'Usuario ou senha invalida';
        exit();
    }
    exit();
}

function cadastrar($post){
    session_start();
    $validador = '';
    include('../../System/Checker/conection.php');

    if(strlen($_POST['SENHA']) < 8 ) {
        $_SESSION['msg']['erro'][] = "Senha deve ser maior que 8 digitos";
    }
    else if ($_POST['SENHA'] != $_POST['SENHACOMFIRM']){
        $_SESSION['msg']['erro'][] = "Senha está diferente da confirmação";
    }

    $query = "SELECT ID FROM USUARIO where EMAIL = '{$_POST['EMAIL']}' ";

    $result_row = mysqli_query($con, $query);
    $email_existente = mysqli_num_rows($result_row);

    if ($email_existente){
        $_SESSION['msg']['erro'][] = "Email já cadastrado";
    }

    $query = "SELECT ID FROM USUARIO where USUARIO = '{$_POST['USUARIO']}' ";

    $result_row = mysqli_query($con, $query);
    $usuario_existente = mysqli_num_rows($result_row);

    if ($usuario_existente){
        $_SESSION['msg']['erro'][] = "Usuario já está sendo utilizado";
    }


    if ($_SESSION['msg']['erro']){
        echo "<script>aletmsg();</script>";
        exit();
    }
    else{
        $query = "INSERT INTO USUARIO (NOME,EMAIL,USUARIO,SENHA)	VALUES ('{$_POST['NOME']}','{$_POST['EMAIL']}','{$_POST['USUARIO']}',md5('{$_POST['SENHA']}'));";
        $result_user = mysqli_query($con, $query);
        mysqli_fetch_assoc($result_user);


        echo '1';
        exit();
    }


}


function cadastrar_medicao($post){
    include('../../System/Checker/conection.php');

    $query = "INSERT INTO tipo_de_medicao (ABREVIACAO, NOME, TIPO_DE_MEDICAO, DESCRICAO, CODIGO) VALUES ('{$post['ABREVIACAO']}', '{$post['NOME']}', {$post['TIPO_DE_MEDICAO']}, '{$post['DESCRICAO']}', '{$post['CODIGO']}');";
    $result_user = mysqli_query($con, $query);
    mysqli_fetch_assoc($result_user);
    header("Location: ../../Sistema/produto/cadastrarProduto");
    exit();
}


function cadastrar_grupo($post){
    include('../../System/Checker/conection.php');

    $query = "INSERT INTO produto_grupo (CODIGO, NOME, DESCRICAO) VALUES ('{$post['CODIGO']}', '{$post['NOME']}', '{$post['DESCRICAO']}');";
    $result_user = mysqli_query($con, $query);
    mysqli_fetch_assoc($result_user);
    header("Location: ../../Sistema/produto/cadastrarProduto");

    exit();
}
