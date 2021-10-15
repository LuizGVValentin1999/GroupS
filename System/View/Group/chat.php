<?php
unset($_SESSION['CHAT']['OFFSET']);
?>
<section class="body-mobile">


    <h2>Chat Messages</h2>

    <div id="chat" style="height: 70vh; overflow-x: auto;
">

    </div>


<div class="col-6 col-12-xsmall" style="margin: 1%; top: 80%;">
    <ul class="actions fit">
        <input type="hidden" id="GRUPO" name="GRUPO" value="<?=$_GET['group']?>">
        <li>  <textarea style="width: 100%" onkeyup="buscarlista()" type="text" name="MENSAGEM" id="MENSAGEM" value="" placeholder="Texto"  rows="1"></textarea></li>
        <span style="margin: 1%;" onclick="enviar()"  class="icon solid alt fa-paper-plane"></span>
    </ul>
</div>


</section>

321
<script>


    function loop(){
        chat();
    }
    setInterval(loop, 800);

    function chat(inicial){
        $.ajax({
            url : "<?=$checklink?>System/App/Group/chat.php",
            type : 'post',
            datatype: "html",
            data : {
                BUSCA : $("#BUSCA").val(),
                GRUPO : $("#GRUPO").val(),
                funcao : 'busca'
            }
        })
            .done(function(msg){
                if (msg!='1'){
                    $("#chat").html($('#chat').html()+msg);
                    $('#chat').animate({scrollTop: 9999999}, 300);
                }
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    document.addEventListener('keypress', function(e){
        if(e.which == 13 && !e.shiftKey){
            enviar()
        }
    }, false);

    function enviar(){
        $.ajax({
            url : "<?=$checklink?>System/App/Group/chat.php",
            type : 'post',
            datatype: "html",
            data : {
                MENSAGEM : $("#MENSAGEM").val(),
                GRUPO : $("#GRUPO").val(),
                funcao : 'form'
            },
            beforeSend : function(){
                    $("#cardsdeconhecimento").html("enviando...");
            }

        })
            .done(function(msg){
                chat(1);
                $("#MENSAGEM").val('');
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    setTimeout(function  run() {
        chat(1);
    }, 500)
</script>
