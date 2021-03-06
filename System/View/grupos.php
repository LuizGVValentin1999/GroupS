<div class="topnav">
    <div class="center" style="cursor: pointer;">
        <a id="todosGrupos" onclick="filtro('todosGrupos');" class="active"  >Todos</a>
        <a id="publicosGrupos" onclick="filtro('publicosGrupos');">Publicos</a>
        <a id="privadosGrupos" onclick="filtro('privadosGrupos');">Privados</a>
        <a id="meusGrupos" onclick="filtro('meusGrupos');">Meus Grupos</a>
    </div>
</div>

<section>
    <div class="col-6 col-12-xsmall" style="margin: 1%;">
        <input onkeyup="buscarlista()" type="text" name="BUSCA" id="BUSCA" value="" placeholder="BUSCA" />
    </div>
    <div>
        <p class="obs" style="margin-top: 30px; width: 70%;"> Qual grupo de estudo gostaria de participar  </p>
        <button data-modal="modal-criar-grupo" class="button modal-trigger" style="float: right; margin-top: -2em;">Criar </button>
    </div>

    <hr class="major">
<h4>Grupos</h4>
<div id="listagemgrupo">


</div>


</section>



<div class="modal" id="modal-criar-grupo">
    <div class="modal-sandbox"></div>
    <div class="modal-box"  style="width: 80%;">
        <div class="modal-header">
            <div class="close-modal close">&#10006;</div>
            <h1>Criar grupo</h1>
        </div>
        <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
        <div class="modal-body" >
            <div>
                <div id="resultado-cadastro"> </div>
                <form method="POST"  id="cadastro-grupo" onsubmit="formgrupo();  return false" >
                    <div>
                        <div id="resultado-grupo"></div>
                        <input type="hidden" name="funcao" value="form">
                        <div class="row gtr-uniform">
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="USUARIO">Nome </label>
                                <input type="text" required id="NOME-GRUPO" name="NOME"/>
                            </div>
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="DESCRICAO">descri????o do grupo</label>
                                <textarea id="DESCRICAO-GRUPO" rows="3" name="DESCRICAO"></textarea>
                            </div>
                            <div class="field half " style="width: 100%; text-align: center">
                                <div class="col-6 col-12-small" style="float: left; width: 78%; text-align: center">
                                    <label for="AREACONHECIMENTO">Area de conhecimento do grupo </label>
                                    <select name="AREACONHECIMENTO" id="AREACONHECIMENTO-GRUPO" >
                                    <?php
                                    include('System/Checker/conection.php');
                                    $query = " SELECT * FROM AREAS_CONHECIMENTO ";

                                    $result_user = mysqli_query($con, $query);
                                    var_dump($result_user);
                                    var_dump(mysqli_fetch_array($result_user));
                                    while ($info = mysqli_fetch_array($result_user)){
                                    ?>
                                        <option value="<?=$info['ID']?>"><?=$info['NOME']?></option>
                                        <?php
                                    }?>
                                    </select>

                                </div>
                                <div class="col-6 col-12-small" style="margin-top: 3%;">
                                    <button data-modal="modal-criar-area" class="button modal-trigger" >Criar </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 col-12-small">
                                    <input type="radio" value="L" id="TIPO-GRUPO-PUBLICO" name="TIPO" checked>
                                    <label for="TIPO-GRUPO-PUBLICO">Publico</label>
                                </div>
                                <div class="col-6 col-12-small">
                                    <input type="radio" value="P" id="TIPO-GRUPO-PRIVADO" name="TIPO">
                                    <label for="TIPO-GRUPO-PRIVADO">Privado</label>
                                </div>
                            </div>
                        </div>
                        <button class="button" type="submit" value="1" style="float: right;margin-top: 20px; "> Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-criar-area">
    <div class="modal-sandbox"></div>
    <div class="modal-box"  style="width: 80%;">
        <div class="modal-header">
            <div class="close-modal close">&#10006;</div>
            <h1>Criar Area de conhecimento </h1>
        </div>
        <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
        <div class="modal-body" >
            <div>
                <div id="resultado"> </div>
                <form method="POST" action="System/App/areasConhecimento.php" enctype="multipart/form-data"  >
                    <div>
                        <input type="hidden" name="funcao" value="formAreas">
                        <div class="row gtr-uniform">
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="NOME">Nome</label>
                                <input type="text" placeholder="Nome da Area" required name="NOME" id="NOME" />
                            </div>
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="IMG">imagem do card</label>
                                <input type="file" name="IMG" id="IMG" />

                            </div>
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="BG">Cor de sele????o do card</label>
                                <input type="color" name="BG" id="BG" />

                                <label for="COR">Cor superior do card</label>
                                <input type="color"  required name="COR" id="COR" />
                            </div>
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="DESCRICAO">Descri????o</label>
                                <textarea id="DESCRICAO" name="DESCRICAO" rows="3"></textarea>
                            </div>


                        </div>
                        <button class="button" type="submit" value="1" name="Botao" style="float: right;margin-top: 20px; "> Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modal-codigo-acesso">
    <div class="modal-sandbox"></div>
    <div class="modal-box"  style="width: 80%;">
        <div class="modal-header">
            <div class="close-modal close">&#10006;</div>
            <h1>C??digo de acesso para o grupo: </h1>
            <h1 id="nomeGrupoPrivado"></h1>
        </div>
        <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
        <div class="modal-body" >
            <div>
                <div id="acesso_grupo"> </div>
                <form method="POST" id="codigogrupo" onsubmit="entrarnogrupo();  return false"  >
                    <div>
                        <input type="hidden" name="funcao" value="entrarnogrupo">
                        <input type="hidden" id="idgrupo" name="group" value="0">
                        <div class="row gtr-uniform">
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="CODIGO_ACESSO">CODIGO DE ACESSO</label>
                                <input type="text" placeholder="XXXXX" required name="CODIGO_ACESSO" id="CODIGO_ACESSO" />
                            </div>
                        </div>
                        <button class="button" type="submit" value="1" name="Botao" style="float: right;margin-top: 20px; "> Validar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>




    function buscarlista(inicial,filtro){
        $.ajax({
            url : "<?=$checklink?>System/App/grupos.php",
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

    function formgrupo(){
        $.ajax({
            url : "<?=$checklink?>System/App/grupos.php",
            type : 'post',
            datatype: "html",
            data : $('#cadastro-grupo').serialize(),
            beforeSend : function(){
                $("#resultado-grupo").html("ENVIANDO...");
            }

        })
            .done(function(msg){
                    $("#resultado-grupo").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    function entrarnogrupo(idGrupo=0,tipoGrupo='',nomeGrupo=''){
        if (tipoGrupo == 'L'){
            $(location).attr('href', '../../System/App/grupos.php?group='+idGrupo+'&funcao=entrarnogrupo');
        }
        else if(tipoGrupo == 'P') {
            $.ajax({
                url : "<?=$checklink?>System/App/grupos.php",
                type : 'post',
                datatype: "html",
                data : {
                    group : idGrupo,
                    validar : 1,
                    funcao : 'entrarnogrupo'
                },
                beforeSend : function(){
                    $("#resultado-grupo").html("ENVIANDO...");
                }

            })
                .done(function(msg){
                    if (msg=='1'){
                        $(location).attr('href', '../../System/App/grupos.php?group='+idGrupo+'&funcao=entrarnogrupo');
                    }
                    else {
                        $('#modal-codigo-acesso').show();
                        $('#idgrupo').val(idGrupo);
                        $('#nomeGrupoPrivado').html(nomeGrupo);
                    }
                })
                .fail(function(jqXHR, textStatus, msg){
                    alert(msg);
                });
        }
        else {
            $.ajax({
                url : "<?=$checklink?>System/App/grupos.php",
                type : 'post',
                datatype: "html",
                data : $('#codigogrupo').serialize(),
                beforeSend : function(){
                    $("#resultado-grupo").html("ENVIANDO...");
                }

            })
            .done(function(msg){
                if (msg=='1'){
                    $(location).attr('href', '../../System/App/grupos.php?group='+$('#idgrupo').val()+'&funcao=entrarnogrupo');
                }
                $("#resultado-grupo").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
        }

    }


    function filtro(filtro){
        $('#todosGrupos').removeClass('active');
        $('#publicosGrupos').removeClass('active');
        $('#privadosGrupos').removeClass('active');
        $('#meusGrupos').removeClass('active');
        $('#'+filtro).addClass('active');
        buscarlista(null,filtro);
    }

    setTimeout(function  run() {
        buscarlista(1);
    }, 500)
</script>