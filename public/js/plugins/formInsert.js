// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var formInsert = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;
			

			self.initElem();
			self.initEvent();
		},
		initElem: function () {
			var self = this;

			self.$elem = $(self.elem);

			self.identification_card();
			self.phone_number();

			// self.$elem.find('fieldset table.table-address').first().addClass('first');

			// console.log( self.$elem.find('fieldset').length );
			self.$elem.find('fieldset').each(function () {
				
				$(this).find('.table-address').first().css('border-top', '1px solid #666');
				$(this).find('.table-address').last().css('border-bottom', '1px solid #666');
			});
		},

		initEvent: function () {
			var self = this;

			// var split = 'john smith~123 Street~Apt 4~New York~NY~12345'.split('~');

			self.$elem.find('input#identification_card')
				.attr('maxlength', 17)
				.keydown(function (e) {
				
					var value = $(this).val();
					if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96&&e.keyCode <= 105) ) {
						if( $.inArray(value.length, [1,6,12,15])>=0 ){
							$(this).val( value+"-" )
						}
					}
					else if( e.keyCode==8  ){
						if( $.inArray(value.length, [3,8,14,17])>=0 ){
							$(this).val( value.substr(0,value.length-1) );
						}
					}
					else {
						e.preventDefault();
					}

				});

			self.$elem.find('input#phone_number,input#person-spouse-phone_number')
				.attr('maxlength', 12)
				.keydown(function (e) {

					var value = $(this).val();
					if((e.keyCode>=48&&e.keyCode<=57) || (e.keyCode>=96&&e.keyCode<=105) ) {
						if( $.inArray(value.length, [3,7])>=0 ){
							$(this).val( value+"-" )
						}
					}
					else if( e.keyCode==8  ){
						if( $.inArray(value.length, [5,9])>=0 ){
							$(this).val( value.substr(0,value.length-1) );
						}
					}
					else {
						e.preventDefault();
					}

				});
			

			// 
			self.$elem.find('table.table-full-value').removeClass('table-full-value').parents('table').addClass('table-full-value');
			self.$elem.find('tr.table-address').removeClass('table-address').parents('table').addClass('table-address');

			self.$elem.find('.js-hide').find('input[type=radio]').change(function () {

				var box = $(this).parents('[data-hide-action]');
				var key = box.attr('data-hide-action');
				var value = $(this).val();

				self.$elem.find( '[data-hide-active='+key+']' ).not('.hidden_elem')
					.addClass('hidden_elem')
					.find('input[type=text]').attr('disabled','disabled');


				var active = self.$elem.find( '[data-hide-active='+key+'][data-hide-value='+value+']' );

				if( active.length>0 ){

					active.removeClass( 'hidden_elem' );
					active.find('input[type=text]').removeAttr('disabled');

					if(  active.find('input[type=text]').length >0 ){

						// active.find('input[type=text]').val('');
						active.find('input[type=text]')[0].focus();
					}
					
				}
				
			});

			self.$elem.find( '[data-hide-active].hidden_elem' ).find('input[type=text]').attr('disabled','disabled');


			// js-clone
			$.each( self.$elem.find('.js-clone'), function () {
				self.clone( $(this) );
			});		
		},

		identification_card: function () {
			var self = this;

			var $card = self.$elem.find('input#identification_card');
			if( $card.length==0 ) return;
			var text = $card.val();
			var val = "";
			for (var i = 0; i < text.length; i++) {
				
				if( $.inArray(i, [1,5,10,12])>=0 ){
					val += "-";
				}
				val += text[i];
			};

			$card.val( val );
		},

		phone_number: function () {
			var self = this;

			var $card = self.$elem.find('input#phone_number,input#person-spouse-phone_number');
			if( $card.length==0 ) return;
			var text = $card.val();
			var val = "";
			for (var i = 0; i < text.length; i++) {
				
				if( $.inArray(i, [3,6])>=0 ){
					val += "-";
				}
				val += text[i];
			};

			$card.val( val );
		},

		clone: function( $el ) {
			
			var box = $el.parents('table');
			var $button = $('<a/>', {  text: 'เพิ่ม' });
			var $clone = box;
			var count = $el.attr('data-count') || 0;

			box.replaceWith( $button );
			
			$button.click( function(e){
				e.preventDefault();

				count ++;

				var elem = $clone;
				elem.find('[data-number]').attr('data-number', count).text( count+'.' );
				$button.before( elem );
				$clone = elem.clone();
			});

		}
	};

	$.fn.formInsert = function( options ) {
		return this.each(function() {
			var $this = Object.create( formInsert );
			$this.init( options, this );
			$.data( this, 'formInsert', $this );
		});
	};

	$.fn.formInsert.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );