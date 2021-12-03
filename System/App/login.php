<?php
switch ($_POST['funcao']) {
    case 'login':
        login($_POST);
        break;
    case 'validacadastrar':
        validacadastrar($_POST);
        break;
    case 'cadastrar':
        cadastrar($_POST,$_FILES);
        break;
    default:
        echo "i equals 2";
        break;
}

function login($post,$cadastro = 0){
    session_start();
    include('../../System/Checker/conection.php');

    if(empty($post['USUARIO']) || empty($post['SENHA'])) {
        echo'login invalido';
        exit();
    }

    $user = mysqli_real_escape_string($con, $post['USUARIO']);
    $password = mysqli_real_escape_string($con, $post['SENHA']);

    $query = "SELECT * FROM USUARIO where USUARIO = '{$user}' AND SENHA = md5('{$password}')";
    $result_user = mysqli_query($con, $query);
    $result = mysqli_fetch_assoc($result_user);

    $result_row = mysqli_query($con, $query);
    $row = mysqli_num_rows($result_row);

    if($row == 1 ) {
        $_SESSION['login'] = $result;

        if($cadastro){
            header("Location: ../../areasConhecimento");
        }else{
            if ($_SESSION['login']['AREAS_CONHECIMENTO'])
                echo '2';
            else
                echo '1';
        }
        exit();
    }
    else{
        echo'Usuario ou senha invalida';
        exit();
    }
    exit();
}

function cadastrar($post,$files){
    session_start();
    $validador = '';
    include('../../System/Checker/conection.php');

    $novo_nome = "0";
    if($files['FOTO']['name']){

        $extensao = explode('.',$files['FOTO']['name'])[1];

        $novo_nome = $_SESSION['login']['ID'].md5(time()). ".".$extensao;

        $diretorio = "../../System/App/Files/Users/";

        move_uploaded_file($files['FOTO']['tmp_name'], $diretorio.$novo_nome);
    }

    $query = "INSERT INTO USUARIO (NOME,EMAIL,USUARIO,SENHA,FOTO)	VALUES ('{$_POST['NOME']}','{$_POST['EMAIL']}','{$_POST['USUARIO']}',md5('{$_POST['SENHA']}'),'{$novo_nome}');";
    $result_user = mysqli_query($con, $query);
    mysqli_fetch_assoc($result_user);

    login($post,1);
    exit();
}

function validacadastrar($post){
    session_start();
    $validador = '';
    include('../../System/Checker/conection.php');

    if(strlen($_POST['SENHA']) < 8 ) {
        $_SESSION['msg']['erro'][] = "Senha deve ser maior que 8 digitos";
    }
    else if ($_POST['SENHA'] != $_POST['SENHACOMFIRM']){
        $_SESSION['msg']['erro'][] = "Senha está diferente da confirmação";
    }

    if(!$_POST['USUARIO'] ) {
        $_SESSION['msg']['erro'][] = "Informe o Nome de usuario";
    }

    if(!$_POST['NOME'] ) {
        $_SESSION['msg']['erro'][] = "Informe seu Nome completo";
    }

    if(!$_POST['EMAIL'] ) {
        $_SESSION['msg']['erro'][] = "Informe o email";
    }
    else{
        $query = "SELECT ID FROM USUARIO where EMAIL = '{$_POST['EMAIL']}' ";

        $result_row = mysqli_query($con, $query);
        $email_existente = mysqli_num_rows($result_row);

        if ($email_existente){
            $_SESSION['msg']['erro'][] = "Email já cadastrado";
        }
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
        echo '1';
        exit();
    }
}

