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
    <div>
        <p class="obs" style="margin-top: 30px; width: 70%;"> Qual grupo de estudo gostaria de acessar  </p>
    </div>

    <hr class="major">
<h4>Grupos</h4>
<div id="listagemgrupo">


</div>


</section>

<style>
    .menu {
        list-style-type: none;
        margin: 0;
        padding: 0;
        width: 200px;
        background-color: #f1f1f1;
        display: none;
        float: left;
    }

    .menu li a {
        display: block;
        color: #000;
        padding: 8px 0 8px 16px;
        text-decoration: none;
    }


    /* Change the link color on hover */

    .menu li a:hover {
        background-color: #555;
        color: white;
    }
</style>

<script>

    function buscarlista(inicial,filtro){
        $.ajax({
            url : "<?=$checklink?>System/App/grupos.php",
            type : 'post',
            datatype: "html",
            data : {
                BUSCA : $("#BUSCA").val(),
                TIPO : filtro,
                funcao : 'buscaNosMeus'
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
</script>