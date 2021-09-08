<div class="topnav">
    <div class="center" style="cursor: pointer;">
        <a id="todosGrupos" onclick="filtro('todosGrupos');" class="active"  >Todos</a>
        <a id="publicosGrupos" onclick="filtro('publicosGrupos');">Publicos</a>
        <a id="privadosGrupos" onclick="filtro('privadosGrupos');">Privados</a>
    </div>
</div>

<section>
    <div class="col-6 col-12-xsmall" style="margin: 1%;">
        <input onkeyup="buscarlista()" type="text" name="BUSCA" id="BUSCA" value="" placeholder="BUSCA" />
    </div>
<h4>Grupos</h4>
<div id="listagemgrupo">


</div>


</section>






<script>


    function buscarlista(inicial,filtro){
        $.ajax({
            url : "<?=$checklink?>System/App/GroupS/grupos.php",
            type : 'post',
            datatype: "html",
            data : {
                BUSCA : $("#BUSCA").val(),
                TIPO : filtro,
                funcao : 'busca'
            },
            beforeSend : function(){
                if (!inicial)
                    $("#listagemgrupo").html("Buscando...");
            }

        })
            .done(function(msg){
                $("#listagemgrupo").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    function filtro(filtro){
        $('#todosGrupos').removeClass('active');
        $('#publicosGrupos').removeClass('active');
        $('#privadosGrupos').removeClass('active');
        $('#'+filtro).addClass('active');
        buscarlista(null,filtro);
    }

    setTimeout(function  run() {
        buscarlista(1);
    }, 500)

    $('#area_overlay_<?=$info["ID"]?>').toggleClass('area_check');
</script>