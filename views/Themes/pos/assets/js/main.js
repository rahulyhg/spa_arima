
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

			// set Elem
			self.$elem = $(elem);
			self.setElem();

			self.Events();

			self.active( 'lists' );
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

			self.$e_lists.delegate('[data-global-action]', 'click', function () {
				
				self.active( $(this).attr('data-global-action') );
			});

			/*setTimeout(function () {

				self.$elem.find('.ui-effect-top').addClass('active');
				
			}, 1);*/
		},

		active: function ( val ) {
			var self = this;

			var el = self.$elem.find('[data-global='+ val +']');
			if( el.hasClass('active') ) return false;

			el.addClass('active').siblings().removeClass('active');
			self[ val ].init( {}, el, self, function () {
				
			} );
		},

		lists: {
			init: function (options, elem, then, callback ) {
				var self = this;

				self.$elem = $elem;
				self.then = then;

				self.then.active( 'invoice' );
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


				self.resize();
				$(window).resize(function () {
					self.resize();
				});
			},

			Events: function () {
				var self = this;

				self.$elem.find('[data-bill-action]').click( function () {
					var action = $(this).attr('data-bill-action');
					console.log( action );

					if( action == 'hold' ){
						self.then.active( 'lists' );
					}
					else if( action=='pay' ){
						self.then.active( 'pay' );
					}
					else if( action=='menu' ){
						self.then.active( 'menu' );
					}
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

		menu: {
			init: function (options, $elem, then, callback ) {
				var self = this;

				self.$elem = $elem;

				// Event
				self.$elem.find('.memu-tab > a').click(function () {
					$(this).addClass('active').siblings().removeClass('active');
				});


				self.$elem.delegate('.memu-table [data-id]', 'click', function () {
				
					then.active( 'change' );
				});
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

	var POS = {
		init: function (options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.pos.options, options );

			/*self.loadPageTimeOut = setTimeout( function () {
				self.$elem.find('#page-loading').animate({
					opacity: 0,
				}, 300, "linear", function() {
					self.$elem.removeClass('off');

					
				});
			}, 3000);*/

			self.$elem.removeClass('off');

			self.setElem();
			
			self.resize();
			$(window).resize(function () {
				self.resize();
			});


			self.Events();
			


		},

		setElem:function ( $el ) {
			var self = this;

			if( !$el ) $el = self.$elem;

			$el = self.$elem.find('#header-primary');
			self.$left = self.$elem.find('#leftCol');
			self.$content = self.$elem.find('#content');
			self.$main = self.$elem.find('#mainContent');

			// headerClock
			self.refClock();
		},

		refClock: function () {
			var self = this;

			setTimeout(function() {
				
				self.setClock();
			}, 1000);
		},
		setClock: function () {
			var self = this;

			var theDate = new Date();

			var ampm = 'AM';
			var hour = theDate.getHours();

			if( self.options.lang=='th' ){
				ampm = '';
			}else if( hour > 12 ){
				hour -= 12;
				ampm = 'PM';
			}

			var minute = theDate.getMinutes();
			minute = minute<10 ? '0'+minute:minute;

			var second = theDate.getSeconds();
			second = second<10 ? '0'+second:second;

			self.$header.find('.time').html( $.trim( hour + ':' + minute + ':' + second + ' ' + ampm ) );


			self.$header.find('.date').html( Datelang.day(theDate.getDay(),'normal',self.options.lang) +', '+ theDate.getDate()+' '+ Datelang.month( theDate.getMonth(),'normal',self.options.lang) + ', '+ theDate.getFullYear() ); 


			self.refClock();
		},
		resize: function () {
			var self = this;

			var parent = self.$left.parent();
			var left   = parseInt( self.$left.attr('data-width') ) || 550,
				height = $(window).height() - self.$header.outerHeight();


			if( self.$left.attr('data-width-percent') ){
				left = (left * $(window).width()) / 100;
			}

			self.$left.css({
				width: left,
				height: height
			});

			self.$content.css({
				marginLeft: parent.hasClass('hasLeft') ? left : 0
			});

			self.$main.css({
				height: height
			});
		},

		Events: function () {
			var self = this;

			self.$header.find('[data-nav]').click(function (e) {
				e.preventDefault();
				$(this).parent().addClass('active').siblings().removeClass('active');
			});
		}
	};
	$.fn.pos = function( options ) {
		return this.each(function() {
			var $this = Object.create( POS );
			$this.init( options, this );
			$.data( this, 'pos', $this );
		});
	};
	$.fn.pos.options = {
		lang: 'en'
	};


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


function setClock($el, lang) {
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

	$el.find('.time').html( $.trim( hour + ':' + minute + ':' + second + ' ' + ampm ) );

	$el.find('.date').html( Datelang.day(theDate.getDay(),'normal',lang) +', '+ theDate.getDate()+' '+ Datelang.month( theDate.getMonth(),'normal',lang) + ', '+ theDate.getFullYear() ); 
}
function RefClock( $el, lang ) {
	setTimeout(function() {			
		self.setClock($el, lang);

		RefClock($el, lang);
	}, 1000);
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


