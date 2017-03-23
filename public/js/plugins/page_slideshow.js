// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var PageSlideshow = {
		init: function(options, elem) {
			var self = this;
			self.$elem = $(elem);

			self.options = $.extend( {}, $.fn.page_slideshow.options, options );
			self.$listsbox = self.$elem.find('[role=listsbox]');

			self.url = URL + 'uploadx/set_slideshow';

			if( self.options.lists.length == 0 ){
				self.addItem({});
			}
			else{
				$.each( self.options.lists, function (i, obj) {

					console.log( obj );
					self.addItem( obj );
				});
			}


			self.$elem.delegate('.choosefile', 'click', function () {
				
				var $choosefile = $(this);
				if( $choosefile.hasClass('has-loading') ) return false;
				
				$choosefile.addClass('has-loading');
				var $input = $('<input type="file" />');
				$input.attr('accept', 'image/*' );
				// $input.attr('multiple', self.options.multiple);
				$input.trigger('click', function (e) {
					// console.log( '1' );
				}).blur(function () {
					// console.log( 'blur' );
				});

				var $item = $(this).parent();

				$input.change(function () {
					$choosefile.removeClass('has-loading');
					self.setImage(this.files[0], $item);
					$(this).val("");
				});
			});

			self.$elem.find('.js-add').click(function () {
				self.addItem({});
			});


			self.$elem.delegate('.js-del', 'click', function () {

				var $item = $(this).closest('.upload-gallery-lists-item');
				var data = $item.data();

				Dialog.open({

					title: 'ยืนยันการลบรูป',
					body: 'คุณต้องการลบรูปภาพนี้หรือไม่!?',

					button: '<button role="submit" class="btn btn-red">ลบ</button>',

					onSubmit: function () {
						
						Event.showMsg({ load:true });

						$.post( URL + 'pages/delOption', {
							id: data.id || data.option_id,
							section_id: self.options.data_post.id
						}, function () {
							
							Event.showMsg({ text:'ลบรูปแล้ว',load:true, auto: true });

							$item.remove();
							// self.updateItem( $item, {} );
							// $item.removeClass('has-file');

							Dialog.close();
						}, 'json');
					}
				});
			});

			self.$elem.delegate('.js-input', 'change', function () {
				var $item = $(this).closest('.upload-gallery-lists-item');

				$item.find('.js-save').prop('disabled', false).removeClass('disabled');
			});

			self.$elem.delegate('.js-save', 'click', function () {

				if( $(this).hasClass('disabled') ) return false;

				var $item = $(this).closest('.upload-gallery-lists-item');

				var data = $item.data();

				var postData = {
					id: data.id || data.option_id
				};

				$.each($item.find(':input.js-input'), function () {
					if( $(this).attr('name') ){					
						postData[ $(this).attr('name') ] = $.trim($(this).val());
					}
				});

				// $item.data();
				Event.showMsg({ load:true });
				$.post( URL + 'pages/setOptionValue', postData, function (res) {
					
					Event.showMsg({ text:'บันทึกแล้ว',load:true, auto: true });
					self.updateItem( $item, $.extend( {}, data, res ) );
					$item.find('.js-save').prop('disabled', true).addClass('disabled');
				}, 'json');
			});
		},

		addItem: function ( data ) {
			var self  = this;

			self.$listsbox.append( self.setItem(data) );
		},

		setItem: function ( data ) {
			var self = this;
			var $pic = $( '<div>', {class: 'picture'} );

			var options = data.options || {};


			var li = $( '<div>', {class: 'upload-gallery-lists-item'} ).append(
				$( '<div>', {class: 'choosefile'} ).append(
					$( '<div>', {class: 'text fwb', text: 'เลือกไฟล์'} ),
					$( '<div>', {class: 'load fwb', text: 'Loading...'} )
				),

				$( '<div>', {class: 'item-content clearfix'} ).append(
					  $pic
					, $( '<div>', {class: 'caption'} ).append(

						$( '<input>', {class: 'inputtext js-input', placeholder:"Title", name: 'title'} ).val( options.title )

						, $( '<textarea>', {class: 'inputtext inputCaption js-input', placeholder:"คำบรรยายภาพ", name: 'text'} ).text( options.text )

						, $( '<input>', {class: 'inputtext js-input', placeholder:"Link", name: 'link'} ).val( options.link )

						, $( '<div>', {class: 'clearfix mts'} ).append(
							$( '<button>', {tyle: 'button', class: 'btn btn-small btn-red js-del', text: 'ลบ'} )
							, $( '<button>', {tyle: 'button', class: 'btn btn-small btn-blue rfloat disabled js-save', text: 'บันทึก', 'disabled': true} )
						)


					)
				),


				$( '<div>', {class: 'progress-bar'} ).append( $('<span>', {class: 'bar blue'}) )
				
			);
			
			if( data.image_url ){

				var img = new Image();
				img.src = data.image_url;
				img.onload = function () {
				  	var width = self.options.scaledX;
					var height = ( this.height * width ) / this.width;
					
					$pic.css({ width: width, height: height });

				  	li.addClass( 'has-file' );
				  	$pic.html( img );
				}
				
			}

			li.data( data );

	        return li;
		},

		setImage: function (file, $el) {
			var self = this;

			$el.addClass('has-loading');
			var $pic = $el.find('.picture');

			setTimeout(function () {
				self.fetch( file, $el ).done(function( results ) {

					if( results.error ){

						Event.showMsg({ text: results.error ,load:true, auto: true, bg: 'red' });
						return false;
					}

					var image = new Image();
					image.src = results.url;
					var $image = $(image).addClass('img');

					image.onload = function() {
						
						var width = self.options.scaledX;
						var height = ( this.height * width ) / this.width;
						
						$pic.css({ width: width, height: height });

						$el.data('id', results.id);
						$el.data('url', results.url);

						$el.addClass('has-file');
						$pic.html( $image );
						// self.cropperImage( self.$elem.find('.preview') );
					}


				});
				
			}, 1 );	
		},

		fetch: function ( file, $el ) {
			var self = this;

			var $progress = $el.find('.progress-bar');

			var formData = new FormData();
			formData.append('file1', file);

			$.each( self.options.data_post, function (name,value) {
				formData.append(name, value);
			} );

			return $.ajax({
				xhr: function(){
			    	var xhr = new window.XMLHttpRequest();
				    //Upload progress
				    xhr.upload.addEventListener("progress", function(evt){
				      if (evt.lengthComputable) {
				        // var percentComplete = evt.loaded / evt.total;
				        var progress = parseInt( ((evt.loaded / evt.total) * 100), 10 );
				        //Do something with upload progress
				        $progress.find('.bar').width( progress+"%" );
				      }
				    }, false);
			    	return xhr;
			  	},
                url: self.url,
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false
			})
			.always(function() {
				$el.removeClass('has-loading');
			})
			.fail(function() {

				self.alert({
					title: 'เกิดข้อผิดพลาด!', 
					text: 'ไม่สามารถเชื่อมกับลิงก์ได้'
				});
			});
		},

		alert: function () {
			
		},


		updateItem: function () {
			
		},
	}

	$.fn.page_slideshow = function( options ) {
		return this.each(function() {
			var $this = Object.create( PageSlideshow );
			$this.init( options, this );
			$.data( this, 'page_slideshow', $this );
		});
	};

	$.fn.page_slideshow.options = {
		lists: []
	};
	
	
})( jQuery, window, document );