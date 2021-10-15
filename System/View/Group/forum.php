
<section class="body-mobile">
    <div class="col-6 col-12-xsmall" style="margin: 1%;">

        <iframe name="content" style=" display: none">
        </iframe>
        <form action="../../System/App/Group/forum.php" method="post" target="content" enctype="multipart/form-data">
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

<section class="body-mobile">
<div id="forum-posts">

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
                $("#forum-posts").html(msg);
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
