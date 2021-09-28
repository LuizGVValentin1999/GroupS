
<section>
    <div class="col-6 col-12-xsmall" style="margin: 1%;">
        <input onkeyup="buscarlista()" type="text" name="BUSCA" id="BUSCA" value="" placeholder="BUSCA" />
    </div>
    <div>
        <p class="obs" style="margin-top: 30px; width: 70%;"> Selecione assuntos do seu interesse </p>
        <button data-modal="modal-criar-area" class="button modal-trigger" style="float: right; margin-top: -2em;">Criar </button>
    </div>

    <hr class="major">
</section>


<section>

    <form  method="POST" action="<?=$checklink?>System/App/areasConhecimento.php">
        <input type="hidden" value="form" name="funcao">
        <div class="dragscroll areasdeconhecimento" id="cardsdeconhecimento" >

        </div>
        <br/>
        <button type="submit" style="margin: 1em; float: right;" class="button small">Next</button>
    </form>

    <!-- Modal -->
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

                                    <label for="BG">Cor de seleção do card</label>
                                    <input type="color" name="BG" id="BG" />

                                    <label for="COR">Cor superior do card</label>
                                    <input type="color"  required name="COR" id="COR" />
                                </div>
                                <div class="field half " style="width: 100%; text-align: center">
                                    <label for="DESCRICAO">Descrição</label>
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
</section>

<script>


    function buscarlista(inicial){
        $.ajax({
            url : "<?=$checklink?>System/App/areasConhecimento.php",
            type : 'post',
            datatype: "html",
            data : {
                BUSCA : $("#BUSCA").val(),
                funcao : 'busca'
            },
            beforeSend : function(){
                if (!inicial)
                $("#cardsdeconhecimento").html("Buscando...");
            }

        })
            .done(function(msg){
               $("#cardsdeconhecimento").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    setTimeout(function  run() {
        buscarlista(1);
    }, 500)
</script>

<!-- Modal -->
<div class="modal" id="modal-medicao">
    <div class="modal-sandbox"></div>
    <div class="modal-box"  style="width: 80%;">
        <div class="modal-header">
            <div class="close-modal close">&#10006;</div>
            <h1>LOGIN</h1>
        </div>
        <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
        <div class="modal-body" >
            <div>
                <div id="resultado"> </div>
                <form method="POST" >
                    <div>
                        <input type="hidden" name="funcao" value="login">
                        <div class="row gtr-uniform">
                            <div class="field half " style="width: 100%; text-align: center">
                                <label for="USUARIO">Usuario</label>
                                <input type="text" required name="USUARIO" id="USUARIO" />
                            </div>
                            <div class="field half" style="width: 100%; text-align: center">
                                <label for="SENHA">Senha</label>
                                <input type="password" required name="SENHA" id="SENHA" />
                            </div>

                        </div>
                        <a class="button"  onclick="executarlogin()" value="1" name="Botao" style="float: right;margin-top: 20px; "> LOGAR</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>