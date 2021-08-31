<!-- Banner -->
	<section id="banner" class="major">
		<div class="inner">
			<header class="major">
				<h1>Ola, Bem vindo a Group S</h1>
			</header>
			<div class="content">
				<p>Um local para Aprender e ajudar a outros a aprender<br />
				espero que goste do tempo que passara aqui.</p>
				<ul class="actions">
					<li><a data-modal="modal-medicao" class="button modal-trigger">Login</a></li>
				</ul>
			</div>
		</div>

        <!-- Button trigger modal -->

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

	</section>


<script>

    document.addEventListener('keypress', function(e){
        if(e.which == 13){
            executarlogin()
        }
    }, false);

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
                    $(location).attr('href', '../../../GroupS/areasConhecimento');
                else
                    $("#resultado").html(msg);
            })
            .fail(function(jqXHR, textStatus, msg){
                alert(msg);
            });
    }

</script>


