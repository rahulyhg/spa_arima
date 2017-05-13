
// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Order = {
		init: function (options, elem) {
			var self = this;

			self.options = $.extend( {}, $.fn.order.options, options );

			// set Elem
			self.$elem = $(elem);
			self.setElem();

			// set data 
			self.currOrder = self.setOrderDefault();

			self.Events();

			self.active( 'bill' );
			self.active( 'menu' );
		},
		setElem: function () {
			var self = this;

			$.each( self.$elem.find('[data-global]'), function () {
				self[ '$e_'+ $(this).attr('data-global') ] = $(this);
			} );			
		},

		Events: function() {
			var self = this;

			/*self.$e_lists.delegate('[data-id]', 'click', function () {
				
				$(this).addClass('active').siblings().removeClass('active');

				self.active( 'invoice' );
			});*/

			self.$elem.delegate('[data-global-action]', 'click', function () {
				self.active( $(this).attr('data-global-action') );
			});


			self.$elem.find('[data-global=lists]').find('.js-datepicker').datepicker({
					onChange: function () {
						self.data.date = new Date( this.selectedDate );
					}
				});

			self.$elem.find('[data-global=menu]').delegate('.memu-table [data-id]', 'click', function () {


				self.chooseMenu( $(this).data('type'), $(this).data('id') );
			});

			self.$elem.find('[data-global=bill]').delegate('[role=orderlists] > tr', 'click', function () {
					
				var data = $(this).data();
				self.setDetail( data );

				$(this).addClass('active').siblings().removeClass('active');

				self.currMenu = data;
				self.active( 'detail' );
			});


			// 
			self.$elem.find('[data-global=bill]').find('[data-bill-action]').click( function () {
				var action = $(this).attr('data-bill-action');

				if( action == 'hold' ){
					self.active( 'lists' );
					self.active( 'summary' );
				}
				else if( action=='pay' ){
					self.active( 'pay' );
				}
				else if( action=='menu' ){
					self.active( 'menu' );
				}
				else if( action=='send' ){

					self.saveBill();

					// console.log('save', self.currOrder );
					// self.active( 'lists' );
				}
			});

			self.$elem.find('[data-global=detail]').find('.js-add-time').click(function () {
				
				self.chooseMenu( 'package', self.currMenu.id, function () {
					
					self.setDetail( self.currMenu );

					self.$elem.find('[data-global=bill]').find('[role=orderlists] > tr[data-id='+ self.currMenu.id +']').addClass('active');
				} );
			});

			self.$elem.find('[data-global=detail]').delegate('.js-remove-time', 'click', function () {
				console.log( 1 );
			});


			$(window).keydown(function (e) {

				if( !isNaN(e.key) ){
					// console.log( 'pay:', parseInt( e.key ) );
				}
		    });


		    self.$elem.find('[data-bill-set]').click( function () {
		    	var type = $(this).attr('data-bill-set');

		    	var data = {
		    		type: type
		    	}

		    	if(  type=='drink' ){
		    		data.drink = self.currOrder.summary.drink;
		    	}
		    	
		    	Dialog.load( Event.URL + 'orders/set_bill', data, {
		    		onSubmit: function ( $el ) {
		    			
		    			console.log( $el );

		    			if(  type=='drink' ){
		    				self.currOrder.summary.drink = $.trim($el.$pop.find('#drink').val());
			    			self.summaryPrice();
			    			self.summaryDisplay();
		    			}
		    			
		    			console.log( 'Submit' );

		    			Dialog.close();
		    		}
		    	} );
			} );
		},

		saveBill: function () {
			var self = this;

			$.post( Event.URL + 'orders/save', self.currOrder, function (res) {
				
				console.log( res );
			}, 'json');	
		},

		active: function ( val ) {
			var self = this;

			var el = self.$elem.find('[data-global='+ val +']');
			if( el.hasClass('active') ) return false;

			el.addClass('active').siblings().removeClass('active');
			self[ val ].init( self.options, el, self, function () {
				
			} );
		},

		chooseMenu: function ( type, id, callback) {
			var self = this;

			$.get(Event.URL + 'orders/menu/', { type: type, id: id }, function (res) {

				if( type=='package' ){
					self.loadMenu( res );
					if( typeof callback === 'function' ){
						callback( res );
					}
				}

				if( type=='promotion' ){

					$.each( res, function (i, obj) {
						self.loadMenu( obj );
					} );
				}

			}, 'json');
		},

		loadMenu: function ( data ) {
			var self = this;

			var KEY = data.id;

			if( !self.currOrder.items[ KEY ] ){

				var data = {
					KEY: KEY,
					id: data.id,
					name: data.name,
					qty: 0,
					unit: data.unit,
					time: data.qty,
					
					price: parseInt( data.price ),
					discount: 0,

					detail: [],

					status: 'order',

					start_date: new Date(),
				};

				self.currOrder.items[ KEY ] = data;

				self.newItemBill(data);
			}

			self.currOrder.items[ KEY ].qty++;
			self.currOrder.items[ KEY ].detail.push({
				masseuse_id: '',
				masseuse_name: '',
				
				room_id: '',
				room_name: '',

				bed_id: '',
				bed_name: '',
				unit: data.unit,

				price: parseInt( data.price ),
				discount: 0,

				status: 'order',

				start_date: new Date(),
			} );

			self.updateItemBill( self.currOrder.items[ KEY ] );

			// self.setChange( res );
			// console.log( self.currOrder );
			self.checkPromotion();
			self.resizeBill();


			self.summaryPrice(); 
			self.summaryDisplay();
		},

		checkPromotion: function () {
			var self = this;

			// console.log( self.currOrder.items );
			var qty = 0;
			for (var obj in self.currOrder.items) {

				var data = self.currOrder.items[obj];

				// if( data.price==350 ){
				qty += data.qty;
				// }
			}

			if( qty>=2 ){

				for (var obj in self.currOrder.items) {

					var data = self.currOrder.items[obj];
					if( data.price==350 ){

						var deduct = 50;

						self.currOrder.items[obj].discount = data.qty*deduct;

						$.each( self.currOrder.items[obj].detail, function (i) {
							self.currOrder.items[obj].detail[i].discount = deduct;
						} );

						self.updateItemBill( data );
					}
					
				}
			}

			/*$.map(self.currOrder.items, function (key, obj) {

				console.log( key, obj );
			} );*/
		},
		newItemBill: function(data) {
			var self = this;

			data.no = self.$elem.find('[data-global=bill]').find('[role=orderlists]>tr').length + 1;

			var $item = self.setItemBill( data );
			self.$elem.find('[data-global=bill]').find('[role=orderlists]').append( $item );
		},
		setItemBill: function (data) {
			var self = this;

			var cost = data.qty * data.price;
			var total = cost - data.discount;

			var $price = $('<td>', {class: 'price'}).append(
				  $('<div>', {class: 'cost'}).text( PHP.number_format( cost ) )
				, $('<div>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
				, $('<div>', {class: 'total'}).text( PHP.number_format( total ) )
			);

			$price.toggleClass('has-discount', data.discount>0);
			
			var $meta = $('<div>', {class: 'order-title fsm'});

			if( data.masseuse_name ){
				$meta.append( $('<label>', {text: 'Masseuse:'}), data.masseuse_name );
			}

			if( data.room_name ){
				$meta.append( $('<label>', {text: 'Room:'}), data.room_name );
			}

			if( data.bed_name ){
				$meta.append( $('<label>', {text: 'Bed:'}), data.bed_name );
			}

			$status = $('<div>', {class: 'ui-status', 'data-status': data.status, text: data.status});

			var qty = data.time*data.qty, unit = data.unit;
			if( unit=='minute' && qty >=60 ){
				unit = 'hour';

				var hour = parseInt( qty / 60);
				var minute = qty - (hour*60);
				qty = minute>0
					? hour + '.' + minute
					: hour;
			}

			var $tr = $('<tr>', {'data-id': data.id}).append( 

				  $('<td>', {class: 'no'}).text( data.no+'.' )
				, $('<td>', {class: 'name'}).append( 
					  $('<div>', {class: 'title fwb'}).text( data.name )
					, $meta
				)
				, $('<td>', {class: 'status'}).html( $status )
				, $('<td>', {class: 'qty'}).text( qty )
				, $('<td>', {class: 'unit'}).text( unit )
				, $price

			);

			$tr.data( data );
			return $tr;
		},
		updateItemBill: function (data) {
			var self = this;

			var $item = self.setItemBill( data );
			var $box = self.$elem.find('[data-global=bill]').find('[role=orderlists]').find( '[data-id='+ data.id +']' );

			$box.replaceWith( $item );


			self.$elem.find('[data-global=menu]').find('[data-memu=package]').find('[data-id='+ data.id + ']').addClass('active').find('.countVal').text( data.qty );
		},
		resizeBill: function () {
			var self = this;

			$.each( self.$elem.find('[data-global=bill]').find('[role=orderlists]>tr').first().find('td'), function ( i ) {

				var td = $(this);
				var th = self.$elem.find('[data-global=bill] .slipPaper-bodyContent-header').find('table th').eq( i );

				if( td.hasClass('name') ) return

				var outerW = td.outerWidth()
				var width = td.width();

				if( th.width() > width){
					outerW = th.outerWidth();
					width = th.width();
				}
		
				td.width( width );
				th.width( width );
			});
		},

		setDetail: function (data) {
			var self = this;

			console.log( 'setDetail', data );

			var $box = self.$elem.find('[data-global=detail]');
			$box.find('[data-text=title]').text( data.name );

			var $listsbox = $box.find('[role=listsbox]');
			$listsbox.empty();

			var no = 1;
			$.each( data.detail, function (i, obj) {
				obj.no = no++;

				$listsbox.append( self.itemDetail( obj ) );
			} );

		},
		itemDetail: function (data ) {

			console.log( data );

			var $masseuse = '<td><div class="anchor clearfix"><div class="avatar lfloat mrm no-avatar"><div class="initials">1</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname"></div><span class="subname fsm"></span></div></div></div></td>';

			var cost = data.price;
			var total = cost - data.discount;

			var $price = $('<td>', {class: 'price'}).append(
				  $('<div>', {class: 'cost'}).text( PHP.number_format( cost ) )
				, $('<div>', {class: 'discount'}).append( '-', PHP.number_format(data.discount) )
				, $('<div>', {class: 'total'}).text( PHP.number_format( total ) )
			);

			$price.toggleClass('has-discount',  data.discount > 0);

			var $time = $('<td>', {class: 'time'});


			$time.append( 1, $('<span>', {class: 'mls'}).text(data.unit) );


			var $tr = $('<tr>').append(

				$('<td>', {class: 'no'}).html( data.no + '.' ),

				$masseuse,

				$time, //'<td class="time"><div>1 TIME</div><div>8:10 PM - 10:10 PM</div></td>',

				$price, 

				$('<td>', {class: 'actions'}).html( '<span class="gbtn"><a class="btn btn-no-padding js-remove-time"><i class="icon-remove"></i></a></span>' )
			);

			$tr.data( data );

			return $tr;
		},

		summaryPrice: function () {
			var self = this;

			var a = [0,0,0]; // subtotal, discount, 

			for (var obj in self.currOrder.items) {
				var data = self.currOrder.items[obj];

				data.cost = data.qty*data.price;
				data.total = data.cost - data.discount;

				a[0] += data.cost;
				a[1] += data.discount;
			}

			self.currOrder.summary.subtotal = a[0];
			self.currOrder.summary.discount = a[1];

			self.currOrder.summary.total = (a[0] + self.currOrder.summary.drink) - a[1];
		},
		summaryDisplay: function () {
			var self = this;
			
			// 
			$.each( self.currOrder.summary, function (key, val) {
				self.$elem.find('[summary='+ key +']').text( PHP.number_format(val) );
			} );			
		},

		lists: {
			init: function (options, elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;


				self.options = options;

				// set Data
				self.data = {
					date: self.options.date
				};


				self.setElem();
				// self.then.active( 'invoice' );

				self.refresh();
			},
			setElem: function () {
				var self = this;

				self.$listsbox = self.$elem.find('.ui-list-orders');
				self.$listsbox.empty();	
			},

			refresh: function () {
				var self = this;

				if( self.$listsbox.parent().hasClass('has-empty') ){
					self.$listsbox.parent().removeClass('has-empty');
				}
				self.$listsbox.parent().addClass('has-loading');

				setTimeout(function () {
					self.fetch().done(function( results ) {

						self.data = $.extend( {}, self.data, results.options );

						if( results.total==0 ){
							self.$listsbox.parent().addClass('has-empty');
							return false;
						}

						self.buildFrag( results.lists );
					});
				}, length || 1);

				/*$.get( Event.URL + 'orders/lists', {}, function (res) {
					
					$.each( res.lists, function (i, obj) {
						self.$listsbox.append( self.setItem( obj ) );
					} );
				}, 'json');*/
			},
			fetch: function(){
				var self = this;

				return $.ajax({
					url: Event.URL + 'orders/lists',
					data: self.data,
					dataType: 'json'
				}).always(function() {
					self.$listsbox.parent().removeClass('has-loading');
				}).fail(function() {
					self.$listsbox.parent().addClass('has-empty');
				});
			},
			buildFrag: function ( results ) {
				var self = this;

				var currTime = '';
				$.each(results, function (i, obj) {

					var time = new Date(  );

					self.display( obj );
				});


				/*if( self.$listsbox.find('li.active').length==0 && self.$listsbox.find('li').not('.head').first().length==1 ){
					self.active( self.$listsbox.find('li').not('.head').first() );
				}*/
			},
			display: function ( data ) {
				var self = this;

				var item = self.setItem( data );

				self.$listsbox.append( item );
			},

			setItem: function (data) {
				var self = this;

				$li = $('<li>');

				$('<li>', {class: "ui-item"}).append( ''+ 
				'<div class="ui-item-inner clearfix">'+
					'<div class="rfloat"><abbr class="timestamp fsm">9:25</abbr></div>'+
					
					'<div class="text">' +
						'<span><label>No.</label> <strong>1</strong></span>' +
						'<span><i class="icon-address-card-o"></i>ภุชงค์</span>' +
					'</div>' +
					
					'<div class="subtext clearfix">' +
						'<span><label>Package:</label> AKASURI, SAUNA</span>' +
						'<div class="rfloat"><span class="ui-status">RUN</span></div>' +
					'</div>' +

					'<div class="subtext clearfix">' +
						'<span><label>Total Time:</label> 10.00 - 11.00 PM</span>' +

					'</div>' +
				'</div>' );

				$li.data( data );
				return $li;
			}
		},

		invoice: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;

				self.resize();
				$(window).resize(function () {
					self.resize();
				});
			},
			resize: function () {
				var self = this;

				var fw = $(window).width(),
					fh = $(window).height();

				// set Slip

				self.$elem.find('.slipPaper-main').css({
					bottom: self.$elem.find('.slipPaper-footer').outerHeight(),
				});

				self.$elem.find('.slipPaper-bodyContent').css({
					top: self.$elem.find('.slipPaper-bodyHeader').outerHeight() + 30,
					bottom: self.$elem.find('.slipPaper-bodyFooter').outerHeight(),
				});


				self.$elem.find('.slipPaper-bodyContent-body').css({
					top: self.$elem.find('.slipPaper-bodyContent-header').outerHeight()
				});
			}
		},

		setOrderDefault: function ( date ) {
			var self = this;


			self.$elem.find('[data-global=bill]').find('[role=orderlists]').empty();
			self.$elem.find('[data-global=menu]').find('[role=menu] .active').removeClass('active');
			
			return {
				theDate: date ? new Date(date): new Date(),
				summary: {
					tip: 0,
					subtotal: 0,
					total: 0,
					change: 0,
					drink: 0,
					discount: 0,
					pay: 0,
				},

				items: []
			};
		},

		bill: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.then = then;

				// set Data
				self.then.currOrder = self.then.setOrderDefault();
				self.options = options;

				// set Elem 
				self.$elem = $elem;
				
				

				// get Data
				var $date = $('<input>', {type: 'date'});

				// Datelang.fulldate( self.then.currOrder.theDate, 'normal', self.options.lang )
				self.$elem.find('[data-bill=date]').html( $date );

				$date.datepicker({
					lang: self.options.lang,
					onChange: function () {
						
						self.getNumber();
					}
				});

				self.getNumber( function () {
					
					self.then.active( 'menu' );

					if( typeof callback === 'function' ){
						callback();
					}
				} );

				// 
				self.resize();
				$(window).resize(function () {
					self.resize();
				});
			},

			getNumber: function ( callback ) {
				var self = this;

				self.$elem.addClass('has-loading');

				$.get( Event.URL + 'orders/lastNumber', {date: PHP.dateJStoPHP( self.then.currOrder.theDate ) }, function (number) {
					self.then.currOrder.number = number;

					self.$elem.removeClass('has-loading');
					self.$elem.find('[data-bill=number]').text(number);

					if( typeof callback === 'function' ){
						callback();
					}

				}, 'json');
			},

			resize: function () {
				var self = this;

				var fw = $(window).width(),
					fh = $(window).height();

				// set Slip

				self.$elem.find('.slipPaper-main').css({
					bottom: self.$elem.find('.slipPaper-footer').outerHeight(),
				});

				self.$elem.find('.slipPaper-bodyContent').css({
					top: self.$elem.find('.slipPaper-bodyHeader').outerHeight() + 30,
					bottom: self.$elem.find('.slipPaper-bodyFooter').outerHeight(),
				});


				self.$elem.find('.slipPaper-bodyContent-body').css({
					top: self.$elem.find('.slipPaper-bodyContent-header').outerHeight()
				});
			}
		},

		menu: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				console.log( 'This menu' );
				// set Elem 
				self.$elem = $elem;
				// self.$listsbox = self.$elem.find('[ref=listsbox]');

				self.data = {
					type: self.$elem.find('.memu-tab > a.active').data('type')
				};


				// 
				then.$elem.find('[data-global=bill]').find('[role=orderlists] > tr.active').removeClass('active');

				self.active();
				// self.refresh();

				// Event
				self.$elem.find('.memu-tab > a').click(function () {
					$(this).addClass('active').siblings().removeClass('active');

					self.data = {
						type: $(this).data('type')
					}

					self.active();
					// self.refresh( );
				});
				
			},
			active: function () {
				var self = this;

				var $el = self.$elem.find('[data-memu='+ self.data.type +']');

				$el.addClass('active').siblings().removeClass('active');

				$el.parent().scrollTop(0);
			},

			refresh: function (length) {
				var self = this;

				if( self.$listsbox.parent().hasClass('has-empty') ){
					self.$listsbox.parent().removeClass('has-empty');
				}
				self.$listsbox.parent().addClass('has-loading');

				setTimeout(function () {
					self.fetch().done(function( results ) {

						self.data = $.extend( {}, self.data, results.options );

						if( results.total==0 ){
							self.$listsbox.parent().addClass('has-empty');
							return false;
						}

						self.buildFrag( results.lists );
					});
				}, length || 1);
			},
			fetch: function(){
				var self = this;

				return $.ajax({
					url: Event.URL + 'orders/menu',
					data: self.data,
					dataType: 'json'
				}).always(function() {
					self.$listsbox.parent().removeClass('has-loading');
				}).fail(function() {
					self.$listsbox.parent().addClass('has-empty');
				});
			},
			buildFrag: function ( results ) {
				var self = this;

				$.each(results, function (i, obj) {
					self.display( obj );
				});
			},
			display: function ( data ) {
				var self = this;

				var item = self.setItem( data );

				self.$listsbox.append( item );
			},
			setItem: function () {	
			}
		},

		detail: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				self.$elem = $elem;

			}
		},

		pay: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;

				console.log( 'This Pay' );
			},
		},

		summary: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;
			}
		}
	}

	$.fn.order = function( options ) {
		return this.each(function() {
			var $this = Object.create( Order );
			$this.init( options, this );
			$.data( this, 'order', $this );
		});
	};
	$.fn.order.options = {
		lang: 'en',
		date: new Date(),
		promotions: []
	};

	/**/
	/* JopQueue */
	/**/
	var JopQueue = {
		init: function (options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.options = $.extend( {}, $.fn.jopQueue.options, options );

			self.$listsbox = self.$elem.find('[ref=listsbox]');

			self.$listsbox.sortable({
				stop: function (event, ui) {
					self.set_sequence();			
				}
			});
		},

		set_sequence: function () {
			var self = this;

			var n = 0
			$.each(self.$listsbox.find('li'), function (i, obj) {
				n++;

				// $( obj ).find('.number').text( n )
			});
			
		}
	}
	$.fn.jopQueue = function( options ) {
		return this.each(function() {
			var $this = Object.create( JopQueue );
			$this.init( options, this );
			$.data( this, 'jopQueue', $this );
		});
	};
	$.fn.jopQueue.options = {
		lang: 'en'
	};
	

})( jQuery, window, document );


