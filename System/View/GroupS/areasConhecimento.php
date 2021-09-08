<?php

?>
<section>
        <div class="col-6 col-12-xsmall" style="margin: 1%;">
            <input onkeyup="buscarlista()" type="text" name="BUSCA" id="BUSCA" value="" placeholder="BUSCA" />
        </div>
    <form  method="POST" action="<?=$checklink?>System/App/GroupS/areasConhecimento.php">
        <input type="hidden" value="form" name="funcao">
        <div style="height: 21em" id="cardsdeconhecimento">

        </div>
        <br/>
        <button type="submit" style="margin: 1em; float: right;" class="button small">Next</button>
    </form>

</section>

<script>


    function buscarlista(inicial){
        $.ajax({
            url : "<?=$checklink?>System/App/GroupS/areasConhecimento.php",
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
<style>
    body {
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        height: 100vh;
        font-family: "Open Sans";
    }


    .card {
        float: left;
        margin: 0.5%;
        width: calc(8% + 10em);
        max-width: 220px;
        height: 321px;
        background: #fff;
        border-top-right-radius: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        box-shadow: 0 14px 26px rgba(0,0,0,0.04);
        transition: all 0.3s ease-out;
        text-decoration: none;
    }

    .card:hover {
        transform:  scale(1.005);
        box-shadow: 0 24px 36px rgba(0,0,0,0.11),
        0 24px 46px var(--box-shadow-color);
    }

    .area_check {
         transform: scale(4) translateZ(0);
     }

    .card:hover .circle {
        border-color: var(--bg-color-light);
        background: var(--bg-color);
    }

    .card:hover .circle:after {
        background: var(--bg-color-light);
    }

    .card:hover p {
        color: var(--text-color-hover);
    }

    .card:active {
        transform: scale(1) translateZ(0);
        box-shadow: 0 15px 24px rgba(0,0,0,0.11),
        0 15px 24px var(--box-shadow-color);
    }

    .card p {
        font-size: 17px;
        color: #4C5656;
        margin-top: 30px;
        z-index: 1000;
        transition: color 0.3s ease-out;
    }

    .circle {
        width: 131px;
        height: 131px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid var(--bg-color);
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease-out;
    }

    .circle:after {
        content: "";
        width: 118px;
        height: 118px;
        display: block;
        position: absolute;
        background: var(--bg-color);
        border-radius: 50%;
        top: 7px;
        left: 7px;
        transition: opacity 0.3s ease-out;
    }

    .circle svg {
        z-index: 10000;
        transform: translateZ(0);
    }

    .overlay {
        width: 118px;
        position: absolute;
        height: 118px;
        border-radius: 50%;
        background: var(--bg-color);
        top: 55px;
        left: 50px;
        z-index: 0;
        transition: transform 0.3s ease-out;
    }
</style>