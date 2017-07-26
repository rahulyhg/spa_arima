// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var POs = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.POs.options, options );

			self.setElem();
			self.resize();
			$(window).resize(function() {
				self.resize();
			});


			// set Data 
			self.data = {
				cus_qty: 1,
				date: new Date(self.options.date),
				items: {},

				summary: {

				}
			};

			$.each( self.$bill.find('[data-bill-summary]'), function() {
				self.data.summary[ $(this).attr('data-bill-summary') ] = 0;
			});

			self.display();

			self.queue = [];
			self._active = 'menu';

			self.active();

			self.Events();
		},
		setElem: function () {
			var self = this;

			$.each( self.$elem.find('[data-pos]'), function(i, obj) {
				self[ '$'+ $(this).attr('data-pos') ] = $(this);
			});
		},
		resize: function () {
			var self = this;

			var $el = self.$elem.find('.slipPaper-container');

			$el.find('.slipPaper-bodyContent').css({
				top: $el.find('.slipPaper-bodyHeader').outerHeight() + 20,
				bottom: $el.find('.slipPaper-bodyFooter').outerHeight()
			});

		},

		active: function () {
			var self = this;

			self.$elem.find('[data-pos='+ self._active +']').addClass('active').siblings().removeClass('active');
			self.resize();
		},

		Events: function () {
			var self = this;

			self._queue = 0;
			self.$menu.find('[data-id]').click(function() {
				
				self.queue.push({
					id: $(this).data('id'),
					date: PHP.dateJStoPHP( self.options.date ),
					type: 'package',
					cus_qty: self.data.cus_qty
				});
				self.chooseMenu();
			});

			self.$bill.find('[data-bill-set]').click(function() {

				var set = $(this).data('bill-set');

				if( set == 'cus_qty' ){
					self.getCus_qty();
				}

				console.log( set );
			});
		},

		chooseMenu: function () {
			var self = this;

			self.getMenu( self.queue[ self._queue ]  ).done(function (res) {
					
				self.setMenu(res);

				self._queue++;
				if( self.queue[ self._queue ] ){
					self.chooseMenu();
				}
			});
		},
		getMenu: function ( data ) {
			var self = this;

			return $.ajax({
				url:  Event.URL + 'orders/menu/',
				type: 'GET',
				dataType: 'json',
				data: data,
			})
			.fail(function() {
				// console.log("error");
			})
			.always(function() {
				// console.log("complete");
			});
		},
		setMenu: function ( data ) {
			var self = this;

			if( !self.data.items[ data.id ] ){

				self.data.items[ data.id ] = {
					id: data.id,
					name: data.name,
					time: parseInt( data.qty ),
					unit: data.unit,

					price: parseInt( data.price ),
					qty: 0,
					discount: 0,

					status: 'order',

					has_masseuse: data.has_masseuse,

					cus: {}
				};

				for (var i = 0; i < self.data.cus_qty; i++) {

				 	self.data.items[ data.id ].cus[ i ] = {
				 		qty: 0,
				 		price: parseInt( data.price ),
						qty: 0,
						discount: 0,
				 	}
				}	
			}

			for (var i = 0; i < self.data.cus_qty; i++) {
			 	self.data.items[ data.id ].cus[ i ].qty++;
			}


			console.log( self.data.items );
		},


		display: function () {
			var self = this;


			self.$bill.find('[data-bill=cus_qty]').text( self.data.cus_qty );
			// console.log( self.data );
		},


		getCus_qty: function () {
			var self = this;

			Dialog.load( Event.URL + 'orders/setBill/', {type: 'cus_qty', value: self.data.cus_qty}, {
				onSubmit: function ($d) {

					var val = parseInt($d.$pop.find(':input[name=cus_qty]').val()) || 1;
					self.data.cus_qty = val < 1 ? 1 :val;
					self.display();

					Dialog.close();
				}
			});
		}
	};

	$.fn.POs = function( options ) {
		return this.each(function() {
			var $this = Object.create( POs );
			$this.init( options, this );
			$.data( this, 'POs', $this );
		});
	};

	$.fn.POs.options = {
		
	};
	
})( jQuery, window, document );