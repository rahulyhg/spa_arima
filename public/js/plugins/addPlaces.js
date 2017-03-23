// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var addPlaces = {
		init: function(options, elem) {
			var self = this;
			self.elem = elem;
			self.options = options;

			self.files = [];
			self.file_image_cover = "";
			self.initElem();
			self.initEvent();
		},
		initElem: function () {
			var self = this;
			self.$elem = $( self.elem );
			self.$imagecover = self.$elem.find('.image-cover');
			if( self.$imagecover.attr('data-options')!='' ){

				self.set_image_cover( $.parseJSON( self.$imagecover.attr('data-options') ) );
				self.$imagecover.removeAttr('data-options');
			}

			/*self.$uploadimages = self.$elem.find('.upload-images');
			self.$uploadImgContainer = self.$uploadimages.find('.uiEditablePhotoContainer');
			self.fullWidth = self.$uploadImgContainer.parent().width();
			self.$uploadImgContainer.parent().width( self.fullWidth );
			if( self.$uploadimages.attr('data-options')!='' ){
				self.set_image( $.parseJSON( self.$uploadimages.attr('data-options') ) );
				self.$uploadimages.removeAttr('data-options');
			}*/
			
		},
		initEvent: function () {
			var self = this;
			self.$imagecover.find('[type=file]').change(function () {
				
				self.preview_image_cover(this.files[0]);
			});

			/*self.$uploadimages.find('[type=file]').change(function () {

				for (var i = 0; i < this.files.length; i++) {
					self.get_upload_images(this.files[i]);
				};
				
				$(this).val('');
			});*/

			self.$elem.submit(function (e) {
				e.preventDefault();
				
				self.submit();
			});
		},

		clear_image_cover:function () {
			var self = this;

			self.file_image_cover = "";
			self.$imagecover.find('[type=file]').val('');
			self.$imagecover.find('.preview').empty();
			self.$imagecover.removeClass('has-file');
		}, 
		cropper_image: function ( $el ) {
			var self = this;

			var $x = $('<input/>', {type: 'hidden', name:'cropimage[x]', value: 0});
			var $y = $('<input/>', {type: 'hidden', name:'cropimage[y]', value: 0});
			var $width = $('<input/>', {type: 'hidden', name:'cropimage[width]', value: 0 });
			var $height = $('<input/>', {type: 'hidden', name:'cropimage[height]', value: 0 });
			var $rotate = $('<input/>', {type: 'hidden', name:'cropimage[rotate]', value: 0 });
			var $scaleX = $('<input/>', {type: 'hidden', name:'cropimage[scaleX]', value: 0 });
			var $scaleY = $('<input/>', {type: 'hidden', name:'cropimage[scaleY]', value: 0 });
			
			$el.append($x, $y,$width, $height, $rotate, $scaleX, $scaleY);

			Event.setPlugin( $el.find('img.img-crop'), 'cropper', {
				aspectRatio: 27 / 10,
				autoCropArea: 1,
				strict: true,
				guides: true,
				highlight: false,
				dragCrop: false,
				cropBoxMovable: true,
				cropBoxResizable: false,
				crop: function(e) {

					if( $el.find('.image-wrap').length ){

					 	$el.find('.image-wrap').addClass('hidden_elem');
					}

					if( $el.find('.image-crop').hasClass('hidden_elem') ){
					 	$el.find('.image-crop').removeClass('hidden_elem');
					}

				    // Output the result data for cropping image.
				    $x.val(e.x);
				    $y.val(e.y);
				    $width.val(e.width);
				    $height.val(e.height);
				    $rotate.val(e.rotate);
				    $scaleX.val(e.scaleX);
				    $scaleY.val(e.scaleY);

				}
			} );
		},
		set_image_cover: function ( options ) {
			var self = this;
			var $remove = $('<a/>', {class:"preview-remove"}).html( $('<i/>', {class:'icon-remove'}) );
			var $img = $('<div/>',{ class:'image-crop hidden_elem'});
			var $wrap = $('<div/>',{ class:'image-wrap'});
			var $edit = $('<div/>',{ class:'image-cover-edit', text: 'ปรับตำแหน่ง'});
			self.$imagecover.addClass('has-file').find('.preview').append( $remove, $edit, $img, $wrap );

			$edit.click(function (e) {

				if( self.$imagecover.hasClass('has-cropimage') ){
					$edit.text('ปรับตำแหน่ง');
					self.$imagecover.removeClass('has-cropimage');
					$wrap.removeClass('hidden_elem');
					$img.addClass('hidden_elem').empty();
				}
				else{
					$edit.text('ยกเลิก');
					self.$imagecover.addClass('has-cropimage');
					setcrop();
					self.cropper_image( self.$imagecover.find('.preview') );
				}
				
			});

			$remove.click(function (e) {
				e.preventDefault();

				Dialog.load( options.action_url, {}, {

					onSubmit: function ( data ) {
						$form = data.$pop.find('form.model-content');
						Event.inlineSubmit( $form ).done(function( result ) {
							Event.processForm($form, result);

							if( result.status==1 ){
								self.clear_image_cover();
							}
						});
					},
					onClose: function () {}
				});
			});

			var scaledW = 851;
			var scaledH = 315;

			var width = self.$imagecover.width();
			var height = ( scaledH * width ) / scaledW;

			function setcrop() {
				$img.css({
					width: width,
					height: height
				}).append( 
					$('<img>', {class: 'img img-crop',src: options.image_url_o}),
					$('<input/>', {type: 'hidden', name:'is_cropimage', value: 1})
				);
			}

			$wrap.css({
				width: width,
				height: height
			}).html( $('<img>', {class: 'img', src: options.image_url}) );
		},
		preview_image_cover: function (file) {
			var self = this;

			self.clear_image_cover();
			self.$imagecover.addClass('has-loading');
			var $progress = self.$imagecover.find('.progress-bar');
			var $remove = $('<a/>', {class:"preview-remove"}).html( $('<i/>', {class:'icon-remove'}) );

			$remove.click(function (e) {
				e.preventDefault();
				self.clear_image_cover();
			});

			var $img = $('<div/>',{ class:'image-crop'});
			self.$imagecover.find('.preview').append( $remove, '<div class="image-cover-border"></div>', $img );

			var width = self.$imagecover.width();

			var reader = new FileReader();
			reader.onload = function (e) {
				var image = new Image();
				image.src = e.target.result;
				$image = $(image).addClass('img img-crop');
				self.file_image_cover = file;

				image.onload = function() {
					
					var scaledW = this.width;
					var scaledH = this.height;
					var height = ( scaledH * width ) / scaledW;
					$image.width( width );
					$image.height( height );

					var scaledW = 851;
					var scaledH = 315;
					var height = ( scaledH * width ) / scaledW;
					
					$img.css({ width: width, height: height });
					
					self.$imagecover.removeClass('has-loading').addClass('has-file');
					$img.html( $image );

					self.cropper_image( self.$imagecover.find('.preview') );
				}
			}

			reader.onprogress = function(data) {
				if (data.lengthComputable) {                                            
	                var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
	                $progress.find('.bar').width( progress+"%" );
	            }
        	}

			reader.readAsDataURL( file );
		},

		set_image: function (options) {
			var self = this;
			
			var lists = options.lists;
			for (var i = 0; i < lists.length; i++) {

				var data = lists[i];
				$item = self.editablePhoto();
				if( self.$uploadImgContainer.find('.uiEditablePhoto').length==0 ){
					self.$uploadImgContainer.append( $item );
				}
				else{
					self.$uploadImgContainer.find('.uiEditablePhoto').first().before( $item );
				}

				var h = $item.find('.scaledImage').height();
				var scaled = self.resizeImage( {
					width: $item.find('.scaledImage').width(), height: h
				}, { 
					width: data.width, height: data.height
				} );

				var fitHeight = ( typeof scaled.fitHeight !== "undefined" )? true: false;

				$item.css({
					lineHeight: fitHeight? h+"px":"",
					width: scaled.width

				}).find('.scaledImage').css({ 
						width: scaled.width,
						height: scaled.height
						
					}).html(
						$('<img/>', {
							class:'img',
							src: data.url
						}).addClass( fitHeight? "scaledImageFitHeight":'scaledImageFitWidth') 
					);

				// $item.append()
				$item.find('.textInput').attr('name', "captionx_text[]").val( data.caption_text );
				self.scaledAreaImg();
				self.verifyElImg();

				/*$item.find('.js-cancel').click(function (e) {
					e.preventDefault();

					self.files.splice(file.$elem.index(), 1 );
					file.$elem.remove();
					self.scaledAreaImg();
					self.verifyElImg();
				});*/
			};
		},
		load_image: function ( file ) {
			var self = this;

			var $progress = file.$elem.find('.progress-bar');
			var $img = file.$elem.find('.scaledImage');
			var width = file.$elem.width()+40;

			var reader = new FileReader();
			reader.onload = function (e) {
				var image = new Image();
				image.src = e.target.result;
				$image = $('<img/>', {class: 'img', src: e.target.result});
				$img.html( $image );
				file.$elem.removeClass('has-loading');

				image.onload = function() {
					var $img = this;

					var h = file.$elem.find('.scaledImage').height();
					var scaled = self.resizeImage( {
						width: file.$elem.find('.scaledImage').width(), height: h
					}, { 
						width: $img.width, height: $img.height
					} );

					var fitHeight = ( typeof scaled.fitHeight !== "undefined" )? true: false;

					file.$elem.css({
						lineHeight: fitHeight? h+"px":"",
						width: scaled.width

					}).find('.scaledImage').css({ 
							width: scaled.width,
							height: scaled.height
							
						}).find('.img').addClass( 
							fitHeight? "scaledImageFitHeight":'scaledImageFitWidth' 
						);


					self.scaledAreaImg();
					self.verifyElImg();
				}
			}

			reader.onprogress = function(data) {
				if (data.lengthComputable) {                                            
	                var progress = parseInt( ((data.loaded / data.total) * 100), 10 );
	                $progress.find('.bar').width( progress+"%" );
	            }
        	}

			reader.readAsDataURL( file );
		},
		resizeImage: function ( $figSize, $orgSize ) {
			if( $orgSize.width == $orgSize.height ) return $figSize;
			else if ($orgSize.width > $orgSize.height) {

 				return {
					width: ($figSize.width).toFixed(),
					height: (($orgSize.height * $figSize.height) / $orgSize.width).toFixed(),
					org: $orgSize,
					fitHeight: true
				}

 			}else{
				return {
					width: (($orgSize.width * $figSize.width) / $orgSize.height).toFixed(),
					height: ($figSize.height).toFixed(),
					org: $orgSize,
					fitHeight: false
				}

			}
		},
		scaledAreaImg: function () {
			var self = this;

			var fullWidth = 0;
			$.each( self.$uploadImgContainer.find('.uiEditablePhoto'), function(i, item){

				fullWidth+= $(this).outerWidth() + parseInt( $(this).css('margin-left') ) + parseInt( $(this).css('margin-right') );
			});

			fullWidth = fullWidth > self.fullWidth
				 ? fullWidth
				 : self.fullWidth
			
			self.$uploadImgContainer.width( fullWidth );
		},
		verifyElImg: function () {
			var self = this;

			if( self.$uploadImgContainer.find('.uiEditablePhoto').length==0 ){
				self.$uploadImgContainer.addClass('hidden_elem');
			}
			else{
				self.$uploadImgContainer.removeClass('hidden_elem');
			}
		},
		image_queue: function () {
			var self = this;

			$.each(self.files, function (i, obj) {
				if(obj.is_check==false){
					obj.is_check = true;
					self.load_image(obj);
					return false;
				}
			});
		},
		set_preview_upload_image: function () {
			var self = this;
			/*return $('<li>', {class:'has-loading'}).append( 
				$('<div/>', {class:'loader'}).append(
					$('<div/>', {class:'mbs clearfix'}).append(
						$('<div/>', {class:'loader-text'}),
						$('<a/>', {class:'rfloat btn-icon loader-remove'}).html('<i class="icon-remove"></i>')
					),
					$('<div/>', {class:'progress-bar mini'}).html('<span class="bar blue" style="width:0%"></span>')
				),
				$('<div/>', {class:'preview'}).append(
					$('<a/>', {class:'preview-remove'}).html('<i class="icon-remove"></i>'),
					$('<div/>', {class:'image-crop'})
				)
			);*/

			return self.editablePhoto();
		},
		editablePhoto: function(){
			var self = this;
			return $('<div/>').addClass('uiEditablePhoto has-loading')
				
				.append( self.editablePhotoProgress() )

				.append( $('<div/>')
					.addClass('photoWrap editablePhotoReady') 
					.append( $('<div/>')
						.addClass('scaledImageContainer scaledImage')
					)
				)			
				.append( self.editablePhotoCaption() )
				.append( self.editablePhotoControls() );
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
					.append( self.loader )
				);
		},
		editablePhotoCaption: function(){

			return $('<div/>', {class: 'inputs'})
				.append( $('<div/>')
					.addClass('captionArea')
					.append( $('<div/>')
						.addClass('uiTypeahead') 
						.append( $('<textarea/>')
							.addClass('uiTextareaNoResize textInput') 
							.attr({
								title: "เขียนคำบรรยายรูปภาพ...",
								name: 'caption_text[]',
								placeholder: "เขียนคำบรรยายรูปภาพ"
							})
							
						)
						
					)
				
				);
		},
		editablePhotoControls: function(){

			return $('<div/>').addClass('controls')
				/*.append( $('<div/>')
					.addClass('control') 
					.append( $('<i/>')
						.addClass('icon-refresh')
						
					)
				)*/
				.append( $('<a/>')
					.addClass('control js-cancel') 
					.append( $('<i/>')
						.addClass('icon-remove')
						.attr({
							title:"ลบออก"
						})
					)
				);
		},
		get_upload_images:function (file) {
			var self = this;
			file.$elem = self.set_preview_upload_image();
			file.is_check = false;

			if( self.$uploadImgContainer.find('.uiEditablePhoto').length==0 ){
				self.$uploadImgContainer.append( file.$elem );
			}
			else{
				self.$uploadImgContainer.find('.uiEditablePhoto').first().before( file.$elem );
			}
			self.scaledAreaImg();
			// self.$uploadimages.find('.lists-upload-images').append(  );
			file.$elem.find('.js-cancel').click(function (e) {
				e.preventDefault();

				self.files.splice(file.$elem.index(), 1 );
				file.$elem.remove();
				self.scaledAreaImg();
				self.verifyElImg();
			});

			self.files.push(file);
			self.image_queue();
		},

		submit:function () {
			var self = this;
			
			var formData = new FormData();

			// set field
			$.each(self.$elem.serializeArray(), function (index, field) {
				formData.append(field.name, field.value);
	        });

			if( self.file_image_cover ){
				formData.append('image_cover', self.file_image_cover);
			}

	        $.each( self.files, function (index, file) {
	        	formData.append('images[]', file);
	        });

	        Event.inlineSubmit( self.$elem, formData ).done(function ( results ) {
	        	Event.processForm(self.$elem, results);
	        });
		}
	};

	$.fn.addPlaces = function( options ) {
		return this.each(function() {
			var $this = Object.create( addPlaces );
			$this.init( options, this );
			$.data( this, 'addPlaces', $this );
		});
	};

	$.fn.addPlaces.options = {
		onOpen: function() {},
		onClose: function() {}
	};
	
})( jQuery, window, document );