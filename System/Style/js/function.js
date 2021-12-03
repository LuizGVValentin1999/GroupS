

$(".modal-trigger").click(function(e){
    e.preventDefault();
    dataModal = $(this).attr("data-modal");
    $("#" + dataModal).css({"display":"block"});
    // $("body").css({"overflow-y": "hidden"}); //Prevent double scrollbar.
});

$(".close-modal, .modal-sandbox").click(function(){
    $(".modal").css({"display":"none"});
    // $("body").css({"overflow-y": "auto"}); //Prevent double scrollbar.
});


function aletmsg(){
    $.ajax({
        url : "../System/View/alert.php",
        type : 'post',
        datatype: "html",
        data : {
            funcao : 'msg'
        },

    })
        .done(function(msg){
            $("#alert").html(msg);
        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
}


/*
* FlowType.JS v1.1
* Copyright 2013-2014, Simple Focus http://simplefocus.com/
*
* FlowType.JS by Simple Focus (http://simplefocus.com/)
* is licensed under the MIT License. Read a copy of the
* license in the LICENSE.txt file or at
* http://choosealicense.com/licenses/mit
*
* Thanks to Giovanni Difeterici (http://www.gdifeterici.com/)
*/

(function($) {
    $.fn.flowtype = function(options) {

// Establish default settings/variables
// ====================================
        var settings = $.extend({
                maximum   : 9999,
                minimum   : 1,
                maxFont   : 9999,
                minFont   : 1,
                fontRatio : 35
            }, options),

// Do the magic math
// =================
            changes = function(el) {
                var $el = $(el),
                    elw = $el.width(),
                    width = elw > settings.maximum ? settings.maximum : elw < settings.minimum ? settings.minimum : elw,
                    fontBase = width / settings.fontRatio,
                    fontSize = fontBase > settings.maxFont ? settings.maxFont : fontBase < settings.minFont ? settings.minFont : fontBase;
                $el.css('font-size', fontSize + 'px');
            };

// Make the magic visible
// ======================
        return this.each(function() {
            // Context for resize callback
            var that = this;
            // Make changes upon resize
            $(window).resize(function(){changes(that);});
            // Set changes on load
            changes(this);
        });
    };
}(jQuery));


$('textarea').on('keyup onpaste', function () {
    var alturaScroll = this.scrollHeight;
    var alturaCaixa = $(this).height();



    if (alturaScroll > (alturaCaixa + 10)) {
        if (alturaScroll > 300) return;
        $(this).css('height', alturaScroll);
    }

    if( $(this).val() == '' ){
        $(this).css('height', "");
    }


});


// function addEvent(obj, evt, fn) {
//     if (obj.addEventListener) {
//         obj.addEventListener(evt, fn, false);
//     }
//     else if (obj.attachEvent) {
//         obj.attachEvent("on" + evt, fn);
//     }
// }
//
// addEvent(document, "mouseout", function(e) {
//     e = e ? e : window.event;
//     var from = e.relatedTarget || e.toElement;
//     if (!from || from.nodeName == "HTML") {
//         $('#modal-Atualizacao').show();
//     }
// });