<!-- Banner -->
	<section id="banner" class="major">
		<div class="inner">
			<header class="major">
				<h1>Olá, Bem vindo a Group S</h1>
			</header>
			<div class="content">
				<p>Um local para aprender e ajudar outros a aprenderem.<br />
                    Espero que goste do tempo que passará aqui. <a style="color: #00ff72;" data-modal="modal-register" class=" modal-trigger">Registrar.</a></p>
				<ul class="actions">
					<li><a data-modal="modal-login" class="button modal-trigger">Login</a></li>
				</ul>
			</div>
		</div>

        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal" id="modal-login">
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
                        <form method="POST" action="#" onsubmit="executarlogin(); return false" >
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
                                <button class="button" onsubmit="executarlogin()" type="submit" value="1" name="Botao" style="float: right;margin-top: 20px; "> LOGAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modal-register">
            <div class="modal-sandbox"></div>
            <div class="modal-box"  style="width: 80%;">
                <div class="modal-header">
                    <div class="close-modal close">&#10006;</div>
                    <h1>Cadastrar</h1>
                </div>
                <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
                <div class="modal-body" >
                    <div>
                        <div id="resultado-cadastro"> </div>
                        <form method="POST" id="cadastro" action="../../System/App/login.php"  enctype="multipart/form-data" >
                            <div>
                                <input type="hidden" name="funcao" value="cadastrar">
                                <div class="row gtr-uniform">
                                    <div class="field half " style="width: 100%; text-align: center">
                                        <label for="FOTO">Foto de usuário</label>
                                        <br/>
                                        <label class="label-ignore" for="uploadArquivo" >
                                            <img id="Previewfotop" src="System/App/Files/Users/userD.png" />
                                        </label>
                                        <input style="display:none" id="uploadArquivo" type="file" name="FOTO"  accept="image/png,image/jpeg">
                                    </div>
                                    <div class="field half " style="width: 100%; text-align: center">
                                        <label for="USUARIO">Nome completo</label>
                                        <input type="text" required id="NOME-CADASTRO" name="NOME"/>
                                    </div>
                                    <div class="field half " style="width: 100%; text-align: center">
                                        <label for="USUARIO">Nome de usuario</label>
                                        <input type="text" required id="USUARIO-CADASTRO" name="USUARIO"/>
                                    </div>
                                    <div class="field half " style="width: 100%; text-align: center">
                                        <label for="EMAIL">Email</label>
                                        <input type="email" required id="EMAIL-CADASTRO" name="EMAIL"/>
                                    </div>
                                    <div class="field half" style="width: 100%; text-align: center">
                                        <label for="SENHA">Senha</label>
                                        <input type="password" required id="SENHA-CADASTRO" name="SENHA"/>
                                    </div>
                                    <div class="field half" style="width: 100%; text-align: center">
                                        <label for="SENHA">Confirme a senha </label>
                                        <input type="password" required id="SENHA-COMFIRM-CADASTROa" name="SENHA-COMFIRM"/>
                                    </div>

                                </div>
                                <a class="button" onclick="fazercadastro()" type="submit" value="1" style="float: right;margin-top: 20px;"> Cadastrar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

	</section>


<script>


    function executarlogin(){
        $.ajax({
            url : "../../System/App/login.php",
            type : 'post',
            datatype: "html",
            data : {
                USUARIO : $("#USUARIO").val(),
                SENHA : $("#SENHA").val(),
                funcao : 'login'
            },
            beforeSend : function(){
                $("#resultado").html("ENVIANDO...");
            }

        })
            .done(function(msg){
                if (msg==1)
                    $(location).attr('href', '../../../areasConhecimento');
                else if(msg==2)
                    $(location).attr('href', '../../../grupos');
                else
                    $("#resultado").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

    function fazercadastro(){
        $.ajax({
            url : "../../System/App/login.php",
            type : 'post',
            datatype: "html",
            data : {
                NOME : $("#NOME-CADASTRO").val(),
                USUARIO : $("#USUARIO-CADASTRO").val(),
                EMAIL : $("#EMAIL-CADASTRO").val(),
                SENHA : $("#SENHA-CADASTRO").val(),
                SENHACOMFIRM : $("#SENHA-COMFIRM-CADASTROa").val(),
                funcao : 'validacadastrar'
            },
            beforeSend : function(){
                $("#resultado").html("ENVIANDO...");
            }
        })
            .done(function(msg){
                if (msg==1){
                $('#cadastro').submit();
                }
                else
                    $("#resultado").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }


    uploadArquivo.onchange = evt => {
        const [file] = uploadArquivo.files
        if (file) {
            Previewfotop.src = URL.createObjectURL(file)
        }
    }

</script>


