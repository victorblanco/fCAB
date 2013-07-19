/*
 * Calendar for
 * JQuery
 * Manuel Garcia (thekeeper)
 * http://www.mgarcia.info
 * Version 0.2
 *
 * Copyright (c) 2007 Manuel Garcia
 * http://www.opensource.org/licenses/mit-license.php
 */


jQuery.calendar = function (el,open,Config) {
	jQuery.calendar.initialize(el);
}

Element = function (el) {
	return jQuery("<"+el+">");
}

jQuery.extend(jQuery.calendar, {

      initialize: function(el,open,Config) {
      this.input = $(el);
			var lng = new Object();

			// Firefox? IE ?
			try {  var nav = navigator.language.substr(0,2); }
			catch (e)	{ var nav = navigator.userLanguage;}

      lng['en'] = {
      	month : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				day : ['S','M','T','W','T','F','S'],
				first: 0 // Sunday
      };
			lng['es'] = {
      	month : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
      	day : ['L','M','M','J','V','S','D'],
      	first: 1 // First day of week => Monday
			};

			lng = (!lng[nav])? lng['en'] : lng =  lng[nav] ;
      /* configuration */
      if (!Config)
	      this.config = {
						Lng: lng,
					  imgNext: 'calendar-jquery_files/next.png',
					  imgPrev: 'calendar-jquery_files/prev.png',
					  imgCancel: 'calendar-jquery_files/cancel.gif'
				};

      this.month_name = this.config.Lng.month;
      this.day_name =  this.config.Lng.day;
			this.create_calendar();
    },
    findPos: function (obj) {
  	  var curleft = curtop = 0;
  	  if (obj.offsetParent) {
  		curleft = obj.offsetLeft
  		curtop = obj.offsetTop
  		while (obj = obj.offsetParent) {
  			curleft += obj.offsetLeft
  			curtop += obj.offsetTop
  		}
  	  }
  	   return [curleft,curtop];
    },
    create_calendar: function() {

     var position = this.input;
     if ($('#ncalendar'))  $('#ncalendar').remove();

      // content div  //

      this.div = new Element('div')
			.css({
      'top':'20', 
      'left':position.left})
			.attr('id', 'ncalendar');
			
      this.nav();
      this.setdate(this.input.attr('value'));
			//this.effect(this.div,'show');
		} ,
		nav: function (today) {
		  // nav
      this.calendardiv = new Element('div').appendTo(this.div);
      this.title = new Element('div')
      .css({'display':'inline','font-weight':'bold'})
			.appendTo(this.calendardiv);
      // next month
      this.next = new Element('img').attr('src', this.config.imgNext).insertAfter(this.title);
      // before month
      this.before = new Element('img').attr('src', this.config.imgPrev).insertBefore(this.title);
			// close
			this.close = new Element('img').attr('src', this.config.imgCancel).insertAfter(this.next);
			// table
			this.table = new Element('table').appendTo(this.calendardiv);
			var thead = new Element('thead').appendTo(this.table);
   		var tr = new Element('tr').appendTo(thead);

      jQuery.each(this.day_name, function(day,el) {
				var td = new Element('th').html(el).appendTo(tr);
			});
			
			var localThis = this;
			this.close.click(function(e) {
          localThis.div.remove();
  		});
		},
		setdate : function(date) {
			// reset event nav
			this.next.unbind( "click" );
			this.before.unbind( "click" );

			if (!this.validate_date(date)) {
        this.today = new Date();
		    this.today.setDate(1);
      } else {
      	var dateinp = date.split('/');
    		this.today = new Date(dateinp[2],dateinp[1]-1,dateinp[0],0,0,0);
			}

      this.next_m = this.today.getMonth();
      this.next_m++;

      this.title.html(this.month_name[this.today.getMonth()]+' ' + this.today.getFullYear());
  		var localThis = this;

			// event next
			this.next.click(function(e) {
          var date = localThis.today;
     	    date.setMonth(localThis.next_m+1,1);
	        localThis.tbody.remove();
          localThis.setdate(date.getDate()+'/'+date.getMonth()+'/'+date.getFullYear());
  		});
  		// event before
			this.before.click(function(e) {
          var date = localThis.today;
     	    date.setMonth(localThis.next_m-1,1);
          localThis.tbody.remove();
          localThis.setdate(date.getDate()+'/'+date.getMonth()+'/'+date.getFullYear());
  		});
			var LastMonth = new Date(this.today.getFullYear(),this.next_m-2,1,0,0,0);

			var last = LastMonth.getMonth();
			// total days the last month
			var counter = 0;
			for (var b = 1; b <= 31; b++) {
			  LastMonth.setDate(b);
 				if ( LastMonth.getMonth() == last) {
 				  counter++;
 				}
			}

			this.tbody = new Element('tbody').appendTo(this.table);
			var first_day = this.today;
			var last_day = this.today;
			this.month = this.today.getMonth();
   		var tr = new Element('tr').appendTo(this.tbody);

  		var day=0;

			/* first day week */
			first_day.setDate(1);
			var rest = (!first_day.getDay())? 6: first_day.getDay()-1;
			counter = counter - rest;
			for (var i= this.config.Lng.first; i <= 6; i++) {
			   if (first_day.getDay() == i) {
			    break;
      	 } else {
					counter++;
					LastMonth.setDate(counter);
					if (LastMonth.getMonth() == this.today.getMonth()) LastMonth.setMonth(this.today.getMonth()-1);
      	  this.create_td(tr,counter,LastMonth,'noday');
        }
   		}
			(this.config.Lng.first)? brea_k = 1:brea_k = 0;
   /* everydays */
      var date_s = this.today;
      var class_Css;
      var brea_k; // breaking week
  	  var daycounter = 0;
     	for (var i = 1; i <= 31; i++) {
    		date_s.setDate(i);
 				if (date_s.getMonth() == this.month) {
       		daycounter++;
		      if (date_s.getDay() == brea_k) {
						var tr = new Element('tr').appendTo(this.tbody);
					}
          class_Css = (!date_s.getDay())? 'sunday' : '';
					this.create_td(tr,i,date_s,class_Css);
				}
			}
			  this.today.setMonth(this.month);
       	this.today.setDate(daycounter);
       	var NextMonth = new Date(this.today.getFullYear(),this.today.getMonth()+1,1,0,0,0);
		    // finish month
			  var num = date_s.getDay();
			  num = (brea_k)? 7 - num: 6 - num;
			  var b;
			  b = (brea_k)? 0 : 6 ;
        if (this.today.getDay() != b) {
				  for (var i= 1; i <= (num); i++) {
				      NextMonth.setDate(i);
							this.create_td(tr,i,NextMonth,'noday');
					}
    		}
    		this.div.insertAfter($(this.input));
    },
		create_td: function(tr,i,date,class_Css) {
        var localThis = this;
				var td = new Element('td');
				if (date) {
				  var dia = date.getDate();
				  var mes = (date.getMonth()+1);
				  //  9 to 09 or another number <= 9
				  if (dia <= 9) dia = "0"+ dia;
				  if (mes <= 9) mes = "0"+ mes;
        	td.attr('id', dia + '/'+ mes +'/'+	date.getFullYear());
        }
        td.click(function(e) {
       			 var day = td.attr('id');
       			 $(localThis.input).attr('value',day);
						 localThis.effect(localThis.div,'fade');
						 localThis.div.remove();
  			});
  			
  			td.mouseover(function(e) {
						 td.addClass('dayselected');
  			});
  			td.mouseout(function(e) {
						 td.removeClass('dayselected');
  			});

    		if (class_Css) td.addClass(class_Css);
    		// Today ??
    		var today = new Date();
				today = today.getDate() + "/" + (today.getMonth()+1) + "/" + today.getFullYear();
				if (date) var date_td = date.getDate() + "/" + (date.getMonth()+1) + "/" + date.getFullYear();
				if (today == date_td) td.addClass('isToday');

  		  td.html(i);
				td.appendTo(tr);
		},
		effect: function(div,op) {
		  if (op == 'fade') {
		    $(div).hide("slow");
		  } else {
		    $(div).show("slow");
		  }
		},
		validate_date: function (date) {
		  		var regex = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;
		  		return (date.match(new RegExp(regex)) == null)? false: true;
		}
});
