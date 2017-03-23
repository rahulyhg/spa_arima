// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var EditablePhoto = {
		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;

			self.options = $.extend( {}, $.fn.EditablePhoto.options, options );

			self.setElem();
			
			self.refresh(1);

			self.events();
		},

		setElem: function () {
			var self = this;

			self.$elem = $(self.elem);


			self.$elem.find("[role]").each(function () {
				
				var name = "$" + $(this).attr('role');
				self[name] = $(this);
			});
		},
		refresh: function ( lenght ) {
			var self = this;

			setTimeout(function () {
				self.fetch().done(function( results ) {

					self.buildFragImage( results );
				});
				
			}, lenght || self.options.refresh);	
		},
		fetch: function(){
			var self = this;

			if( self.$elem.hasClass('has-error') ){
				self.$elem.removeClass('has-error');
			}

			if( self.$elem.hasClass('has-data') ){
				self.$elem.removeClass('has-data');
			}

			self.$elem.addClass('has-loading');

			return $.ajax({
				// type: 'POST',
				url: self.options.url,
				// data: self.options.data,
				dataType: 'json'
			})
			.always(function() {
				self.$elem.removeClass('has-loading');
			})
			.fail(function() {

				self.alert({
					title: 'เกิดข้อผิดพลาด!', 
					text: 'ไม่สามารถเชื่อมกับลิงก์ได้'
				});
			});
		},
		alert: function ( obj ) {
			var self = this;

			self.$empty.empty();
			if( typeof someVar === 'string' ) {
			    self.$empty.append( $('<div>', {class: 'text', text: obj }) );
			}
			else{

				$.each( obj, function (cal, txt) {
					
					self.$empty.append( $('<div>', {class: cal, text: txt }) );
				} );
				
			}
			
			self.$elem.addClass('has-error');
		},
		buildFragImage: function ( results ) {
			var self = this;

			if( self.is_upload ){ self.$upload.addClass('disabled'); }
			
			self.$elem.addClass('has-data');
			// console.log( 'data', results );
			$.each(results, function ( i, file ) {
				

				var is_upload = file.url ? true: false;

				var $item = self.editablePhoto();
				self.displayImage( $item, is_upload);

				if( !is_upload ){
					self.upload( $item, file );
				}
				else{

					$item.find('.textCaption').html( file.caption );
					$item.data( file );
					self.display( $item );
					// console.log( file.url );
					// $item.data( file );
				}
			});
		},
		editablePhoto: function(){
			var self = this;
			return $('<div/>', {class: 'uiEditablePhoto has-loading'})
				.append( 
					$('<div/>', {class: 'photoWrap'}).css({
						width: self.options.width,
						height: self.options.height
					}).append( 
						self.editablePhotoProgress(),
						self.editablePhotoError(),
						$('<div/>', {class: 'scaledImageContainer scaledImage'})
					),
					self.editablePhotoCaption(), 
					self.editablePhotoControls()
				);
		},
		editablePhotoError: function () {
			return $('<div/>').addClass('empty-error')
				.append( $('<span/>')
					.addClass('empty-title') 
					.append( $('<span/>') )
				)
				.append( $('<div/>')
					.addClass('empty-message')
				);
		},
		editablePhotoProgress: function(){
			var self = this;

			return $('<div/>').addClass('progress-bar medium')
				.append( $('<span/>')
					.addClass('bar blue') 
					.append( $('<span/>') )
				)
				.append( $('<div/>')
					.addClass('text') 
					.append( uiElem.loader() )
				);
		},
		editablePhotoCaption: function(){

			return $('<div/>', {class: 'inputs'})
				.append( $('<div/>')
					.addClass('captionArea')
					.append( $('<div/>')
						.addClass('uiTypeahead') 
						.append( $('<textarea/>')
							.addClass('uiTextareaNoResize textInput textCaption') 
							.attr({
								title: "เขียนคำบรรยายรูปภาพ...",
								name: 'caption_text',
								placeholder: "เขียนคำบรรยายรูปภาพ",
							})
							
						)
						
					)
				
				);
		},
		editablePhotoControls: function(){

			return $('<div/>').addClass('controls').append( 
				$('<a/>', {class: 'control refresh'}).html( 
					$('<i/>', {class: 'icon-refresh', title: 'ปรับภาพ'})
				)
				, $('<a/>', {class: 'control remove'}).html(
					$('<i/>', {class: 'icon-trash', title: 'ลบออก'})
				)
				/*, $('<a/>', {class: 'control checked'}).html(
					$('<i/>', {class: 'icon-check', title: 'เลือก'})
				)*/
			);
		},

		displayImage: function ( item, isUpdate ) {
			var self = this;
			
			// self.$listsbox.append( item );
			// console.log( item.data() );

			if( isUpdate || self.$listsbox.find('.uiEditablePhoto').length==0 ){
				self.$listsbox.append( item );
			}
			else{
				self.$listsbox.find('.uiEditablePhoto').first().before( item );
			}

			// self.display();
			// 
			// self.loadImageUrl(item, data.url, data.photo_id);	
		},
		events: function () {
			var self = this;

			self.$upload.click(function (e) {
				e.preventDefault();

				var $input = $('<input/>', { type: 'file', accept: "image/*", multiple:''});
				$input.trigger('click')

				$input.change(function(){

					self.is_upload = true;
					self.buildFragImage( this.files );
				});

			});

			self.$elem.delegate('.control.refresh', 'click', function (e) {

				var item = $(this).parents('.uiEditablePhoto');
				var data = item.data();
				// var $img = $(this).parents('.uiEditablePhoto').find('.img');
				// console.log(  );
				Dialog.open({
					title: 'ปรับภาพ',
					form: '<form class="form-cropimage"></form>',
					body: '<div class="img-preveiw"></div>',
					onOpen: function ( response ) { 

						self.$imageCropper = $('<img>', {src: data.url_o});
						response.$dialog.find('.img-preveiw').html( self.setCropimage() );
						item.addClass('has-loading');
						self.cropperPreveiw( item );
					},

					onClose: function () {
						// console.log( 'close' );
						item.removeClass('has-loading');
					},

					onSubmit: function (form) {
						
						self.updateImage( item, form.$pop.find('form').serializeArray() );
						Dialog.close();
					},

					bottom_msg: '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>',
					button: '<button type="submit" class="btn btn-blue btn-submit" role="submit"><span class="btn-text">บันทึก</span></button>'
				});
			});

			self.$elem.delegate('.control.remove', 'click', function (e) {
				var item = $(this).parents('.uiEditablePhoto');
				var data = item.data();
				var url = URL + 'product/del_caption_out_product/'+data.id;
				item.addClass('has-loading');

				Dialog.open({
					title: 'ลบ',
					body: 'ยืนยันการลบรูปนี้?',
					bottom_msg: '<a class="btn" role="dialog-close"><span class="btn-text">ยกเลิก</span></a>',
					button: '<button type="submit" class="btn btn-red btn-submit" role="submit"><span class="btn-text">ลบ</span></button>',

					onClose: function(){
						item.removeClass('has-loading');
					},
					onSubmit: function(){

						$.ajax({
						    type: 'POST',
						    dataType: 'json',
						    url: url,
						}).done(function() {
							item.remove();
							self.resize();
							Dialog.close();
						}).fail(function() {
						    // alert( "error" );
						}).always(function() {
						    item.removeClass('has-loading');
						});

					}
				});
			});

			self.$elem.delegate('.control.checked', 'click', function (e) {
			});


			self.$elem.delegate('.textCaption', 'change', function (e) {

				var item = $(this).parents('.uiEditablePhoto');
				var data = item.data();
				item.addClass('has-loading');

				var text = $(this).val();
				var url = URL + 'product/update_caption_out_product/'+data.id;

				$.ajax({
				    type: 'POST',
				    dataType: 'json',
				    url: url,
				    // cache: false,
				    data: { text: text}
				}).done(function() {
				    // alert( "success" );
				}).fail(function() {
				    // alert( "error" );
				}).always(function() {
				    item.removeClass('has-loading');
				});
				
			});
		},
		upload: function ( item, file ) {
			var self = this;

			var formData = new FormData();
			formData.append('file1', file );

			$.ajax({
			    type: 'POST',
			    dataType: 'json',
			    url: self.options.uploadURL,
			    // cache: false,
			    data: formData,
			    processData: false,
			    contentType: false,
			    error: function (xhr, ajaxOptions, thrownError) {
			        // alert(xhr.responseText);
			        // alert(thrownError);
			    },
			    xhr: function () {
			        var xhr = new window.XMLHttpRequest();
			        //Download progress
			        xhr.addEventListener("progress", function (evt) {
			            if (evt.lengthComputable) {
			                var percentComplete = evt.loaded / evt.total;
			                item.find('.progress-bar>.bar').css('width', Math.round(percentComplete * 100) + "%");
			            }
			        }, false);
			        return xhr;
			    },
			    beforeSend: function () {
			    	
			        // $('#loading').show();
			    },
			    complete: function () {

			    	if( self.is_upload ){ 
			    		self.is_upload = false;
			    		self.$upload.removeClass('disabled'); 
			    	}
			        // $("#loading").hide();
			    },
			    success: function (json) {

			    	item.data(json);
			    	item.removeClass('has-loading');

			    	item.find('.scaledImage').html( $('<img>', {
			    		src: json.url + "?ran"+ Math.floor((Math.random() * 100))
			    	}) );

			    	self.resize();
			        // $("#data").html("data receieved");

			    }
			});
		},
		updateImage: function ( item, options ) {
			
			var data = item.data();

			/*var formData = new FormData();
			$.each(options, function (index, field) {
				formData.append(field.name, field.value);
	        });
	        formData.append('id', data.id);*/

			$.post(URL+'product/update_out_product/' + data.id, options, function (response) {

				item.find('.img').attr(
					'src', response.url + "?ran=" + Math.floor((Math.random() * 100) + 1)
				);
				

			}, 'json');

		},
		display: function (item) {

			var self = this;
			var data = item.data();
			// console.log( data );

			var $img = $('<img>', {
				class: 'img', 
				src: data.url + "?ran=" + Math.floor((Math.random() * 100) + 1)
			}).addClass( 'scaledImageFitWidth' );
			item.find('.scaledImage').html( $img );

			item.removeClass('has-loading');
			self.resize();
		},
		resize: function () {
			
			var self = this;
			var fullWidth = self.$listsbox.outerWidth();

			var width = 290;
			
			var length = Math.round(fullWidth / width);
			nwidth = parseInt(fullWidth / length);

			var margin = 9; // + (2*length);

			if( nwidth < width )  width = nwidth;

			width -=  margin*length;

			$.each( self.$listsbox.find('.uiEditablePhoto'), function (i, item) {
				$(this).css({
					width: width 
				}).find('.photoWrap').css({
					width: width,
					height: width
				}).find('.scaledImageContainer').css({
					width: width,
					height: width
				});

				var h = $(this).find('.img').height();
				var w = $(this).find('.img').width();

				var scaled = self.resizeImage( {
					width: w, height: h
				}, { 
					width: width, height: width
				} );

				var fitHeight = scaled.width>scaled.height? false: true;

				$(this).find('.img').css({	})
				.removeClass('scaledImageFitHeight')
				.removeClass('scaledImageFitWidth')
				.addClass( fitHeight? "scaledImageFitHeight":'scaledImageFitWidth' );

				/*$(this).find('.scaledImage').css({
					width: scaled.width,
					height: scaled.height,
					position: 'absolute'
				});

				var css = {
					top: 0,
					left: 0
				};
				if( scaled.width>scaled.height ){
					css.top = (width - scaled.height) / 2;
				}
				else if( scaled.width<scaled.height ) {
					css.left = (width - scaled.width) / 2;
				}*/

				// $(this).find('.scaledImage').css( css );
			});
		},
		resizeImage: function ( fig, org ) {
			if( org.width == org.height ) return fig;
			
			else if (org.width > org.height) {

 				return {
					width: (fig.width).toFixed(),
					height: ((org.height * fig.height) / org.width).toFixed(),
					org: org,
					fitHeight: true
				}

 			}else{
				return {
					width: ((org.width * fig.width) / org.height).toFixed(),
					height: (fig.height).toFixed(),
					org: org,
					fitHeight: false
				}

			}
		},

		cropperPreveiw: function (options) {
			var self = this;

			if (typeof $.fn['cropper'] !== 'undefined') {
				self.$imageCropper.cropper( self.options.cropper );
				Event.hideMsg();
			}
			else{
				Event.getPlugin( 'cropper' ).done(function () {
					self.$imageCropper.cropper( self.options.cropper );
					Event.hideMsg();
				}).fail(function () {
					console.log( 'Is not connect plugin:' );
					Event.hideMsg();
				});
			}
		},
		setCropimage: function () {
			var self = this;

			var $preveiw = $('<div>', {class: 'image-preveiw'});
			var $dataX = $('<input/>', {type:"hidden",autocomplete:"off",name:"cropimage[X]"});
		    var $dataY = $('<input/>',{type:"hidden",autocomplete:"off",name:"cropimage[Y]"});
		    var $dataHeight = $('<input/>',{type:"hidden",autocomplete:"off",name:"cropimage[height]"});
		    var $dataWidth = $('<input/>',{type:"hidden",autocomplete:"off",name:"cropimage[width]"});$('#dataWidth');
		    var $dataRotate = $('<input/>',{type:"hidden",autocomplete:"off",name:"cropimage[rotate]"});
		    var $dataScaleX = $('<input/>',{type:"hidden",autocomplete:"off",name:"cropimage[scaleX]"});
		    var $dataScaleY = $('<input/>',{type:"hidden",autocomplete:"off",name:"cropimage[scaleY]"});

		    self.options.cropper.crop = function (e) {
	            $dataX.val(Math.round(e.x));
	            $dataY.val(Math.round(e.y));
	            $dataHeight.val(Math.round(e.height));
	            $dataWidth.val(Math.round(e.width));
	            $dataRotate.val(e.rotate);
	            $dataScaleX.val(e.scaleX);
	            $dataScaleY.val(e.scaleY);
	        }

			return $preveiw.css({
				height:460,
				width:460
			}).append(
				$dataX,
				$dataY,
				$dataWidth,
				$dataHeight,
				$dataRotate,
				$dataScaleX,
				$dataScaleY,
				self.$imageCropper
			);
		}
	};

	$.fn.EditablePhoto = function( options ) {
		return this.each(function() {
			var $this = Object.create( EditablePhoto );
			$this.init( options, this );
			$.data( this, 'EditablePhoto', $this );
		});
	};

	$.fn.EditablePhoto.options = {
		speed: 500,
		// wrapEachWith: '<div></div>',
		auto: true,
		refresh: 13000,
		random: true,
		width: 290,
		height: 290,

		cropper: {
			aspectRatio: 1,
			autoCropArea: 1,
			strict: true,
			guides: true,
			highlight: false,
			dragCrop: false,
			cropBoxMovable: true,
			cropBoxResizable: false,
			onCallback: function () {},
		}
	};
	
})( jQuery, window, document );