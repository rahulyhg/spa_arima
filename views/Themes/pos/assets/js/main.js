
// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

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

			self.$header = self.$elem.find('#header-primary');
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

			self.$listsbox = self.$elem.find('[rel=listsbox]');

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

				$( obj ).find('.number').text( n );
				
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

});


