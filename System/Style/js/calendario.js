function calendario(){
    $.ajax({
        url : "../System/App/Group/calendario.php",
        type : 'post',
        datatype: "html",
        data : {
            GRUPO : $("#GRUPO").val(),
            funcao : 'calendario'
        }
    })
        .done(function(msg){
            $("#result").html(msg);
            $("#hoje").click();

        })
        .fail(function(jqXHR, textStatus, msg){
            alert(msg);
        });
}
calendario();

var $currentPopover = null;
$(document).on('shown.bs.popover', function (ev) {
    var $target = $(ev.target);
    if ($currentPopover && ($currentPopover.get(0) != $target.get(0))) {
        $currentPopover.popover('toggle');
    }
    $currentPopover = $target;
}).on('hidden.bs.popover', function (ev) {
    var $target = $(ev.target);
    if ($currentPopover && ($currentPopover.get(0) == $target.get(0))) {
        $currentPopover = null;
    }
});


//quicktmpl is a simple template language I threw together a while ago; it is not remotely secure to xss and probably has plenty of bugs that I haven't considered, but it basically works
//the design is a function I read in a blog post by John Resig (http://ejohn.org/blog/javascript-micro-templating/) and it is intended to be loosely translateable to a more comprehensive template language like mustache easily
$.extend({
    quicktmpl: function (template) {return new Function("obj","var p=[],print=function(){p.push.apply(p,arguments);};with(obj){p.push('"+template.replace(/[\r\t\n]/g," ").split("{{").join("\t").replace(/((^|\}\})[^\t]*)'/g,"$1\r").replace(/\t:(.*?)\}\}/g,"',$1,'").split("\t").join("');").split("}}").join("p.push('").split("\r").join("\\'")+"');}return p.join('');")}
});

$.extend(Date.prototype, {
    //provides a string that is _year_month_day, intended to be widely usable as a css class
    toDateCssClass:  function () {
        return '_' + this.getFullYear() + '_' + (this.getMonth() + 1) + '_' + this.getDate();
    },
    //this generates a number useful for comparing two dates;
    toDateInt: function () {
        return ((this.getFullYear()*12) + this.getMonth())*32 + this.getDate();
    },
    toTimeString: function() {
        var hours = this.getHours(),
            minutes = this.getMinutes(),
            hour = (hours > 12) ? (hours - 12) : hours,
            ampm = (hours >= 12) ? ' pm' : ' am';
        if (hours === 0 && minutes===0) { return ''; }
        if (minutes > 0) {
            return hour + ':' + minutes + ampm;
        }
        return hour + ampm;
    }
});


(function ($) {

    //t here is a function which gets passed an options object and returns a string of html. I am using quicktmpl to create it based on the template located over in the html block
    var t = $.quicktmpl($('#tmpl').get(0).innerHTML);

    function calendar($el, options) {
        //actions aren't currently in the template, but could be added easily...
        $el.on('click', '.js-cal-prev', function () {
            switch(options.mode) {
                case 'year': options.date.setFullYear(options.date.getFullYear() - 1); break;
                case 'month': options.date.setMonth(options.date.getMonth() - 1); break;
                case 'week': options.date.setDate(options.date.getDate() - 7); break;
                case 'day':  options.date.setDate(options.date.getDate() - 1); break;
            }
            draw();
        }).on('click', '.js-cal-next', function () {
            switch(options.mode) {
                case 'year': options.date.setFullYear(options.date.getFullYear() + 1); break;
                case 'month': options.date.setMonth(options.date.getMonth() + 1); break;
                case 'week': options.date.setDate(options.date.getDate() + 7); break;
                case 'day':  options.date.setDate(options.date.getDate() + 1); break;
            }
            draw();
        }).on('click', '.js-cal-option', function () {
            var $t = $(this), o = $t.data();
            if (o.date) { o.date = new Date(o.date); }
            $.extend(options, o);
            draw();
        }).on('click', '.js-cal-years', function () {
            var $t = $(this),
                haspop = $t.data('popover'),
                s = '',
                y = options.date.getFullYear() - 2,
                l = y + 5;
            if (haspop) { return true; }
            for (; y < l; y++) {
                s += '<button type="button" class="btn btn-default btn-lg btn-block js-cal-option" data-date="' + (new Date(y, 1, 1)).toISOString() + '" data-mode="year">'+y + '</button>';
            }
            $t.popover({content: s, html: true, placement: 'auto top'}).popover('toggle');
            return false;
        }).on('click', '.event', function () {
            var $t = $(this),
                index = +($t.attr('data-index')),
                haspop = $t.data('popover'),
                data, time;

            if (haspop || isNaN(index)) { return true; }
            data = options.data[index];
            time = data.start.toTimeString();
            if (time && data.end) { time = time + ' - ' + data.end.toTimeString(); }
            $t.data('popover',true);
            return false;
        });
        function dayAddEvent(index, event) {
            if (!!event.allDay) {
                monthAddEvent(index, event);
                return;
            }
            var $event = $('<div/>', {'class': 'event '+event.class,'onclick':event.onclickk, text: event.title, title: event.title, 'data-index': index}),
                start = event.start,
                end = event.end || start,
                time = event.start.toTimeString(),
                hour = start.getHours(),
                timeclass = '.time-22-0',
                startint = start.toDateInt(),
                dateint = options.date.toDateInt(),
                endint = end.toDateInt();
            if (startint > dateint || endint < dateint) { return; }

            if (!!time) {
                $event.html('<strong>' + time + '</strong> ' + $event.html());
            }
            $event.toggleClass('begin', startint === dateint);
            $event.toggleClass('end', endint === dateint);
            if (hour < 6) {
                timeclass = '.time-0-0';
            }
            else if (hour < 22) {
                timeclass = '.time-' + hour + '-' + (start.getMinutes() < 30 ? '0' : '30');
            }
            $(timeclass).append($event);
        }

        function monthAddEvent(index, event) {
            var $event = $('<div/>', {'class': 'event '+event.class,'onclick':event.onclickk, text: event.title, title: event.title, 'data-index': index}),
                e = new Date(event.start),
                dateclass = e.toDateCssClass(),
                day = $('.' + e.toDateCssClass()),
                empty = $('<div/>', {'class':'clear event', html:'&nbsp;'}),
                numbevents = 0,
                time = event.start.toTimeString(),
                endday = event.end && $('.' + event.end.toDateCssClass()).length > 0,
                checkanyway = new Date(e.getFullYear(), e.getMonth(), e.getDate()+40),
                existing,
                i;
            $event.toggleClass('all-day', !!event.allDay);
            if (!!time) {
                $event.html('<strong>' + time + '</strong> ' + $event.html());
            }
            if (!event.end) {
                $event.addClass('begin end');
                $('.' + event.start.toDateCssClass()).append($event);
                return;
            }

            while (e <= event.end && (day.length || endday || options.date < checkanyway)) {
                if(day.length) {
                    existing = day.find('.event').length;
                    numbevents = Math.max(numbevents, existing);
                    for(i = 0; i < numbevents - existing; i++) {
                        day.append(empty.clone());
                    }
                    day.append(
                        $event.
                        toggleClass('begin', dateclass === event.start.toDateCssClass()).
                        toggleClass('end', dateclass === event.end.toDateCssClass())
                    );
                    $event = $event.clone();
                    $event.html('&nbsp;');
                }
                e.setDate(e.getDate() + 1);
                dateclass = e.toDateCssClass();
                day = $('.' + dateclass);
            }
        }
        function yearAddEvents(events, year) {
            var counts = [0,0,0,0,0,0,0,0,0,0,0,0];
            $.each(events, function (i, v) {
                if (v.start.getFullYear() === year) {
                    counts[v.start.getMonth()]++;
                }
            });
            $.each(counts, function (i, v) {
                if (v!==0) {
                    $('.month-'+i).append('<span class="badge">'+v+'</span>');
                }
            });
        }

        function draw() {
            $el.html(t(options));
            //potential optimization (untested), this object could be keyed into a dictionary on the dateclass string; the object would need to be reset and the first entry would have to be made here
            $('.' + (new Date()).toDateCssClass()).addClass('today');
            if (options.data && options.data.length) {
                if (options.mode === 'year') {
                    yearAddEvents(options.data, options.date.getFullYear());
                } else if (options.mode === 'month' || options.mode === 'week') {
                    $.each(options.data, monthAddEvent);
                } else {
                    $.each(options.data, dayAddEvent);
                }
            }
        }

        draw();
    }

    ;(function (defaults, $, window, document) {
        $.extend({
            calendar: function (options) {
                return $.extend(defaults, options);
            }
        }).fn.extend({
            calendar: function (options) {
                options = $.extend({}, defaults, options);
                return $(this).each(function () {
                    var $this = $(this);
                    calendar($this, options);
                });
            }
        });
    })({
        days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sabado"],
        months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        shortMonths: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
        date: (new Date()),
        daycss: ["c-sunday", "", "", "", "", "", "c-saturday"],
        todayname: "Hoje",
        thismonthcss: "current",
        lastmonthcss: "outside",
        nextmonthcss: "outside",
        mode: "month",
        data: []
    }, jQuery, window, document);

})(jQuery);

var data = [];



data.sort(function(a,b) { return (+a.start) - (+b.start); });

//data must be sorted by start date

//Actually do everything
$('#holder').calendar({
    data: data
});

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

});
