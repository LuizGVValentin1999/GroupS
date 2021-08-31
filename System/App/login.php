<?php

switch ($_POST['funcao']) {
    case 'login':
        login($_POST);
        break;
    default:
        echo "i equals 2";
        break;
}

function login($post){
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
        header("Location: ../../../Sistema/home");
        exit();
    }
    else{
        echo'Usuario ou senha invalida';
        exit();
    }
    exit();
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
