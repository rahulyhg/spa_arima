// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var SetQueue = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.setqueue.options, options );

			self.url = Event.URL + 'masseuse/queue';

			self.$elem.find('[data-name=date]').datepicker({
				onComplete: function ( d ) {

					self.options.date = PHP.dateJStoPHP(d);
					self.refresh();
				},
				onChange: function ( d ) {
					self.options.date = PHP.dateJStoPHP(d);
					self.refresh();
				}
			});

			self.$inputqueue = self.$elem.find(':input[act=inputqueue]');


			// Event
			self.$elem.find('[data-ref]').sortable({
				stop: function (event, ui) {

					self.sort( $(ui.item).parent().data('ref') );
				}
			});

			self.$inputqueue.keypress(function(e) {
			    if(e.which == 13) {
			        self.clocking();
			    }
			});

			self.$elem.find('.btn-checkin').click(function () {
				self.clocking();
			});

			self.$elem.find('[data-ref]').sortable({
				stop: function (event, ui) {

					self.sort( $(ui.item).parent().data('ref') );
				}
			});


			self.$elem.find('[data-ref]').delegate('[data-id]', 'click',function () {
				
				self.card( $(this).data('id') );
			});
		},

		clocking: function () {
			var self = this;

			var val = $.trim( self.$inputqueue.val() );

			if( val == '' ){
				self.$inputqueue.focus();
				return false;
			}

			self.$inputqueue.addClass('disabled').prop('disabled', true);
			$.get( Event.URL + 'masseuse/clocking', { date: self.options.date, code: val }, function ( res ) {
				
				self.$inputqueue.removeClass('disabled').prop('disabled', false).val('').focus();

				if( res.message ){
					Event.showMsg( {text: res.message, load: 1, auto: 1} );
				}

				if( res.error ){
					return false;
				}

				self.$elem.find('[data-ref='+ res.data.type +']').append( self.setItem( res.data ) );
				

			}, 'json');
		},

		sort: function ( type ) {
			var self = this;

			var ids = [];
			$.each(self.$elem.find('[data-ref='+ type +'] [data-id]'), function() {

				ids.push( $(this).data('job') );
			});

			if( ids.length < 2 ) return false;
			$.post( Event.URL + 'masseuse/queue_sort', {ids: ids, type: type, date: self.options.date});
		},

		refresh: function ( date ) {
			var self = this;

			self.$elem.find('[data-ref]').empty();
			setTimeout(function () {

				self.fetch().done(function ( data ) {
					self.buildFrag( data );
				});

			}, 1);
		},
		fetch: function () {
			var self = this;

			return $.ajax({
				url: self.url,
				data: self.options,
				dataType: 'json'
			}).fail(function() {
				
			}).always(function() {
							
			});
		},
		buildFrag: function( results ) {
			var self = this;
			$.each(results.lists, function ( i, obj ) {

				self.$elem.find('[data-ref='+ obj.type +']').append( self.setItem( obj ) );
			});
		},
		setItem: function (data) {
			var self = this;

			var avatar = $('<div>', {class: 'avatar'});

			if( data.image_url ){
				avatar.html( $('<img>', {class: 'img', src: data.image_url}) );
			}
			else{
				avatar.addClass('no-avatar').html( $('<div>', {class: 'initials'}).text( data.code ) )
			}

			var li = $('<li>', {'data-id': data.id, 'data-job': data.job_id}).html(
				$('<li>', {class: 'inner'}).append(
					  $('<div>', {class: 'number'}).text( data.code )
					, $('<div>', {class: 'box'}).append( 
						$('<div>', {class: 'box-inner'}).append( 
							avatar, $('<div>', {class: ''}).text( data.text ) 
						) 
					)
				)
			);
			li.data( data );

			return li;
		},

		card: function (id) {
			var self = this;

			Dialog.load( Event.URL + 'masseuse/queue_card',{id: id, date: self.options.date}, {
				onClose: function () { },
				onOpen: function ( d ) {

					d.$pop.find('.js-del').click(function(event) {
						
						var url = $(this).attr('ajaxify');

						var r = confirm("ยืนยันการลบ!");

						if (r == true) {
						    txt = "You pressed OK!";

						    $.post( url, {id: id, date: self.options.date }, function(result) {

						    	var item = self.$elem.find('[data-ref] [data-id='+ id +']');
						    	Event.showMsg({text: result.message, auto: 1, load: 1});
						    	self.sort( item.parent().data('ref') );
						    	item.remove();

						    	Dialog.close();

						    }, 'json');
						}

						/*Dialog.load( url, {}, {
							onClose: function () {},
							onSubmit: function ( di ) {

								var $form = di.$pop.find('form');

								Event.inlineSubmit( $form ).done(function( result ) {

									self.$elem.find('[data-ref] [data-job='+ result.data.job_id +']').remove();
									Event.processForm($form, result);
									Dialog.close();

									self.sort( result.data.type );
								});
								
							},
						});*/
					});
					
				}
			});
		}
	};

	$.fn.setqueue = function( options ) {
		return this.each(function() {
			var $this = Object.create( SetQueue );
			$this.init( options, this );
			$.data( this, 'setqueue', $this );
		});
	};

	$.fn.setqueue.options = {};
	
})( jQuery, window, document );