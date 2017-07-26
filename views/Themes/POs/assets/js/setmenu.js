// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var setmenu = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.setmenu.options, options );
			self.url = Event.URL + 'masseuse/queue';

			$.each(self.options.masseuse,  function(i, obj) {
				console.log( i, obj );
				self.$elem.find('.ui-list-masseuse').append( self.setItemMasseuse( obj ) );
			});

			// Event 
			self.$elem.delegate('[data-control=change][data-type=masseuse]', 'click', function () {
				var parent = $(this).closest('li');

				Dialog.load( Event.URL + 'orders/set_bill', {type: 'masseuse', date: self.options.date, id: $(this).data('id'), job_type: self.options.job_type }, {
					onClose: function () {},
					onSubmit: function ( d ) {

						var $form = d.$pop.find('form');
						var li = $form.find('[ref=tokenbox]').find('[data-id]');
						if( li.length == 1 ){

							parent.replaceWith( self.setItemMasseuse( li.data() ) );
							Dialog.close();
						}
					}
				} );

			});

			self.$elem.delegate('[data-control=change][data-type=remove_masseuse]', 'click', function () {
				$(this).closest('li').remove();
			});

			self.$elem.delegate('[data-control=change][data-type=plus_masseuse]', 'click', function () {
				
				Dialog.load( Event.URL + 'orders/set_bill', {type: 'masseuse', date: self.options.date, job_type: self.options.job_type }, {

					onClose: function () {},
					onSubmit: function ( d ) {

						var $form = d.$pop.find('form');
						var li = $form.find('[ref=tokenbox]').find('[data-id]');
						if( li.length == 1 ){

							self.$elem.find('.ui-list-masseuse').append( self.setItemMasseuse( li.data() ) );
							Dialog.close();
						}
					}

				});
			});

			self.$inputhour = self.$elem.find(':input[data-name=hour]');
			self.$inputtotal = self.$elem.find(':input[data-name=total]');

			self.$elem.find('.js-set-qty').click(function () {

				var type = $(this).data('type');
				var val = parseFloat( self.$inputhour.val() );

				var res = val.toFixed(2).split('.');
				var hours = (parseInt( res[0] ) || 0) * 3600;
				var minutes = (parseInt( res[1] ) || 0) * 60;

				self.$elem.find('inputhour');

				if( type=='plus' ){
					if( self.options.unit == 'hour' ){
						hours += 1800;
					}
					else if( self.options.unit == 'minute' ){
						minutes += self.options.qty*60;
					}
				}
				else{
					if( self.options.unit == 'hour' ){
						hours -= 1800;
					}
					else if( self.options.unit == 'minute' ){
						minutes -= self.options.qty*60;
					}
				}

				var seconds = hours + minutes;

				if( seconds <= 0  ){
					seconds = self.options.unit == 'minute' ? self.options.qty/100 : self.options.qty
				}

				self.$inputhour.val( self.toHHMM(seconds) );

				self.calculate();
			});
			
		},

		toHHMM: function ( sec_num ) {
			// var sec_num = parseInt(this, 10); // don't forget the second param
		    var hours   = Math.floor(sec_num / 3600);
		    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
		    var seconds = sec_num - (hours * 3600) - (minutes * 60);

		    // if (hours   < 10) {hours   = "0"+hours;}
		    if (minutes < 10) {minutes = "0"+minutes;}
		    if (seconds < 10) {seconds = "0"+seconds;}
		    return hours+'.'+minutes; //+':'+seconds;
		},

		calculate: function () {
			var self = this;

			var val = parseFloat( self.$inputhour.val() );
			var res = val.toFixed(2).split('.');
			var hours = parseInt( res[0] );
			var minutes = parseInt( res[1] );

			if( hours==1 && minutes==30  ){
				hours = 2; 
				minutes = 0;
			}

			var price = self.options.price;
			if( self.options.unit=='hour' && hours >= 2 ){
				price -= 50;
			}

			price = hours * price;

			if( self.options.unit=='hour' && hours>=2 && minutes==30 ){
				price += 150;
			}
			else if( self.options.unit == 'minute'  ){
				
			}

			self.$inputtotal.val( price );
		},

		setItemMasseuse: function ( data ) {
			var self = this;

			var image = data.image_url 
				? '<div class="avatar lfloat mrs"><img src="' + data.image_url + '"></div>'
				: '';

			return $('<li>').html(
				'<span class="ui-status mrm">'+ data.icon_text +'</span>' + 

				'<a class="control" data-control="change" data-type="masseuse" data-id="'+ data.id +'">' + image + '<span>'+ data.text +'</span>' +
				'</a>' +
				' <span class="time"></span> '+ 

				' <input type="hidden" name="masseuse['+ data.id +'][id]" value="'+ data.id +'"></span> '+ 
				' <input type="hidden" name="masseuse['+ data.id +'][job]" value="'+ data.job_id +'"></span> '+ 

				'<div class="actions"><span class="gbtn"><button type="button" class="btn btn-no-padding" data-control="change" data-type="masseuse" data-id="'+ data.id +'"><i class="icon-retweet"></i></button></span><span class="gbtn"><button type="button" class="btn btn-no-padding" data-control="change" data-type="plus_masseuse"><i class="icon-plus"></i></button></span><span class="gbtn"><button type="button" class="btn btn-no-padding" data-control="change" data-type="remove_masseuse" data-id="'+ data.id +'"><i class="icon-remove"></i></button></span></div>' 
			);
		}
	};

	$.fn.setmenu = function( options ) {
		return this.each(function() {
			var $this = Object.create( setmenu );
			$this.init( options, this );
			$.data( this, 'setmenu', $this );
		});
	};

	$.fn.setmenu.options = {};
	
})( jQuery, window, document );