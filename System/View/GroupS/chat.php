<div class="topnav">
    <div class="center" style="cursor: pointer;">
        <a id="todosGrupos" onclick="filtro('todosGrupos');" class="active"  >Chat</a>
        <a id="publicosGrupos" onclick="filtro('publicosGrupos');">Forum</a>
        <a id="privadosGrupos" onclick="filtro('privadosGrupos');">Calendario</a>
    </div>
</div>
<section class="body-mobile">


    <h2>Chat Messages</h2>

    <div id="chat" style="height: 70vh; overflow-x: auto;
">

    </div>


<div class="col-6 col-12-xsmall" style="margin: 1%; top: 80%;">
    <ul class="actions fit">
        <li>  <textarea style="width: 100%" onkeyup="buscarlista()" type="text" name="MENSAGEM" id="MENSAGEM" value="" placeholder="Texto"  rows="1"></textarea></li>
        <span style="margin: 1%;" onclick="enviar()"  class="icon solid alt fa-paper-plane"></span>
    </ul>
</div>


</section>


<script>


    // function loop(){
    //     chat();
    // }
    // setInterval(loop, 500);

    function chat(inicial){
        $.ajax({
            url : "<?=$checklink?>System/App/GroupS/chat.php",
            type : 'post',
            datatype: "html",
            data : {
                BUSCA : $("#BUSCA").val(),
                funcao : 'busca'
            },
            beforeSend : function(){
                if (!inicial)
                    $("#chat").html("Buscando...");
            }

        })
            .done(function(msg){
                $("#chat").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    document.addEventListener('keypress', function(e){
        if(e.which == 13){
            enviar()
        }
    }, false);

    function enviar(){
        $.ajax({
            url : "<?=$checklink?>System/App/GroupS/chat.php",
            type : 'post',
            datatype: "html",
            data : {
                MENSAGEM : $("#MENSAGEM").val(),
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
