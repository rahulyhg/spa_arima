// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

var photoGallery = {};

(function( $, window, document, undefined ) {

var $window = $( window ),
	$doc = $('div#doc');

var Gallery = {
		init: function( options, elem ) {
			var self = this;

			self.elem = elem;
			self.$elem = $( elem );
			self.options = $.extend( {}, $.fn.photoGallery.options, options );
			self.url = self.$elem.attr('href');
			self.data = self.$elem.data();

			self.$elem.click(function (e) {
				e.preventDefault();

				if( typeof photoGallery[ self.data.galleryId ] === 'undefined' ){
					self._loadGallery();
				}
				else{
					self._display();
				}
			});
			
		},

		_loadGallery: function () {
			var self = this;
			Event.showMsg({ load:true });

			$.ajax({
				url: self.url,
				// data: self.data,
				dataType: 'json'
			}).done(function( results ) {
				
				self._buildFrag( results );
				self._display();

			}).fail(function() { 
				// error
				console.log('error');
				Event.showMsg({ text: "เกิดข้อผิดพลาด...", load: true , auto: true });
			}).always(function() { 
				// complete
				console.log('complete');
				Event.hideMsg();
			});	
		},

		_buildFrag: function ( results ) {
			var self = this;


			$.each( results.photos, function (i, obj) {
				results.photos[i].$elem = $('<img/>', {class: 'img', src: obj.url + "?rand="+Math.random() });
			});
			photoGallery[ self.data.galleryId ] = results;


			
		},

		_display: function () {
			var self = this;
			
			if( !self.$model ){
				self.setModel();
			}
			else{
				self.getModel();
			}

			photoGallery[ self.data.galleryId ].currentId = self.data.currentId || 0;

			
			self.changeImage();

			if( !self.$model.hasClass('show') ){
				self.openModel();
			}

		},

		loadImage: function (url, call) {
			var self = this;
			// console.log( obj );

			var image = new Image();
			image.onload = function () {
				var img = this;

				self.width = img.width;
				self.height = img.height;

				if( typeof call === 'function' ){
					call( true );
					self.stage();
				}
			}

			image.onerror = function(e){

			}

			image.src = url;
		},

		setResizeImage: function ( url, call) {
			var self = this;

			self.nWidth = $window.width() - self.options.margin_width;
			self.nHeight = $window.height() - self.options.margin_height;

			if( url ){
				/*self.currentWidth = self.nWidth;
				self.currentHeight = self.nHeight;*/
				self.loadImage( url, call );
			}
			else{
				/*self.width = self.currentWidth;
				self.height = self.currentHeight;*/

				self.stage();
			}
			

		},
		stage: function () {
			var self = this;

			/*if( self.width > self.height  ){
				self.sX();
				self.sY();
			}
			else{
				self.sY();
				self.sX();
			}*/

			// 
			self.$model.find('.stageWrapper,.stage,.img').css({
				width: self.width,
				height: self.height
			});
		},
		sX: function () {
			var self = this;

			if( self.width > self.nWidth ){
				self.width = self.nWidth;
				self.height = parseInt( (self.height*self.nWidth)/self.width );
			}
		},

		sY: function () {
			var self = this;

			if( self.height > self.nHeight ){
				self.height = self.nHeight;
				self.width = parseInt( (self.width*self.nHeight)/self.height );
			}
		},

		openModel: function () {
			var self = this;

			self.$model.addClass( 'show' );

			self.is_open = true;

			$window.resize(function () {
				self.setResizeImage();
			});
		},

		closeModel: function () {
			var self = this;

			var scroll = parseInt($doc.css("top"));
			scroll= scroll < 0 ? scroll*-1:scroll;

			self.$model.removeClass("show");

			setTimeout( function(){

				self.$model.remove();

				if ( typeof self.onClose==='function' ) {
					self.onClose();
				}

				if( $('.model').not('.hidden_elem').length ) return false;

				$doc.removeClass('fixed_elem').css('top', "");
				$(window).scrollTop( scroll );

				$('html').removeClass('hasModel');
			}, 300);
		},

		setModel: function () {
			var self = this;

			self.$model = $('<div/>',{class: 'model black model-gallery'});

			self.$stageActions = $('<div/>',{class: 'stageActions'});

			self.$stageActions.html(
				$('<div/>', {class: 'clearfix mediaOverlayBar'}).append(
					$('<div/>',{class: 'mediaTitleInfo'}).append(
						$('<h2/>', {class: 'mediaTitle mrm hidden_elem'})
						, $('<span/>', {class: 'mediaCount'})
					)
				)
			)

			self.$model.html(
				$('<div/>',{class: 'galleryContainer'}).html(

					$('<div/>',{class: 'galleryContent'}).html(
						$('<div/>',{class: 'stageWrapper'}).append(

							$('<div/>',{class: 'stageControls'}).append(
								$('<a/>',{class: 'closeTheater', title: "กดปุ่ม Esc เพื่อปิด"})
								// , $('<a/>',{class: 'fullScreenSwitchTheater'})
							)
							, $('<div/>',{class: 'stage'})
							, $('<a/>',{class: 'galleryPager prev', title: "ก่อนหน้านี้"}).html( $('<i/>', {class: 'icon-angle-left'}) )
							, $('<a/>',{class: 'galleryPager next', title: "ถัดไป"}).html( $('<i/>', {class: 'icon-angle-right'}) )
							, self.$stageActions
						)
					)
				)
			);
			
			self.getModel();
			
			$(document).keyup(function(e){
				if( self.is_open == true){

					if( e.keyCode == 27 ){ // e.which
						self.closeModel();
					}else if(e.keyCode == 37){ // prev
						self.prevnext( "prev" );
					}else if( e.keyCode == 39 ){// next
						self.prevnext( "next" );
					}
				}
			});
		},

		getModel: function () {
			var self = this;

			$( 'body' ).append( self.$model );

			if( !$('html').hasClass('hasModel') ){

				$doc.css('top', $window.scrollTop()*-1 ).addClass('fixed_elem');
				$window.scrollTop(0);

				$('html').addClass('hasModel');
			}

			// Event
			self.$model.click(function () {
				
				if( self.is_open ){
					self.closeModel();
				}
				
			});

			self.eventsModel();

			
			/*if( self.$model.hasClass('pagingActivated') ){
				self.$model.removeClass("pagingActivated");
			}*/
		},

		eventsModel: function () {
			var self = this;

			var $wrapper = self.$model.find('.stageWrapper');
			// Mouse
			$wrapper.mouseenter(function() {

				self.focus = true;
				self.$model.addClass("pagingActivated");

			}).mouseleave(function(){

				self.focus = false;
				self.$model.removeClass("pagingActivated");

			}).mousemove(function( e ){

				if( !self.$model.hasClass("pagingActivated") ){
					self.$model.addClass("pagingActivated");
				}

				var width = $(this).width(),
					hilightPrev = (25*width)/100,
				 	xLeft = e.pageX-$(this).position().left,
				 	prev = self.$model.find(".galleryPager.prev"),
				 	next = self.$model.find(".galleryPager.next");

				 	if( xLeft < hilightPrev ){
						if( prev.hasClass("hilightPager")==false ){
							prev.addClass("hilightPager");
							next.removeClass("hilightPager");

							self.pager = "prev";
						}
					}else{
						if( next.hasClass("hilightPager")==false ){
							next.addClass("hilightPager");
							prev.removeClass("hilightPager");

							self.pager = "next";
						}
					}
			}).click(function(e){

				e.stopPropagation();
				self.prevnext();
			});	
		},

		prevnext: function (active) {
			var self = this;

			if(!self.$model.hasClass('pagingReady')){ return false; }

			var prevnext = active||self.pager;
			if( prevnext=='next' ){

				photoGallery[ self.data.galleryId ].currentId ++;
				if( photoGallery[ self.data.galleryId ].currentId >= photoGallery[ self.data.galleryId ].photos.length ){
					photoGallery[ self.data.galleryId ].currentId = 0;
				}
			}
			else{

				photoGallery[ self.data.galleryId ].currentId --;
				if( photoGallery[ self.data.galleryId ].currentId<0 ){
					photoGallery[ self.data.galleryId ].currentId = photoGallery[ self.data.galleryId ].photos.length-1;
				}
			}

			self.changeImage();
		},

		changeImage: function () {
			var self = this;

			


			self.setResizeImage( photoGallery[ self.data.galleryId ].photos[ photoGallery[ self.data.galleryId ].currentId  ].url, function () {
				self.$model.find('.stage').html( photoGallery[ self.data.galleryId ].photos[ photoGallery[ self.data.galleryId ].currentId  ].$elem  );

				if( photoGallery[ self.data.galleryId ].photos.length > 1 ){

				self.$stageActions.find( '.mediaCount' ).text( (photoGallery[ self.data.galleryId ].currentId+1) + " จาก " + photoGallery[ self.data.galleryId ].photos.length );

				self.$model.addClass('pagingReady');
			}

			} );
		}
	};

	$.fn.photoGallery = function( options ) {
		return this.each(function() {
			var gallery = Object.create( Gallery );
			gallery.init( options, this );
			$.data( this, 'photoGallery', gallery );
		});
	};

	$.fn.photoGallery.options = {
		onOpen: function(){},
		format: 'stage', // sequence,
		margin_width: 40,
		margin_height: 40
	};

})( jQuery, window, document );