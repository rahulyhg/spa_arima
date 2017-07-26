// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var POsOrder = {
		init: function(options, elem) {
			var self = this;

			self.$elem = $(elem);
			self.options = options;

			self.setData();
			self.setElem();

			self.resize();
			$(window).resize(function() {
				self.resize();
			});

			self.Events();

			self.active( 'lists' );
		},
		setData: function () {
			var self = this;

			self.currData = {};
			self.obj = {};

			self.$date = $('[data-global=date]');
			self.$date.parent().removeClass('hidden_elem');
			theDate = self.$date.val();

			if( !self.options.date ){
				theDate = new Date();
			}
			else{
				var res = self.options.date.split("-");
				theDate = new Date(pasreInt(res[0]), pasreInt(res[1])+1,pasreInt(res[2]));
			}

			self.$date.datepicker({

				onChange: function ( d ) {
					theDate = new Date(d);
				}
				// date: theDate
			});
		},
		setElem: function () {
			var self = this;

			self.$elem.find('[role]').each(function () {
				if( $(this).attr('role') ){
					var role = "$" + $(this).attr('role');
					self[role] = $(this);
				}
			});
		},
		resize: function () {
			var self = this;

			var outer = $( window );
			var offset = self.$elem.offset();
			var right = 0, leftw = 0;
			var fullw = outer.width() - (offset.left+right);
			var fullh = (outer.height() + outer.scrollTop()) - $('#header-primary').outerHeight();

			self.$main.css({
				height: fullh
			});

			if( !$('#mainContainer').hasClass('on') ){
				$('#mainContainer').addClass('on');
			}
		},

		Events: function () {
			var self = this;

			/*self.$elem.find('[data-action]').click(function() {
				self.active( $(this).data('action') );
			});*/


		},
		active: function ( tab ) {
			var self = this;

			// console.log( tab );

			var $el = self.$elem.find('[data-global='+ tab +']');
			if( !self.obj[tab] ){

				self.obj[tab] = $el[ $el.attr('plugin') ]({
					date: theDate
				});
				/* = self[tab];
				self.obj[tab].init( $el );*/
			}

			// self.obj[tab].on();
			$el.addClass('active').siblings().removeClass('active');
		},

		lists: {
			init: function ( $elem ) {
				var self = this;

				self.$elem = $elem;
			},
			on: function () {
				var self = this;
				
			}
		},

		create: {
			init: function () {
				var self = this;
				
			},
			on: function () {
				// body...
			}
		},
	};

	$.fn.POsOrder = function( options ) {
		return this.each(function() {
			var $this = Object.create( POsOrder );
			$this.init( options, this );
			$.data( this, 'POsOrder', $this );
		});
	};

	$.fn.POsOrder.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );