// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Shop = {
		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;
			self.$elem = $(self.elem);

			self.options = $.extend( {}, $.fn.shop.options, options );
			self.data = {};

			// self.setElem();

			self.resize();
			$window.resize(function () {
				self.resize();
			});

			self.scroll();
			$window.scroll(function () {
				self.scroll();
			});

			self.is_more = false;
			self.Events();

			self.refresh(1);
		},
		setElem: function () {
			var self = this;
			self.$elem = $(self.elem);
			self.$elem.attr('id', 'shopContainer')
			self.$elem.find('[role]').each(function () {
				if( $(this).attr('role') ){
					var role = "$" + $(this).attr('role');
					self[role] = $(this);
				}
				
			});
		},
		resize: function () {
			var self = this,
				currentHeight = $(window).height();

			// $('#localnav-wrapper').toggleClass('fixed_elem', currentHeight>self.options.minHeigth ? true:false);

			// $('.shop-sidebar-wrapper').addClass('fixed_elem');
			self.sidebarTop = $('#shop-steam').offset().top-94;
			
		},
		scroll: function () {
			var self = this;

			if( $(window).scrollTop() >= self.sidebarTop ){
				$('.shop-sidebar-wrapper').css('top', 94).addClass('fixed_elem');
			}
			else{
				$('.shop-sidebar-wrapper').css('top',0).removeClass('fixed_elem');
			}
			
		},
		scrollTop: function () {
			var self = this;

			if( $(window).scrollTop()>116 ){
				$('html, body').animate({ scrollTop: 116 });
			}
			
		},

		Events: function () {
			var self = this;

			self.c_store();
			self.$elem.find('.shop-header #store-id').change(function () {
				self.c_store( $(this).val() );

				self.$elem.find('.shop-sidebar>li input[type=checkbox]').prop( "checked", false );

				self.data.options = null;

				self.scrollTop();
				self.refresh( 1 );
			});

			self.$elem.find('.shop-sidebar>li>.checkbox>input[type=checkbox]').change(function () {

				var li = $(this).closest('li');

				if( $(this).is(':checked') ){
					li.addClass('active');

					li.find('input[type=checkbox]').prop( "checked", true );
				}
				else{
					li.find('input[type=checkbox]').prop( "checked", false );
				}

				self.data.options = null;
				self.scrollTop();
				self.refresh( 1 );

				
			});

			self.$elem.find('.shop-sidebar .shop-sub-sidebar .checkbox>input[type=checkbox]').change(function () {

				var ul = $(this).closest('ul');
				if( ul.find('input[type=checkbox]:checked').length == 0 ){
					ul.closest('li').find('input[type=checkbox]').prop( "checked", false );
				}

				self.data.options = null;
				self.scrollTop();
				self.refresh( 1 );
			});

			self.$elem.find('.shop-sidebar>li .maximized').click(function (e) {

				var li = $(this).closest('li');

				li.toggleClass('active', !li.hasClass('active') );
				
				e.preventDefault();
			});


			$('.js-link-more', self.$elem).click(function (e) {

				if( self.data.options.more ){

					self.is_more = true;
					self.data.options.pager++;
					self.refresh( 1 );
				}
				e.preventDefault();
			});
			
		},
		c_store: function ( length ) {
			var self = this;

			var id = length || self.$elem.find('.shop-header #store-id').val();
			var ol = self.$elem.find('.shop-steam #store-'+id);

			// $(this).addClass('active').siblings().removeClass('active');

			// $( $(this).attr('id') ).addClass('active').siblings('li').removeClass('active');

			self.$elem.find('.shop-steam #store-'+id).addClass('active').siblings().removeClass('active');
		},

		refresh: function ( length ) {
			var self = this;

			clearTimeout( self.timeout );

			var q = setTimeout(function () {
				self.$elem.addClass('has-loading');
			}, 3000);
			
			self.timeout = setTimeout(function () {
				
				self.fetch().done(function ( data ) {
					
					clearTimeout( q );
					self.data.options = $.extend( {}, self.data.options, data.options );

					self.buildFrag(data.lists);
					self.display();
				});
				
				/*if ( self.options.refresh ) {
					self.refresh();
				}*/
				
            }, length || self.options.refresh );
		},

		fetch: function (){
			var self = this;

			if( !self.data.options ){
				self.data.options = self.$elem.serializeArray();
			}

			return $.ajax({
				url: self.options.load_url,
				data: self.data.options,
				dataType: 'json'
			}).always(function () {
				self.$elem.removeClass('has-loading');
			}).fail(function() { 

			});

		},

		buildFrag: function ( results ) {
			var self = this;

			self.item = $.map(results, function (obj, i) {
				return self.setItem( obj );
			});
		},

		display: function ( more ) {
			var self = this;

			if( more || self.is_more ){
				self.$elem.find('.productgrid>ul').append( self.item );
			}
			else{
				self.$elem.find('.productgrid>ul').html( self.item );
			}


			$.each( self.$elem.find('.productgrid>ul>li'), function (i) {
				
				$(this).toggleClass('has-top', i<3);

				// console.log( i%3 );
				$(this).toggleClass('has-left', i%3==0? true: false);
			} );			

			if( self.data.options.more ){
				self.$elem.addClass('has-more');
			}
			else{
				self.$elem.removeClass('has-more');
			}

		},

		setItem: function ( data ) {
			var self = this;
			// console.log( data );

			return $('<li>', {id: 'item-'+data.item_id }).append(

				//  image
				$( '<div>', {class: 'pic-wrapper'} ).append(
					$( '<a>', {href: data.url, class: 'pic'} ).html(
						$( '<span>', {class: 'active'} ).html(
							$( '<img>', {class: 'img', src: data.image_cover_url, alt: data.name} )
						)
					)

					// color
					/*, $( '<div>', { class: 'color-wrapper'} ).html(
						$( '<div>', { class: 'color'} ).append(
							$( '<span>', { class: 'active'} ).css('background-color': '#8b1d26')
						)
					)*/
				)

				// article
				, $( '<div>', {class: 'article'} ).append(

					// title
					$( '<a>', {href: data.url, class: 'title'} ).append(
						$( '<strong>', {text: data.code} )
						, data.name
					)

					, $( '<ul>', {class: 'featured'} ).append(
						  $( '<li>' ).append( 
							$('<strong>', {text: 'weight'}), " : ", data.weight ,' kg'
						)
						, $( '<li>' ).append( 
							$('<strong>', {text: 'size'}), " : ", data.size ,' mm' 
						)
					)

					// price
					/*, $( '<div>', {class: 'price'} ).append(
						  $( '<span>', {class: 'old', text: ''} )
						, $( '<span>', {class: 'new', text: ''} )
					)*/

					// actions
					/*, $( '<div>', {class: 'actions'} ).append(
						  $( '<a>', {class: 'btn btn-blue', text: ''} )
						, $( '<a>', {class: 'btn btn-link', text: ''} )
					)*/
				)

				/*, $( '<div>', {class: 'control'} ).append(
					$( '<a>', {class: 'btn-icon'} ).append( 
						  $('<i>', {class: 'icon-share-alt'})
						, $('<span>', {text: 'share'})
					)
				)*/
				

			);
		}


	};

	$.fn.shop = function( options ) {
		return this.each(function() {
			var $this = Object.create( Shop );
			$this.init( options, this );
			$.data( this, 'shop', $this );
		});
	};

	$.fn.shop.options = {
		refresh: 13000,
		minHeigth: 400,
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );