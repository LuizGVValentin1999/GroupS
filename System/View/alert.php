<?php
session_start();
if(@$_SESSION['msg']['erro']){
    foreach($_SESSION['msg']['erro'] as $erro){
        ?>
        <div>
            <div class="alert-close" onclick="$(this).parent().remove();" aria-hidden="true">X</div>
            <div class="alert-text"><strong class="alert-erro">Erro!!</strong> <?= $erro?></div>
        </div>
        <?php
    }
}
if(@$_SESSION['msg']['success']){
    foreach($_SESSION['msg']['success'] as $success){
        ?>

        <div>
            <div class="alert-close" onclick="$(this).parent().remove();" aria-hidden="true">X</div>
            <div class="alert-text"><strong class="alert-success">Sucesso!!</strong> <?= $success?> </div>
        </div>
        <?php
    }
}
unset($_SESSION['msg']);
?>
