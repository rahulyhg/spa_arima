var $body = $('body'),
	$window = $(window),
	$doc = $('#doc'),
	theDate = new Date();


// chooseRooms2
// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var ChooseRooms2 = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.chooseRooms2.options, options );

			self.$elem.find('.js-choose').click(function() {
				
				var val = $(this).data('room');
				var price = parseInt( $(this).data('price') ) || 0;

				self.$elem.find(':input[data-name=room]').val( val );
				self.$elem.find(':input[data-name=price]').val( price / self.options.share );
			});
		}

	}
	$.fn.chooseRooms2 = function( options ) {
		return this.each(function() {
			var $this = Object.create( ChooseRooms2 );
			$this.init( options, this );
			$.data( this, 'chooseRooms2', $this );
		});
	};

	$.fn.chooseRooms2.options = {
		share: 1
	};
	
})( jQuery, window, document );

/*var POs = {
	init: function () {
		
	},

	chooseMenu: function ( id ) {
		var self = this;

		self.loadMenu( {
			date: PHP.dateJStoPHP( currOrder.date ),
			type: 'package',
			id: id
		} ).done(function ( data ) {

			self.updateMenu(data);	
		});
	},
	loadMenu: function ( formData ) {
		
		return $.ajax({
			// type: "GET",
			url:  Event.URL + 'orders/menu',
			data: formData,
			dataType: 'json',
		}).always(function() { // complete
			Event.hideMsg();
		}).fail(function(  ) { // error
			Event.showMsg({ text: "เกิดข้อผิดพลาด...", load: true , auto: true });
		});
	},

	updateMenu: function (data) {
		console.log( data );
		
	}
}*/


$(function () {

	/*$('[data-global=date]').datepicker({
		onComplete: function ( date ) {
			theDate = new Date( date );
			bill.setData({});
		},
		onSelected: function ( date ) {
			currOrder.date = new Date( date );
			bill.update();
		}
	});*/

	$('.js-navigation-trigger').click(function () {

		if( !$('body').hasClass('is-pushed-left') ){

			var scroll = $(window).scrollTop()*-1;
			$doc.addClass('fixed_elem').css('top', scroll);

			setTimeout(function () {
				$('body').addClass('is-pushed-left');
			},200);
		}
		else{
			
			var scroll = parseInt( $doc.css("top"));
				scroll = scroll<0 ? scroll*-1:scroll;

			$('body').removeClass('is-pushed-left');

			$doc.removeClass('fixed_elem').css('top', "");
			$(window).scrollTop( scroll );

		}
	});


	$('.settingsListLink').click( function () {
		
		var $parent = $(this).parent();
		if( $parent.hasClass('openPanel') ){
			$parent.removeClass('openPanel');
		}
		else{
			$parent.addClass('openPanel').siblings().removeClass('openPanel');
		}
	} );
});


