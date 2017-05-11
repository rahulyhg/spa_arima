
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

			// set data 
			self.currOrder = {
				items: []
			};

			// set Elem
			self.$elem = $(elem);
			self.setElem();

			self.Events();

			self.active( 'lists' );
			self.active( 'summary' );
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

			self.$elem.find('[data-global=menu]').delegate('.memu-table [data-id]', 'click', function () {
					
				$.get(Event.URL + 'orders/menu/', {
					type: $(this).data('type'), 
					id: $(this).data('id') 
				}, function (res) {
					console.log( res );

					// set bill
					// set menu profile
					self.setBill( res );
					self.setChange( res );

					self.active( 'change' );
				}, 'json');
			});

			self.$elem.find('[data-global=bill]').delegate('[role=orderlists] > tr', 'click', function () {
					
				var data = $(this).data();
				self.setChange( data );

				self.active( 'change' );
			});


			// 
			self.$elem.find('[data-global=bill]').find('[data-bill-action]').click( function () {
				var action = $(this).attr('data-bill-action');
				console.log( action );

				if( action == 'hold' ){
					self.active( 'lists' );
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
			/*setTimeout(function () {
				self.$elem.find('.ui-effect-top').addClass('active');
			}, 1);*/
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
			self[ val ].init( {}, el, self, function () {
				
			} );
		},

		setBill: function (data) {
			var self = this;

			self.currOrder.items.push( data );

			var $tr = $('<tr>').append( '' +
				'<td class="no">1.</td>' + 
				'<td class="name">'+
					'<div class="title">'+
						'<strong>'+ data.name +'</strong>'+
						// '<span class="ui-status">50%</span>'+
					'</div>'+
					'<div class="order-title fsm">'+
						'<span><label>Room: </label> 101</span>'+
						'<span><label>By:</label> <i class="icon-user-circle-o"></i>ภุชงค์</span>'+
					'</div>'+
				'</td>' + 

				'<td class="time">1</td>'+
				'<td class="unittime">TIME</td>'+

				'<td class="price has-discount">'+
					'<div class="full">0</div>'+
					'<div class="discount">0</div>'+
				'</td>'+
			'' );

			$tr.data( data );
			self.$elem.find('[data-global=bill]').find('[role=orderlists]').append( $tr );
		},
		setChange: function (data) {
			var self = this;

			var $box = self.$elem.find('[data-global=change]');

			$box.find('[data-text=title]').text( data.name );

			var $listsbox = $box.find('[role=listsbox]');

			$listsbox.empty();


			var $tr = $('<tr>').append( '' +

				'<td>101</td>' + 
				'<td><div class="anchor clearfix"><div class="avatar lfloat mrm no-avatar"><div class="initials">1</div></div><div class="content"><div class="spacer"></div><div class="massages"><div class="fullname"></div><span class="subname fsm"></span></div></div></div></td>' + 
				'<td class="time"><div>1 TIME</div><div>8:10 PM - 10:10 PM</div></td>' + 
				'<td class="price">350฿</td>' + 
				'<td class="actions">'+
					'<span class="gbtn"><a class="btn btn-no-padding"><i class="icon-remove"></i></a></span>'+
				'</td>' + 

			'' );

			$listsbox.append( $tr );

		},

		lists: {
			init: function (options, elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;

				// set Data
				self.data = {};


				self.setElem();
				// self.then.active( 'invoice' );

				self.refresh();
			},
			setElem: function () {
				var self = this;

				self.$listsbox = self.$elem.find('.ui-list-orders');
				self.$listsbox.empty();


				self.$elem.find('.js-datepicker').datepicker({
					onChange: function () {
						
						console.log( 1 );
					}
				});
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

		bill: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;
				self.then = then;

				self.Events();
				self.then.active( 'menu' );

				self.then.currOrder = {
					bill: {},
					items: []
				};
				$.get( Event.URL + 'orders/lastNumber', function (number) {
					self.then.currOrder.bill.number = number;

					// self.setTitle();

					self.$elem.find('[data-title=number]').text(number);

				}, 'json');

				self.resize();
				$(window).resize(function () {
					self.resize();
				});
			},

			setTitle: function () {
				var self = this;

			},

			Events: function () {
				var self = this;

				
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
				self.$elem = $elem;

				// Event

				self.refresh( self.$elem.find('.memu-tab > a.active').data('type') );
				self.$elem.find('.memu-tab > a').click(function () {
					$(this).addClass('active').siblings().removeClass('active');

					self.refresh( $(this).data('type') );
				});
				
			},

			refresh: function ( type ) {
				var self = this; 

				$.get( Event.URL + 'orders/menu/', {type: type}, function (res) {
					console.log( res );

				}, 'json');
				
			}
		},

		change: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				self.$elem = $elem;

			}
		},

		pay: {
			init: function (options, $elem, then, callback ) {
				var self = this;
				self.$elem = $elem;
			}
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
		lang: 'en'
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


