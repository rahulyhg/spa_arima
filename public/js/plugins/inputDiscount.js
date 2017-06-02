// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var InputDiscount = {
		init: function ( options, elem ) {
			var self = this;

			self.$elem = $(elem);

			var $discount = self.$elem.find('[id=discount]');
			var price = parseInt(self.$elem.find('[id=price]').val());

			var $total = self.$elem.find('[id=total]');
			var total = parseInt($total.val());

			function _change() {
				var val = parseInt( $discount.val() );
				$total.val( price - val );
			}

			$discount.keydown(function (e) {
				// Allow: backspace, delete, tab, escape, enter and .
		        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
		             // Allow: Ctrl+A, Command+A
		            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
		             // Allow: home, end, left, right, down, up
		            (e.keyCode >= 35 && e.keyCode <= 40)) {
		                 // let it happen, don't do anything
		                 return;
		        }
		        // Ensure that it is a number and stop the keypress
		        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		            e.preventDefault();
		        }
			}).change(_change).keyup(_change);

		},
	}
	$.fn.inputDiscount = function( options ) {
		return this.each(function() {
			var $this = Object.create( InputDiscount );
			$this.init( options, this );
			$.data( this, 'inputDiscount', $this );
		});
	};
	$.fn.inputDiscount.options = {
		lang: 'en',
	};

})( jQuery, window, document );