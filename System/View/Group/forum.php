
<?php
include('System/Checker/conection.php');
$query = "SELECT * FROM GRUPO WHERE ID = {$_GET['group']}; ";
$result = mysqli_query($con, $query);
$info = mysqli_fetch_array($result);
?>
<section class="body-mobile";
">
    <h2>Forum do grupo : <?=$info['NOME']?></h2>
    <?=$info['TIPO']=='P'?"<h4>Código de acesso do grupo : ".$info['CODIGO_ACESSO']."</h4>":"" ?>

    <div class="col-6 col-12-xsmall" style="margin: 1%;">

        <form action="../../System/App/Group/forum.php" method="post" id="forum-enviar" enctype="multipart/form-data">
            <input type="hidden" name="funcao" value="form">
            <input type="hidden" id="GRUPO" name="GRUPO" value="<?=$_GET['group']?>">
            <div class="boxx">
                <textarea style="width: 100%" type="text" name="TEXTO" id="TEXTO" value="" placeholder="Insira aqui duvida, considerações ou comentarios..."  rows="2"></textarea>

                <label class="label-ignore" for="uploadArquivo" >
                    <span style="margin: 1%;float: left" id="Previewarquivo" class="label-ignore icon alt fa-file"></span>
                </label>
                <input style="display: none" id="uploadArquivo" type="file" name="ARQUIVO" onchange="Previewarquivo();">
                <button type="submit" onclick="setTimeout(function  run() {lista();}, 1000)" style="margin: 1%; float: right; background-color: white; height: 3em;" ><span style="top: -3px; margin: 1%;float: left"  class="label-ignore solid icon alt fa-paper-plane"></span></button>
            </div>
        </form>

    </div>

    <hr class="major">
</section>

<section class="body-mobile" style="margin-bottom: 8%">
    <div id="forum-posts">
        <div class="end-forum">Forum sem publicações. Poste algo interessante ao grupo acima.</div>
    </div>


</section>



<script>

    function lista(){
        $('#TEXTO').val('');
        $('#ARQUIVO').val('');
        $.ajax({
            url : "<?=$checklink?>System/App/Group/forum.php",
            type : 'post',
            datatype: "html",
            data : {
                GRUPO : $("#GRUPO").val(),
                funcao : 'forum'
            },
            beforeSend : function(){

            }

        })
            .done(function(msg){
                if (msg)
                    $("#forum-posts").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert('erro de conexão');
            });
    }

    function remover(id){
        $.ajax({
            url : "<?=$checklink?>System/App/Group/forum.php",
            type : 'post',
            datatype: "html",
            data : {
                POSTF : id,
                funcao : 'remover'
            },
            beforeSend : function(){

            }

        })
            .done(function(msg){
                $(".post_"+id).remove();
            })
            .fail(function(jqXHR, textStatus, msg){
                alert('erro de conexão');
            });
    }

    function comentarios(id){
        $('.comentarios_'+id).toggle();
        $.ajax({
            url : "<?=$checklink?>System/App/Group/forum.php",
            type : 'post',
            datatype: "html",
            data : {
                POSTF : id,
                funcao : 'comentarios'
            },
            beforeSend : function(){

            }

        })
            .done(function(msg){
                $(".comentario_"+id).html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert('erro de conexão');
            });
    }

    function formcomentario(id){
        $.ajax({
            url : "<?=$checklink?>System/App/Group/forum.php",
            type : 'post',
            datatype: "html",
            data : {
                POSTF : id,
                COMENTARIO : $('#COMENTARIO_'+id).val(),
                funcao : 'formcomentario'
            },
            beforeSend : function(){

            }
        })
            .done(function(msg){
                comentarios(id);
                $('#qtde_comentario_'+id).html(parseInt($('#qtde_comentario_'+id).html())+1);
                $('#COMENTARIO_'+id).val('');
            })
            .fail(function(jqXHR, textStatus, msg){
                alert('erro de conexão');
            });
    }

    function like(id){
        $.ajax({
            url : "<?=$checklink?>System/App/Group/forum.php",
            type : 'post',
            datatype: "html",
            data : {
                POSTF : id,
                funcao : 'like'
            },
            beforeSend : function(){

            }
        })
            .done(function(msg){
                if (msg == 1){
                    $('#like_'+id).addClass('solid');
                    $('#qtde_like_'+id).html( parseInt($('#qtde_like_'+id).html())+1);

                }
                else{
                    $('#like_'+id).removeClass('solid');
                    $('#qtde_like_'+id).html(parseInt($('#qtde_like_'+id).html())-1);
                }
            })
            .fail(function(jqXHR, textStatus, msg){
                alert('erro de conexão');
            });
    }

    function Previewarquivo(){
        var input = document.getElementById("uploadArquivo");

       $('#Previewarquivo').html(input.files[0].name);
    }
    setTimeout(function  run() {
        lista();
    }, 500)


</script>
