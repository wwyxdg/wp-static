/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2019-03-18 17:47:07
 * @Last Modified by: suxing
 * @Last Modified time: 2019-08-14 20:48:09
*/
/* ---------------------------------------------- /*
	* POPUP 
/* ---------------------------------------------- */
if (typeof jQuery != 'undefined') {
	var $ = jQuery.noConflict();
}

function ncPopupTips(type, msg) {
	var ico = type ? '<div class="text-center text-success mb-2"><span class="svg-success"></span></div>' : '<div class="text-center text-danger mb-2"><span class="svg-error"></span></div>';
	var c = type ? 'tips-success' : 'tips-error';
	var html = '<section class="nice-tips '+c+' nice-tips-sm nice-tips-open">'+
					'<div class="nice-tips-overlay"></div>'+
                    '<div class="nice-tips-body text-center">'+
	                    '<div class="nice-tips-content px-5">'+ico+
	                        '<div class="text-sm text-muted">'+msg+'</div>'+
	                    '</div>'+
                    '</div>'+
                '</section>';
    var tips = $(html);
	$('body').append(tips);
	$('body').addClass('modal-open');
	if (typeof lazyLoadInstance !== "undefined") {
		lazyLoadInstance.update();
	}

	setTimeout(function(){
		$('body').removeClass('modal-open');
		tips.removeClass('nice-tips-open');
		tips.addClass('nice-tips-close');

		setTimeout(function(){
			tips.removeClass('nice-tips-close');
			setTimeout(function(){
				tips.remove();
			}, 200);
		},400);
	},1200);
}

function ncPopup(type, html, maskStyle, btnCallBack) {

	var maskStyle = maskStyle ? 'style="' + maskStyle + '"' : '';

	var size = '';

	if( type == 'big' ){
		size = 'nice-tips-lg';
	}else if( type == 'no-padding' ){
		size = 'nice-tips-nopd';
	}else if( type == 'cover' ){
		size = 'nice-tips-cover nice-tips-nopd';
	}else if( type == 'full' ){
		size = 'nice-tips-xl';
	}else if( type == 'scroll' ){
		size = 'nice-tips-scroll';
	}else if( type == 'middle' ){
		size = 'nice-tips-md';
	}else if( type == 'small' ){
		size = 'nice-tips-sm';
	}

	var template = '\
	<div class="nice-tips ' + size + ' nice-tips-open">\
		<div class="nice-tips-overlay" ' + maskStyle + '></div>\
		<div class="nice-tips-body">\
			<div class="nice-tips-close">\
				<span class="svg-white"></span>\
				<span class="svg-dark"></span>\
			</div>\
			<div class="nice-tips-content">\
				'+html+'\
			</div>\
		</div>\
	</div>\
	';

	var popup = $(template);
	$('body').append(popup);
	$('body').addClass('modal-open');
	if (typeof lazyLoadInstance !== "undefined") {
		lazyLoadInstance.update();
	}

	var close = function(){
		$('body').removeClass('modal-open');
		$(popup).removeClass('nice-tips-open');
		$(popup).addClass('nice-tips-close');
		setTimeout(function(){
			$(popup).removeClass('nice-tips-close');
			setTimeout(function(){
				popup.remove();
			}, 200);
		},600);
	}

	$(popup).on('click touchstart', '.nice-tips-close, .nice-tips-overlay', function(event) {
		event.preventDefault();
		close();
	});


	if( typeof btnCallBack == 'object' ){
		Object.keys(btnCallBack).forEach(function(key){

			$(popup).on('click touchstart', key, function(event) {

				var ret = btnCallBack[key](event, close);

			});

		});
	}
	return popup;
}

/* ---------------------------------------------- /*
	* OTHERS 
/* ---------------------------------------------- */

$(document).ready(function() {
	$('.post-video .wp-video').attr('style', '')
	$('.post-video video').attr('width', '100%')
	$('.post-video video').attr('height', null)

	if (typeof globals !== 'undefined' && globals.comment_ip === '1') {
		var locale = navigator.language || 'zh-CN'
		$('.author-ip').each(function() {
			var ip = $(this).data('ip') + ''
			var that = this
			if (ip.split('.').length !== 4) return
	
			$.ajax({
				url: 'http://ip-api.com/json/' + ip + '?lang=' + locale
			})
				.done(function (response) {
					$(that).text(response.city)
				})
		})
	}
})

