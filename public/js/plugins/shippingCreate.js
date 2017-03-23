// Utility
if ( typeof Object.create !== 'function' ) {
	Object.create = function( obj ) {
		function F() {};
		F.prototype = obj;
		return new F();
	};
}

(function( $, window, document, undefined ) {

	var gCtx = null;
	var gCanvas = null;
	var c=0;
	var stype=0;
	var gUM=false;
	var webkit=false;
	var moz=false;
	var v=null;
	var Items = {};
	var listsItems = [];
	var postData = {};

	var $soundBell = $('<audio/>', {class: 'message-sound', preload: 'auto', src: Event.URL + 'public/sounds/beep.mp3'})[0];
	$('body').append($soundBell);

	var vidhtml = '<video id="v" autoplay></video>';

	function dragenter(e) {
	  	e.stopPropagation();
	  	e.preventDefault();
	}

	function dragover(e) {
	  	e.stopPropagation();
	 	e.preventDefault();
	}
	function drop(e) {
	  e.stopPropagation();
	  e.preventDefault();

	  var dt = e.dataTransfer;
	  var files = dt.files;
	  if(files.length>0)
	  {
		handleFiles(files);
	  }
	  else
	  if(dt.getData('URL'))
	  {
		qrcode.decode(dt.getData('URL'));
	  }
	}

	function handleFiles(f)
	{
		var o=[];
		
		for(var i =0;i<f.length;i++)
		{
	        var reader = new FileReader();
	        reader.onload = (function(theFile) {
	        return function(e) {
	            gCtx.clearRect(0, 0, gCanvas.width, gCanvas.height);

				qrcode.decode(e.target.result);
	        };
	        })(f[i]);
	        reader.readAsDataURL(f[i]);	
	    }
	}

	function initCanvas(w,h)
	{
	    gCanvas = document.getElementById("qr-canvas");
	    gCanvas.style.width = w + "px";
	    gCanvas.style.height = h + "px";
	    gCanvas.width = w;
	    gCanvas.height = h;
	    gCtx = gCanvas.getContext("2d");
	    gCtx.clearRect(0, 0, w, h);
	}

	function captureToCanvas() {
	    if(stype!=1)
	        return;
	    if(gUM)
	    {
	        try{
	            gCtx.drawImage(v,0,0);
	            try{
	                qrcode.decode();
	            }
	            catch(e){       
	                console.log(e);
	                setTimeout(captureToCanvas, 500);
	            };
	        }
	        catch(e){       
	                console.log(e);
	                setTimeout(captureToCanvas, 500);
	        };
	    }
	}

	function htmlEntities(str) {
	    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}

	function read(a)
	{
	    // alert( htmlEntities(a) );

	    /*var html="<br>";
	    if(a.indexOf("http://") === 0 || a.indexOf("https://") === 0)
	        html+="<a target='_blank' href='"+a+"'>"+a+"</a><br>";
	    html+="<b>"+htmlEntities(a)+"</b><br><br>";
	    document.getElementById("result").innerHTML=html;*/
	}

	function isCanvasSupported(){
	  var elem = document.createElement('canvas');
	  return !!(elem.getContext && elem.getContext('2d'));
	}
	function success(stream) {
	    if(webkit)
	        v.src = window.URL.createObjectURL(stream);
	    else
	    if(moz)
	    {
	        v.mozSrcObject = stream;
	        v.play();
	    }
	    else
	        v.src = stream;
	    gUM=true;
	    setTimeout(captureToCanvas, 500);
	}

	function error(error) {
	    gUM=false;
	    return;
	}

	function setwebcam()
	{
		
		var options = true;
		if(navigator.mediaDevices && navigator.mediaDevices.enumerateDevices)
		{
			try{
				navigator.mediaDevices.enumerateDevices()
				.then(function(devices) {
				  devices.forEach(function(device) {
					if (device.kind === 'videoinput') {
					  if(device.label.toLowerCase().search("back") >-1)
						options={'deviceId': {'exact':device.deviceId}, 'facingMode':'environment'} ;
					}
					// console.log(device.kind + ": " + device.label +" id = " + device.deviceId);
				  });
				  setwebcam2(options);
				});
			}
			catch(e)
			{
				console.log(e);
			}
		}
		else{
			console.log("no navigator.mediaDevices.enumerateDevices" );
			setwebcam2(options);
		}
		
	}

	function setwebcam2(options)
	{
		// document.getElementById("result").innerHTML="- scanning -";
	    if(stype==1)
	    {
	        setTimeout(captureToCanvas, 500);    
	        return;
	    }
	    var n=navigator;
	    document.getElementById("outdiv").innerHTML = vidhtml;
	    v=document.getElementById("v");

	    if(n.getUserMedia)
		{
			webkit=true;
	        n.getUserMedia({video: options, audio: false}, success, error);
		}
	    else
	    if(n.webkitGetUserMedia)
	    {
	        webkit=true;
	        n.webkitGetUserMedia({video:options, audio: false}, success, error);
	    }
	    else
	    if(n.mozGetUserMedia)
	    {
	        moz=true;
	        n.mozGetUserMedia({video: options, audio: false}, success, error);
	    }

	    // document.getElementById("qrimg").style.opacity=0.2;
	    // document.getElementById("webcamimg").style.opacity=1.0;

	    stype=1;
	    setTimeout(captureToCanvas, 500);
	}

	function setimg()
	{
		// document.getElementById("result").innerHTML="";
	    if(stype==2) return;

	    document.getElementById("outdiv").innerHTML = imghtml;
	    //document.getElementById("qrimg").src="qrimg.png";
	    //document.getElementById("webcamimg").src="webcam2.png";
	    document.getElementById("qrimg").style.opacity=1.0;
	    document.getElementById("webcamimg").style.opacity=0.2;
	    var qrfile = document.getElementById("qrfile");
	    qrfile.addEventListener("dragenter", dragenter, false);  
	    qrfile.addEventListener("dragover", dragover, false);  
	    qrfile.addEventListener("drop", drop, false);
	    stype=2;
	}

	var ShippingCreate = {

		initCanvas: function (w,h) {
		    gCanvas = this.canvas;

		    gCanvas.style.width = w + "px";
		    gCanvas.style.height = h + "px";
		    gCanvas.width = w;
		    gCanvas.height = h;
		    gCtx = gCanvas.getContext("2d");
		    gCtx.clearRect(0, 0, w, h);
		},

		read: function(a) {

			ShippingCreate.getCode( htmlEntities(a) );
			setwebcam();

		    // alert(  );
		    /*var html="<br>";
		    if(a.indexOf("http://") === 0 || a.indexOf("https://") === 0)
		        html+="<a target='_blank' href='"+a+"'>"+a+"</a><br>";
		    html+="<b>"+htmlEntities(a)+"</b><br><br>";
		    document.getElementById("result").innerHTML=html;*/
		},
		isCanvasSupported: function(){
		  	var elem = this.canvas;
		  	return !!(elem.getContext && elem.getContext('2d'));
		},

		init: function ( options, elem ) {
			var self = this;
			self.elem = elem;
			self.$elem = $(self.elem);

			self.options = $.extend( {}, $.fn.shippingCreate.options, options );
			self.setElem();
			// console.log( self.options  );
			// alert( 1 );

			setTimeout(function () {
				Dialog.load( Event.URL + "shipping/set_dr" , {callback: true}, {

					onSubmit: function (d) {

						var $form = d.$pop.find('form');
						var $submit = $form.find('[type=submit]');

						if( $submit.hasClass('btn-error') ){ $submit.removeClass('btn-error'); }
						self.$summary.empty();

						var error, a = [
							{
								label: 'Direction',
								key: 'ship_to_id'
							},
							{
								label: 'Van No.',
								key: 'ship_car_id'
							},
							{	
								label: 'Driver Name',
								key: 'ship_driver_id'
							}, 
						];

						$.each(a, function (i, obj) {

							var $fieldset = $form.find('#' + obj.key + '_fieldset');
							var $input = $fieldset.find(':input[name='+obj.key+']');
							var val = $input.val();

							if( $fieldset.hasClass('has-error') ){ 
								$fieldset.removeClass('has-error');
								$fieldset.find('.notification').text('');
							}

							if( val=='' ){
								error = true;
								$fieldset.addClass('has-error');
								$fieldset.find('.notification').text('Please choose.');
								return false;
							}

							postData[ obj.key ] = val;

							self.$summary.append('<tr>'+
								'<td class="label">'+ obj.label +'</td>'+
								'<td class="data tar">'+  $input.find(':selected').text() +'</td>'+
							'</tr>');
						});
	

						if( error ){

							$form.find('[type=submit]').addClass('btn-error');
							return;
						}

						Dialog.close();
						self.setWebcam();
					},
					onClose: function () {
						
						if( !postData.ship_to_id ){
							window.history.back();
						}
						
					} 
				});

			}, 1);
	
			
		},
		setElem: function () {
			var self = this;

			self.$canvas = self.$elem.find('canvas');
			self.canvas = self.$canvas[0];

			self.outdiv = self.$elem.find('#outdiv')[0];
			self.v = self.$elem.find('#v')[0];

			self.vidhtml = '<video id="v" autoplay></video>';

			self.$input = self.$elem.find('input[name=code]');
			self.$enter = self.$elem.find('.js-enter');
			self.$listsbox = self.$elem.find('[rel=listsbox]');
			self.$summary = self.$elem.find('[rel=summary]');
			self.$totalPrice = self.$elem.find('.js-total-price');
			self.$totalItem = self.$elem.find('.js-total-item');
			self.$ship_price = self.$elem.find(':input[name=ship_price]');
			self.$save = self.$elem.find('.js-save');


			// event

			self.$input.keypress(function(e) {
			    if(e.which == 13 && $(this).val()!='') {

			    	self.getCode( $.trim($(this).val()) );
			    	$(this).val('');
			    }
			});

			self.$enter.click(function () {
				if(self.$input.val()!='') {

			    	self.getCode( $.trim(self.$input.val()) );
			    	self.$input.val('');
			    }
			});

			self.$elem.delegate('.js-remove-item','click',function(e){

				var data = $(this).closest('li').data();
				if( !data ) return;

				self.$listsbox.find('[item-id='+ data.id +']').remove();
				delete Items[ data.key ];


				if( self.$listsbox.find('[item-id]').length==0 ){

					self.$listsbox.find('[data-id='+ data.parent_id +']').remove();
					delete listsItems[ data.parent_id ];
				}
	

				self.summary();
			});

			self.$elem.delegate('.js-remove-items','click',function(e){

				var $el = $(this).closest('tr');
				var data = $el.data();
				if( !data ) return;

				$.each( $el.find('[item-id]'), function () {
					delete Items[ $(this).data('key') ];
					$(this).remove();
				});

				delete listsItems[ data.id ];
				$el.remove();

				self.summary();
			});

			self.$save.click(function () {
				
				if( $(this).hasClass('disabled') ) return false;

				var	item = [];
				$.each( Items,function (i, obj) {
					item.push( i );
				});

				postData.item = item;
				postData.ship_price = self.$ship_price.val();

				Event.showMsg({ load: true });
	
				$.post( Event.URL + 'shipping/save', postData, function (res) {
					Event.hideMsg();

					if( res.message ){
						Event.showMsg( {
							text: res.message,
							auto: true,
							load: true,
							bg: 'yellow'
						} );
					}

					if( res.error ){

						return false;
					}

					if( res.url ){

						setTimeout(function(){
							window.location = res.url;
						}, 2000);	
					}

				}, 'json');
			});
		},
		setWebcam: function () {
			var self = this;
			if( self.isCanvasSupported() && window.File && window.FileReader){
				self.initCanvas(800, 600);

				qrcode.callback = self.read;
				setwebcam();
			}
			else{
				console.log( 'error' );
			}
		},
		getCode: function ( code, level ) {
			var self = this;

			navigator.vibrate(level || 100);
			$soundBell.play();

			if( !self.$listsbox ){
				self.$listsbox = $('[rel=listsbox]');
			}
			

			if( !Items[ code ] ){
				$.get( Event.URL + 'shipping/getItem', {code: code, status: 1, station: 'me'}, function ( result ) {

					if( result.message ){
						Event.showMsg({
							text: result.message,
							auto: true,
							load: true,
							bg: 'red'
						});
					}

					if( result.error ) return;

					var item, li, data = result.data;

					$.each(self.$listsbox.find( 'tr[data-id]' ), function () {
						if( data.parent_id == $(this).attr('data-id') ){
							item = $(this);
							return false;
						}	
					});

					if( !item ){

						item = self.setItem( data );


						self.$listsbox.append( item );
						listsItems[data.parent_id] = item.data();
					}

					$.each(item.find( '[rel=items] li' ), function () {

						if( data.id == $(this).data('id') ){
							li = $(this);
							return false;
						}

					});

					if( !li ){
						data.key = code;
						item.find('[rel=items]').append( self.setLi(data) );
						Items[ code ] = data;
					}

					self.summary();

				}, 'json');
			}
		},
		
		setItem: function ( data ) {

			var d = {
				id: data.parent_id,
				destination: data.to_code,
				receiver: data.receiver_name,
				price: data.price,
				items: []
			}

			if( data.receiver_phone_number ){
				if( d.receiver=='' ){
					d.receiver = data.receiver_phone_number;
				}
				else{
					d.receiver += '(' +data.receiver_phone_number+ ')'
				}
			}

			var $item = $('<tr>', {'data-id': d.id});

			$item.append( 
				$('<td>', {class: 'label'}).append( 
					$('<div>', {class: ''}).append(
						  $('<span>', {class: 'title'}).text( data.type_name )
						, $('<span>', {class: 'fsm fcg mls count-volue'})
					)
					, $('<div>', {class: 'fsm fcg desc'}).append(
						$('<div>', {class: ''}).append(
						  	  'Destination: '
						  	, d.destination
						)
						, $('<div>', {class: ''}).append( 
							  'Receiver: '
							, d.receiver
						)

					)
					, $('<ul>', {class: 'items', rel: 'items'})
				)
				, $('<td>', {class: 'data tar'}).append( 
					$('<div>', {class: ''}).append(
						  '฿'
						, PHP.number_format(d.price, 2)
					)
					, $('<div>', {class: 'mts clearfix'}).append(
						'<button class="btn-remove btn js-remove-items"><i class="icon-remove"></i></button>'
					)
				)

			);

			$item.data( d );
			
			return $item;
		},
		setLi: function (data) {
			
			li = $('<li>', {'item-id': data.id});

			li.append(
				  $('<i>', {class: 'flaticon-delivery56 mrs'})
				, data.sequence + '/' + data.total_qty
				, '<a type="button" class="mls js-remove-item"><i class="icon-remove"></i></a>'
			);

			li.data( data );
			return li;
		},

		summary: function () {
			var self = this;

			if( !self.$totalPrice ){
				self.$totalPrice = $('.js-total-price');
			}

			if( !self.$totalItem ){
				self.$totalItem = $('.js-total-item');
			}

			if( !self.$save ){
				self.$save = $('.js-save');
			}

			if( !self.$ship_price ){
				self.$ship_price = $(':input[name=ship_price]');
			}

			var total = 0;
			$.each( self.$listsbox.find('[data-id]'), function (i, obj) {
				var data = $(this).data();

				total += parseInt(data.price);
			});

			self.$totalPrice.text( PHP.number_format( total, 2 ) );

			self.$ship_price.val( total );

			var count = Object.keys( Items ).length;
			self.$totalItem.text( PHP.number_format(count,0) + ' ' + ( count > 1 ? 'Items' : 'Item' ) );

			self.$save.toggleClass( 'disabled', total==0 );
		}

	}

	$.fn.shippingCreate = function( options ) {
		return this.each(function() {
			var $this = Object.create( ShippingCreate );
			$this.init( options, this );
			$.data( this, 'shippingCreate', $this );
		});
	};

	$.fn.shippingCreate.options = {
		refresh: 13000,
		minHeigth: 400,
		onOpen: function() {},
		onClose: function() {},
	};
	
})( jQuery, window, document );