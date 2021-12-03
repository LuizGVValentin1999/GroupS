
<section class="calendario" >
    <button data-modal="modal-criar-evento" class="button modal-trigger" style="float: right; ">Criar </button>
    <hr class="major" style="border: blue; margin: 1.5em 0;">
    <input type="hidden" id="GRUPO" name="GRUPO" value="<?=$_GET['group']?>">
    <div id="holder" ></div>
    <hr class="major" style="border: blue; margin: 1.5em 0;">
    <div id="result"></div>


<script type="text/tmpl" id="tmpl">
  {{
  var date = date || new Date(),
      month = date.getMonth(),
      year = date.getFullYear(),
      first = new Date(year, month, 1),
      last = new Date(year, month + 1, 0),
      startingDay = first.getDay(),
      thedate = new Date(year, month, 1 - startingDay),
      dayclass = lastmonthcss,
      today = new Date(),
      i, j;
  if (mode === 'week') {
    thedate = new Date(date);
    thedate.setDate(date.getDate() - date.getDay());
    first = new Date(thedate);
    last = new Date(thedate);
    last.setDate(last.getDate()+6);
  } else if (mode === 'day') {
    thedate = new Date(date);
    first = new Date(thedate);
    last = new Date(thedate);
    last.setDate(thedate.getDate() + 1);
  }

  }}
  <table class="calendar-table table table-condensed table-tight">
    <thead>
      <tr>
        <td colspan="7" style="text-align: center">
          <table style="white-space: nowrap; width: 100%">
            <tr>
              <td style="text-align: left;">
                <span class="btn-group">
                  <button class="js-cal-prev btn btn-default">&lt;</button>
                  <button class="js-cal-next btn btn-default">&gt;</button>
                </span>
                <button id="hoje" class="js-cal-option btn btn-default {{: first.toDateInt() <= today.toDateInt() && today.toDateInt() <= last.toDateInt() ? 'active':'' }}" data-date="{{: today.toISOString()}}" data-mode="month">{{: todayname }}</button>
              </td>
              <td>
                <span class="btn-group btn-group-lg">
                  {{ if (mode !== 'day') { }}
                    {{ if (mode === 'month') { }}<button class="js-cal-option btn btn-link" data-mode="year">{{: months[month] }}</button>{{ } }}
                    {{ if (mode ==='week') { }}
                      <button class="btn btn-link disabled">{{: shortMonths[first.getMonth()] }} {{: first.getDate() }} - {{: shortMonths[last.getMonth()] }} {{: last.getDate() }}</button>
                    {{ } }}
                    <button class="js-cal-years btn btn-link">{{: year}}</button>
                  {{ } else { }}
                    <button class="btn btn-link disabled">{{: date.toDateString() }}</button>
                  {{ } }}
                </span>
              </td>
              <td style="text-align: right">
                <span class="btn-group">
                  <button class="js-cal-option btn btn-default {{: mode==='year'? 'active':'' }}" data-mode="year">Ano</button>
                  <button class="js-cal-option btn btn-default {{: mode==='month'? 'active':'' }}" data-mode="month">Mes</button>
                  <button class="js-cal-option btn btn-default {{: mode==='week'? 'active':'' }}" data-mode="week">Semana</button>
                  <button class="js-cal-option btn btn-default {{: mode==='day'? 'active':'' }}" data-mode="day">Dia</button>
                </span>
              </td>
            </tr>
          </table>

        </td>
      </tr>
    </thead>
    {{ if (mode ==='year') {
      month = 0;
    }}
    <tbody>
      {{ for (j = 0; j < 3; j++) { }}
      <tr>
        {{ for (i = 0; i < 4; i++) { }}
        <td class="calendar-month month-{{:month}} js-cal-option" data-date="{{: new Date(year, month, 1).toISOString() }}" data-mode="month">
          {{: months[month] }}
          {{ month++;}}
        </td>
        {{ } }}
      </tr>
      {{ } }}
    </tbody>
    {{ } }}
    {{ if (mode ==='month' || mode ==='week') { }}
    <thead>
      <tr class="c-weeks">
        {{ for (i = 0; i < 7; i++) { }}
          <th class="c-name">
            {{: days[i] }}
          </th>
        {{ } }}
      </tr>
    </thead>
    <tbody>
      {{ for (j = 0; j < 6 && (j < 1 || mode === 'month'); j++) { }}
      <tr>
        {{ for (i = 0; i < 7; i++) { }}
        {{ if (thedate > last) { dayclass = nextmonthcss; } else if (thedate >= first) { dayclass = thismonthcss; } }}
        <td class="calendar-day {{: dayclass }} {{: thedate.toDateCssClass() }} {{: date.toDateCssClass() === thedate.toDateCssClass() ? 'selected':'' }} {{: daycss[i] }} js-cal-option" data-date="{{: thedate.toISOString() }}">
          <div class="date">{{: thedate.getDate() }}</div>
          {{ thedate.setDate(thedate.getDate() + 1);}}
        </td>
        {{ } }}
      </tr>
      {{ } }}
    </tbody>
    {{ } }}
    {{ if (mode ==='day') { }}
    <tbody>
      <tr>
        <td colspan="7">
          <table class="table table-striped table-condensed table-tight-vert" >
            <thead>
              <tr>
                <th>&nbsp;</th>
                <th style="text-align: center; width: 100%">{{: days[date.getDay()] }}</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th class="timetitle" >Dia Todo</th>
                <td class="{{: date.toDateCssClass() }}">  </td>
              </tr>
              <tr>
                <th class="timetitle" >Antes das 6 AM</th>
                <td class="time-0-0"> </td>
              </tr>
              {{for (i = 6; i < 22; i++) { }}
              <tr>
                <th class="timetitle" >{{: i <= 12 ? i : i - 12 }} {{: i < 12 ? "AM" : "PM"}}</th>
                <td class="time-{{: i}}-0"> </td>
              </tr>
              <tr>
                <th class="timetitle" >{{: i <= 12 ? i : i - 12 }}:30 {{: i < 12 ? "AM" : "PM"}}</th>
                <td class="time-{{: i}}-30"> </td>
              </tr>
              {{ } }}
              <tr>
                <th class="timetitle" >Depois das 10 PM</th>
                <td class="time-22-0"> </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
    {{ } }}
  </table>
