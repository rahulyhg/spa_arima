
var POs = {
	init: function () {
		
	},

	chooseMenu: function ( id ) {
		var self = this;

		self.loadMenu( {
			date: PHP.dateJStoPHP( currOrder.date ),
			type: 'package',
			id: id
		} ).done(function ( data ) {

			self.updateMenu(data);	
		});
	},
	loadMenu: function ( formData ) {
		
		return $.ajax({
			// type: "GET",
			url:  Event.URL + 'orders/menu',
			data: formData,
			dataType: 'json',
		}).always(function() { // complete
			Event.hideMsg();
		}).fail(function(  ) { // error
			Event.showMsg({ text: "เกิดข้อผิดพลาด...", load: true , auto: true });
		});
	},

	updateMenu: function (data) {
		console.log( data );
		
	}
}


var $body = $('body');
var theDate = new Date();


var _ative = 'menu';
var currOrder = {};

var Page = {
	lang: $('html').attr( 'lang' )
}


function resize() {

	// payment-pay-number
}

/**/
/* payment pay */
/**/
var pay = {

	resize: function () {
		
		var $el = $('#payment');

		var h = ($('[role=main]').height() - 300) / 4;
		
		head = $el.find('.payment-header').outerHeight();
		var	h = ($el.find('.payment-content').width() - 85) / 4;

		var $number = $el.find('.payment-pay-number');


		$number.find('li>a').css({
			width: h,
			height: h,
			lineHeight: h+'px'
		});
		
	}
}


var bill = {

	resize: function () {
		
		var $el = $('.slipPaper-container');

		// var h = ($('[role=main]').height() - 300) / 4;
		
		// var head = ;
		// var	h = ($el.find('.payment-content').width() - 85) / 4;

		// var $number = $el.find('.payment-pay-number');

		$el.find('.slipPaper-bodyContent').css({
			top: $el.find('.slipPaper-bodyHeader').outerHeight() + 20,
			bottom: $el.find('.slipPaper-bodyFooter').outerHeight()
			/*height: h,
			lineHeight: h+'px'*/
		});

	},

	setData: function ( data ) {
		var self = this;

		currOrder = {
			date: new Date( data.date || theDate),
			summary: {
				subtotal: parseInt( data.subtotal ) || 0,
				total: parseInt( data.total )|| 0,
				discount: parseInt( data.discount )|| 0,
				drink: parseInt( data.drink )|| 0,
				balance: parseInt( data.balance )|| 0,
				room_price: parseInt( data.room_price )||0,
				pay: parseInt( data.pay )||0,
				change: parseInt( data.change )|| 0,
			},
			cus_qty: 1,
			lists: []
		}

		self.update();
		bill.resize();
	},

	update: function () {
		var self = this;

		// date
		$('[data-bill=date]').text( Datelang.fulldate( currOrder.date, 'normal', Page.lang, 1 ) );
		
		$('[data-bill=cus_qty]').text( currOrder.cus_qty || 1 );
		$('[data-bill=number]').addClass('hidden_elem');

		/* member */
		if( currOrder.member ){
			$('[data-bill=member]').removeClass('hidden_elem');
		}
		else{
			$('[data-bill=member]').addClass('hidden_elem');
		}

		// orderlists
		$('[role=orderlists]').empty();

		// btn pay
		$('[data-bill-action=pay]').addClass('disabled');

		bill.sum();
		bill.sumDisplay();

		console.log( currOrder );
	},
	getNumber: function () {
		var self = this;

		$.get( Event.URL + 'orders/lastNumber', {date: PHP.dateJStoPHP( currOrder.date ) }, function (number) {

			self.setNumber(parseInt( number ), callback);

		}, 'json');	
	},
	setNumber: function (number) {
		var self = this;

		// console.log( number );
	},

	sum: function () {
		var a = [0,0,0];
		for (var obj in currOrder.items) {
			var data = currOrder.items[obj];

			data.cost = data.qty*data.price;
			data.balance = data.cost - data.discount;

			a[0] += data.cost;
			a[1] += data.discount;
		}

		currOrder.summary.total = a[0];
		currOrder.summary.discount = a[1];

		currOrder.summary.balance = (a[0] + currOrder.summary.drink + currOrder.summary.room_price) - a[1];
	},
	sumDisplay: function () {
		var self = this;
			
		$.each( currOrder.summary, function (key, val) {
			$('[data-bill-summary='+ key +']').text( PHP.number_format(val) );
		} );
	}
}

var menu = {
	load: function () {
		
	}
}

function active() {

	$('[data-global='+ _ative +']').addClass('active').siblings().removeClass('active');
}

$(function () {

	$('[data-global=date]').datepicker({
		onComplete: function ( date ) {
			theDate = new Date( date );
			bill.setData({});
		},
		onSelected: function ( date ) {
			currOrder.date = new Date( date );
			bill.update();
		}
	});


	/* data-bill-set */
	$('[data-bill-set]').click(function (e) {
		e.preventDefault();

		var data = {
			type: $(this).attr('data-bill-set')
		};

		if( data.type=='cus_qty' ){
			data.value = currOrder.cus_qty;
		}

		if( data.type=='drink' ){
			data.drink = currOrder.summary.drink;
		}

		Dialog.load( Event.URL+'orders/set_bill', data, {

			onSubmit: function ( $el ) {
							
				if( data.type=='drink' ){
					currOrder.summary.drink = parseInt( $.trim($el.$pop.find('#drink').val()) ) || 0;
					Dialog.close();
				}

				// 
				if( data.type=='cus_qty' ){
					currOrder.cus_qty = parseInt( $.trim($el.$pop.find('#cus_qty').val()) ) || 1;

					Dialog.close();
				}

				bill.update();
			}
			
		} );
	});
	

	setTimeout( function () {
		pay.resize();

		bill.resize();
	}, 1000);

	$(window).resize(function () {
		pay.resize();
	});

	
	active();

	// var elem = $(window)[0]; // Make the body go full screen.
	// toggleFullScreen();
	$('[data-nav]').click(function () {

		var url = $(this).attr('ajaxify');
		var data = {
			date: PHP.dateJStoPHP( theDate )
		}
		Dialog.load( url, data, {});
	});

	$('.js-navigation-trigger').click(function () {

		var $page = $('#doc');

		if( !$('body').hasClass('is-pushed-left') ){

			var scroll = $(window).scrollTop()*-1;
			$page.addClass('fixed_elem').css('top', scroll);

			setTimeout(function () {
				$('body').addClass('is-pushed-left');
			},200);
		}
		else{
			
			var scroll = parseInt( $page.css("top"));
				scroll = scroll<0 ? scroll*-1:scroll;

			$('body').removeClass('is-pushed-left');

			$page.removeClass('fixed_elem').css('top', "");
			$(window).scrollTop( scroll );

		}
	});

	// RefClock( $('.headerClock'), $('html').attr('lang') );
	// 

	$('.js-global-actions>[data-global-action]').click(function (e) {
		if( $(this).hasClass('active') && $(window).width() <= 1300 ){
			e.stopPropagation();
			e.preventDefault();
			$(this).parent().addClass('active');
		}
	});

	$(window).click(function () {
		if( $('.js-global-actions').hasClass('active') ){
			$('.js-global-actions').removeClass('active');
		}
	});

	/* Menu */
	$('[data-memu=package] [data-id]').click(function () {
		POs.chooseMenu( $(this).data('id') );
	});
});


