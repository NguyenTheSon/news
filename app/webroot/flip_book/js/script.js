window.pages = ['home', 'about', 'about', 'works', 'works', 'events', 'events', 'contact', 'contact'];

function getURL() {
	return window.location.href.split('#').shift();
}
function getHash() {
	return window.location.hash.slice(1);
}

function checkHash(hash) {
	//$('.shadow_open').show();
	var hash = getHash(), k;
	if ((k=jQuery.inArray(hash, pages))!=-1) {
		$('#menu li a').each(function(index, value) {
	if ($(value).attr('href').indexOf(hash)!=-1)
		$(value).addClass('on');
	else
		$(value).removeClass('on');
	
});
	return k+1;
	
}
	return 1;
	
}

function rotated() {
	return Math.abs(window.orientation)==90;
}
function isPhone() {
	return navigator.userAgent.match(/iPhone/i);
}
function resizeViewport() {
	$('#viewport').css({width: $(window).width(), height: (isPhone() && !rotated()) ? 1670 : $(document).height()});
}
function setScroll() {
	if (isPhone())
	window.scrollTo(0, (rotated()) ? $('#magazine').offset().top-6 : 1);
}

function moveMagazine(page) {
	var that = $('#magazine'),
	rendered = that.data().done,
	width = that.width(),
	pageWidth = width/2,
	total = that.data().totalPages,
	options = {duration: (!rendered) ? 0 : 600, easing: 'easeInOutCubic', complete: function(){ $('#magazine').turn('resize'); }};
	$('#controllers').stop();
	if (page==total)
		$('#shadow-page').fadeOut(0);
	if ((page==1 || page == total) && !rotated()) {
		var leftc = ($(window).width()-width)/2,
		leftr = ($(window).width()-pageWidth)/2,
		leftd = (page==1)? leftr - leftc - pageWidth : leftr - leftc;
		$('#controllers').animate({left: leftd}, options);
		$('.left_block_bg').animate({left:361}, 0);
		//$('.shadow_open').hide();		
	} else {
		$('#shadow-page').fadeOut('fast');
		$('#controllers').animate({left: 0}, options);
		$('.left_block_bg').animate({left:-210}, 0);
	}
}

$(document).ready(function() {
	/* Turn events */
	$('#magazine').
		bind('turn', function(e, page){
		moveMagazine(page);
	}).
		bind('turned', function(e, page, pageObj) {
	var rendered = $(this).data().done;
		moveMagazine(page);
	if (!rendered) {
		$('#controllers').fadeIn();
	} else {
	jQuery.each(pages, function(index, value) {
		if (page==index+1) {
		var newUrl = getURL() + '#' + value;
		window.location.href = newUrl;
		return false;
	}
});
}

});


/* Window events */
$(window).bind('keydown', function(e){
	if (e.keyCode==37)
		$('#magazine').turn('previous');
	else if (e.keyCode==39)
		$('#magazine').turn('next');
	}).bind('hashchange', function() {
	var page = checkHash();
	if (pages!=$('#magazine').turn('page'))
		$('#magazine').turn('page', page);
	}).bind('touchstart', function(e) {

	var t = e.originalEvent.touches;
	if (t[0]) touchStart = {x: t[0].pageX, y: t[0].pageY};
		touchEnd = null;
	}).bind('touchmove', function(e) {

	var t = e.originalEvent.touches, pos = $('#magazine').offset();
	if (t[0].pageX>pos.left && t[0].pageY>pos.top && t[0].pageX<pos.left+$('#magazine').width() && t[0].pageY<pos.top+$('#magazine').height()) {
	if (t.length==1)
		e.preventDefault();
	if (t[0]) touchEnd = {x: t[0].pageX, y: t[0].pageY};
	}
	}).bind('touchend', function(e) {
	if (window.touchStart && window.touchEnd) {
		var that = $('#magazine'),
		w = that.width()/2,
		d = {x: touchEnd.x-touchStart.x, y: touchEnd.y-touchStart.y},
		pos = {x: touchStart.x-that.offset().left, y: touchStart.y-that.offset().top};
		if (Math.abs(d.y)<100)
			if (d.x>100 && pos.x<w)
				$('#magazine').turn('previous');
		else if (d.x<100 && pos.x>w)
		$('#magazine').turn('next');
	}
	}).resize(function() {
	$('#magazine').turn('resize');
	resizeViewport();
	});
	
	$('#magazine').children(':first').bind('flip', function() {
	}).find('p').fadeOut(0).fadeIn(2000);
	$('body').bind('orientationchange', function() {
	resizeViewport();
	setScroll();
	moveMagazine($('#magazine').turn('page'));
	});
	/* Create internal instance */
	if ($(window).width()<=1200)
	{
		console.log("vao");
		$('body').addClass('x1024');
	}
	
	$('#magazine').turn({page: checkHash(), gradients: !$.isTouch, acceleration: $.isTouch, elevation: 50});
	resizeViewport();
	setScroll();
}); 