</script>

    <!-- Modal -->
    <div class="modal" id="modal-criar-evento">
        <div class="modal-sandbox"></div>
        <div class="modal-box"  style="width: 80%;">
            <div class="modal-header">
                <div class="close-modal close">&#10006;</div>
                <h1>Criar evento no calendario </h1>
            </div>
            <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
            <div class="modal-body" >
                <p class="obs" style=" width: 100%; margin-top: -48px;margin-bottom: 25px;">  Crie um evento para lembrar os membros do grupo de reunião, palestra ou evento de interesse do grupo. </p>
                <div>
                    <div id="resultado"> </div>
                    <form id="formcalendario" method="POST" >
                        <div>
                            <input type="hidden" name="funcao" value="form">
                            <input type="hidden" name="GRUPO" value="<?=$_GET['group']?>">
                            <div class="row gtr-uniform">
                                <div class="field half " style="width: 100%; text-align: center">
                                    <label for="NOME">Nome</label>
                                    <input type="text" placeholder="Nome do evento" required name="NOME" id="NOME" />
                                </div>
                                <div class="field half " style="width: 100%; text-align: center">
                                    <label for="DATAINICIO">Data de inicio</label>
                                    <input type="datetime-local" placeholder="Data de inicio" required name="INICIO" id="INICIO" />
                                </div>
                                <div class="field half " style="width: 100%; text-align: center">
                                    <label for="DATAINICIO">Data de fim</label>
                                    <input type="datetime-local" placeholder="Data de fim" required name="FIM" id="FIM" />
                                </div>
                                <div class="field half " style="width: 100%; text-align: center">
                                    <label for="DESCRICAO">Descrição do evento / aonde ele ira ocorrer </label>
                                    <textarea id="DESCRICAO" name="DESCRICAO" rows="3"></textarea>
                                </div>
                            </div>
                            <a class="button" value="1" onclick="formCalendario()" name="Botao" style="float: right; margin-top: 20px; "> Salvar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-evento">
        <div class="modal-sandbox"></div>
        <div class="modal-box"  style="width: 80%; padding: 17px 8px;">
            <div class="modal-header">
                <div class="close-modal close">&#10006;</div>
                <h1 id="nomeEvento">Evento </h1>
            </div>
            <div style=" background-color: #ffffff;    display: block;    height: 2px;   width: 100%;"></div>
            <div class="modal-body" id="body-evento" >

            </div>
        </div>
    </div>

    <script>
        function formCalendario(){
            $.ajax({
                url : "<?=$checklink?>System/App/Group/calendario.php",
                type : 'post',
                datatype: "html",
                data : $('#formcalendario').serialize(),
                beforeSend : function(){
                }
            })
                .done(function(msg){
                    if (msg=='1'){
                        $(location).attr('href', '../../../Group/calendario?group='+$("#GRUPO").val());
                    }
                    $("#result").html(msg);
                })
                .fail(function(jqXHR, textStatus, msg){
                    alert(msg);
                });
        }

        function evento(id){
            $.ajax({
                url : "<?=$checklink?>System/App/Group/calendario.php",
                type : 'post',
                datatype: "html",
                data : {
                    GRUPO: $("#GRUPO").val(),
                    EVENTO: id,
                    funcao: 'evento'
                }
            })
                .done(function(msg){
                    $("#modal-evento").show();
                    $("#body-evento").html(msg);
                })
                .fail(function(jqXHR, textStatus, msg){
                    alert(msg);
                });
        }
    </script>
</section>
