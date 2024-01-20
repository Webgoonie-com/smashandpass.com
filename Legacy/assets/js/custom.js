/*------------------------------
 * Copyright 2015 Pixelized
 * http://www.pixelized.cz
 *
 * Progaming theme v1.0
------------------------------*/

$(document).ready(function() {	
	
	
	//NAVBAR
	$('.navbar .nav > li.dropdown').mouseenter(function() {
		$(this).addClass('open');
	});
	
	$('.navbar .nav > li.dropdown').mouseleave(function() {
		$(this).removeClass('open');
	});
	
	$('.countdown').countdown('2019/01/01', function(event) {
	    var $this = $(this).html(event.strftime(''
	      + '<div><span class="countdown-number">%w</span> <span class="countdown-title">weeks</span></div> '
	      + '<div><span class="countdown-number">%d</span> <span class="countdown-title">days</span></div> '
	      + '<div><span class="countdown-number">%H</span> <span class="countdown-title">hours</span></div> '
	      + '<div><span class="countdown-number">%M</span> <span class="countdown-title">minutes</span></div> '
	      + '<div><span class="countdown-number">%S</span> <span class="countdown-title">seconds</span></div>'));
	});
	
	//VEGAS
	//$.vegas({src:'assets/images/background-1.jpg'})('overlay', {src:'assets/images/overlay.png'});
	
	//SCROLLING
	$("a.scroll[href^='#']").on('click', function(e) {
		e.preventDefault();
		var hash = this.hash;
		$('html, body').animate({ scrollTop: $(this.hash).offset().top - 110}, 1000, function(){window.location.hash = hash;});
	});
	
	//BLOG POST - CAROUSEL
	$(".gallery-post .owl-carousel").owlCarousel({
		navigation : true,
		singleItem : true,
		pagination : false,
		autoPlay: 5000,
		slideSpeed : 500,
		navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]
  	});
	
	//OWL CAROUSEL
	$("#jumbotron-slider").owlCarousel({
		pagination : false,
		itemsDesktop :[1200,3],
		itemsDesktopSmall :[991,2],
		items : 3,
		navigation : true,
		navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]
  	});
	
	$('#open-search').on('click', function() {
		$(this).toggleClass('show2 hidden');
		$('#close-search').toggleClass('show2 hidden');
		$("#navbar-search-form").toggleClass('show2 hidden animated fadeInDown');
		return false;
	});
	$('#close-search').on('click', function() {
		$(this).toggleClass('show2 hidden');
		$('#open-search').toggleClass('show2 hidden');;
		$("#navbar-search-form").toggleClass('fadeInDown fadeOutUp');
		setTimeout(function(){
			$("#navbar-search-form").toggleClass('show2 hidden animated fadeOutUp');
		}, 500);
		return false;
	});
	
	$('.gallery-page').each(function() { // the containers for all your galleries
		$(this).magnificPopup({
			delegate: 'div a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-with-zoom mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			}
		});
	}); 




	
	//FORM TOGGLE
	$('#reset-password-toggle').click(function() {
        $('#reset-password').slideToggle(500);
    });
	
});



