// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var Postss = {
		init: function(options, elem) {
			var self = this;
			
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.posts.options, options );
			
			self.media = {};

			self.has_loading = false;

			self.setElem();
			self.refresh( 1 );

			if( self.$elem.find('.post-form') ){
				self.setForm();
			}
			
			self.Events();
			
			// console.log( self.options  );
		},

		setElem: function () {
			var self = this;

			// self.$listboxWrap = 
		},

		refresh: function ( length ) {
			var self = this;

			self.$elem.addClass('has-loading');
			if( self.$elem.hasClass('has-empty') ){
				self.$elem.removeClass('has-empty');
			}

			setTimeout(function () {
				
				self.fetch().done(function( results ) {

					if( results.error ){

						self.$elem.addClass('has-empty');
						if( results.message ){
							self.$elem.find('.empty-text').text( results.message );
						}
						return false;
					}

					self.options = $.extend( {}, self.options, results.options );
					self.buildFrag( results );
				});

			}, length || 800);
		},
		fetch: function () {
			var self = this;

			return $.ajax({
				url: self.options.load,
				data: self.options,
				dataType: 'json'
			})
			.always(function() {
				self.$elem.removeClass('has-loading');
			})
			.fail(function() {

				self.$elem.find('.empty-text').text('เกิดข้อผิดพลาด!');
				self.$elem.addClass('has-empty');
			});	
		},

		buildFrag: function ( results ) {
			var self = this;

			for (var i = results.lists.length - 1; i >= 0; i--) {
				self.display( self.setPost( results.lists[i] ) );
			}
		},
		setPost: function ( data ) {
			var self = this;
			var post = $('<div>', {class: 'post', 'data-id': data.id});

			if( data.title ){
				post.append( $('<div>', {class: 'post-title'}).text( data.title ) );
			}

			if( data.text ){
				post.append( $('<div>', {class: 'post-body'}).html( data.text ) );
			}

			if( data.icon ){
				post.append( $('<div>', {class: 'post-icon'}).html( data.icon ) );
			}

			var actions = $('<div>', {class: 'post-actions'});

			var cog = $('<a>', {class: 'cog', 'js-plugins': 'dropdown'});
			actions.append( cog.html( $('<i>', {class: 'icon-angle-down'}) ) );
			post.append( actions );

			var meta = $('<div>', {class: 'post-meta'});
			if( data.poster ){
				meta.append( $('<span>').append( 
					  $('<span>', {class: 'icon-user mrs'})
					, data.poster
				) );
			}
			if( data.date ){
				meta.append( $('<span>').append( 
					  $('<span>', {class: 'icon-clock-o mrs'})
					, data.date
				) );
			}

			post.append( meta );

			return post;
		},
		display: function ( $post ) {
			var self = this;


			if( self.$elem.find('>.post-form').length==1 ){
				
				self.$elem.find('>.post-form').after( $post );
			}
			else if( self.$elem.find('>.post').length==0 ){
				self.$elem.append( $post );
			}
			else{
				self.$elem.find('>.post').first().before( $post );
			}

			Event.plugins( $post );

			$post.find('.cog').dropdown({
				select: self.options.actions,
				settings: $.extend( {}, $.fn.posts.settings, self.options.settings || {} ),
				onChange: function ( $el ) {
					
					if( $el.data('type')=='edit' ){
						self.editPost( $post );
					}

					if( $el.data('type')=='remove' ){
						self.delPost( $post );
						
					}
					
				},
			});

			// 'data-options': JSON.stringify( dropdown )
		},

		Events: function () {
			var self = this;

			self._focus = false;
			self.$elem.delegate('.post','click', function () {
				$(this).addClass('is-focus').siblings().removeClass('is-focus');
			});

			self.$elem.delegate('.post','mouseenter', function () {
				self._focus = true;
			});

			self.$elem.delegate('.post','mouseleave', function () {
				self._focus = false;
			});

			$('html').on('click', function() {	
				
				if( !self._focus ){
					self.$elem.find('.post.is-focus').removeClass('is-focus');
				}
			});


			/*self.$elem.delegate('.js-del-post','click', function (e) {
				e.preventDefault();


			});*/
			
		},

		setForm: function() {
			var self = this;

			self.$form = self.$elem.find('form.post-form');

			// event
			self.$form.submit(function (e) {
				e.preventDefault();

				self.$form.addClass('has-loading');

				Event.inlineSubmit( self.$form ).done(function( result ) {

					result.url = '';
					Event.processForm(self.$form, result);
					self.display( self.setPost(result.data) );

					self.$form.removeClass('has-loading');
					self.$form.find(':input.js-input').val('');
				});
				
			});
		},

		editPost: function ( $post ) {
			var self = this;

			if( !self.options.edit_post_url ) return false;

			Dialog.load( self.options.edit_post_url, {id: $post.data('id'), callback: 1}, {
				onSubmit: function ( d ) {
						
					var $form = d.$pop.find('form.js-submit-form');

					Event.inlineSubmit( $form ).done(function( result ) {

						result.url = '';
						Event.processForm($form, result);

						$post.find('.post-body').html( result.text );							
					});
				}
			} );

		},

		delPost: function ( $post ) {
			var self = this;

			if( !self.options.del_post_url ) return false;

			Dialog.load( self.options.del_post_url, {id: $post.data('id'), callback: 1}, {
				onSubmit: function ( d ) {
						
					var $form = d.$pop.find('form.js-submit-form');

					Event.inlineSubmit( $form ).done(function( result ) {

						result.url = '';
						Event.processForm($form, result);

						$post.remove();							
					});
				}
			} );
		}

	}

	$.fn.posts = function( options ) {
		return this.each(function() {
			var $this = Object.create( Postss );
			$this.init( options, this );
			$.data( this, 'posts', $this );
		});
	};

	$.fn.posts.settings = {};

	$.fn.posts.options = {
		actions: {},
		pages: 1,
	};
	
})( jQuery, window, document );