function RefClock($el, lang) {

	var self = this;
	var theDate = new Date();

	var ampm = 'AM';
	var hour = theDate.getHours();

	if( lang=='th' ){
		ampm = '';
	}else if( hour > 12 ){
		hour -= 12;
		ampm = 'PM';
	}

	var minute = theDate.getMinutes();
	minute = minute<10 ? '0'+minute:minute;

	var second = theDate.getSeconds();
	second = second<10 ? '0'+second:second;

	var time = $.trim( hour + ':' + minute + ':' + second + ' ' + ampm );
	var date = Datelang.day(theDate.getDay(),'normal',lang) +', '+ theDate.getDate()+' '+ Datelang.month( theDate.getMonth(),'normal',lang) + ', '+ theDate.getFullYear();

	$el.find('.time').html( time );
	$el.find('.date').html( date );

	// document.getElementById('clockTime').innerHTML = time; 
	// document.getElementById('clockDate').innerHTML = date; 

	var t = setTimeout(function () {
		RefClock($el, lang)
	}, 500);
}

$(function () {

	// var elem = $(window)[0]; // Make the body go full screen.
	// toggleFullScreen();

	$('.js-navigation-trigger').click(function () {

		var $page = $('#doc');

		if( !$('body').hasClass('is-pushed-left') ){

			var scroll = $(window).scrollTop()*-1;
			$page.addClass('fixed_elem').css('top', scroll);

			setTimeout(function () {
				$('body').addClass('is-pushed-left');
			},200);
		}
		else{
			
			var scroll = parseInt( $page.css("top"));
				scroll = scroll<0 ? scroll*-1:scroll;

			$('body').removeClass('is-pushed-left');

			$page.removeClass('fixed_elem').css('top', "");
			$(window).scrollTop( scroll );

		}
	});

	RefClock( $('.headerClock'), $('html').attr('lang') );
	// 

});


