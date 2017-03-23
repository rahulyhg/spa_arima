// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Grid = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.grid.options, options );

			self.url = URL+ 'tours/search';
			self.data = {};

			self.refresh( 1 );

			self.$elem.find('.js-switcher').click(function () {
				
				if( $(this).hasClass('active') ) return false;

				var type = $(this).data('switcher');
				self.$elem.find('.grid-wrap').toggleClass('count-3', type=='grid'? true:false );

				$(this).addClass('active').siblings().removeClass('active');
			});

			self.$elem.find(':input').change(function() {
				self.is_change = true;
				self.refresh( 1 );
			});
		},

		refresh: function ( length ) {
			var self = this;
			self.fetch().done(function( results ) {

				if( !results || results.total==0 ){

					self.error();
					// return false;
				}

				self.$elem.find('.total-text').text( results.total );
				self.buildFrag( results.lists );
				self.display();
			});
		},

		fetch: function() {
			var self = this;

			var postData = {};

			$.each( self.$elem.find(':input'), function (i, obj) {

				var name = $(obj).attr('name');
				var val = $(obj).val();
				if( name == 'sort' ){
					val = val.split('&');

					postData['sort'] = val[0];
					postData['dir'] = val[1];

				}
				else{
					postData[name] = val;
				}
				
			} );

			if( self.$elem.hasClass('has-error') ){
				self.$elem.removeClass('has-error')
			}

			self.$elem.addClass('has-loading');
			return $.ajax({
				url: self.url,
				data: postData,
				dataType: 'json'
			}).always(function () {
				self.$elem.removeClass('has-loading');
			}).fail(function() { 
				self.error();
			});
		},

		buildFrag: function ( results ) {
			var self = this;

			self.$item = $.map(results, function (obj) {
				
				return self.setItem( obj )[0];
			});

		},
		setItem: function (data) {
			
			var li = $('<div>', {class: 'item'}).html(
				$('<div>', {class: 'inner'}).append(
					$('<figure>').html( 
						$('<a>', {href: data.url, class: 'img'}).css({
							backgroundImage: ' url('+data.image_cover_url+')'
						})
					)
					, ( data.code 
						? $('<div>', {class: 'code', text: data.code})
						: ''
					)
					, $('<div>', {class: 'mask'}).append(
						$('<h3>', {class: 'title'}).append(
							$('<a>', {href: data.url}).text( data.name )
							// , $('<span>', )
						)
						, $('<div>', {class: 'content'}).append(
							$('<ul>', {class: 'meta'}).append(
								$('<li>').append(
									$('<i>', {class: 'icon-clock-o mrs'})
									, data.days_str
								)
								, $('<li>').append(
									$('<i>', {class: 'icon-caret-square-o-right mrs mrs'})
									, PHP.number_format(data.price)
								)
								, $('<li>').append( 
									$('<i>', {class: 'icon-file-text-o mrs mrs'})
									, $('<a>', {text: 'Download'})
								)
							)
						)
						, $('<div>', {class: 'more'}).append(
							$('<a>', {href: data.url, class: 'btn btn-primary btn-block'}).text('Read More')
						)
					)
				)
			);

			return li;
		},
		display: function () {
			var self = this;

			if( self.is_change ){
				self.is_change = false;
				self.$elem.find('[role=listsbox]').empty();
			}
			// console.log( self.$item );
			self.$elem.find('[role=listsbox]').append( self.$item );
		},

		error: function () {
			var self = this;

			self.$elem.addClass('has-error');
		}
	};

	$.fn.grid = function( options ) {
		return this.each(function() {
			var $this = Object.create( Grid );
			$this.init( options, this );
			$.data( this, 'grid', $this );
		});
	};

	$.fn.grid.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );