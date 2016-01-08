
$(document).ready(function() { 
	$('ul.menu').superfish({ 
		delay:       600,                            // one second delay on mouseout 
		animation:   {height:'show'},  // fade-in and slide-down animation 
		speed:       'normal',                          // faster animation speed 
		autoArrows:  false,                           // disable generation of arrow mark-up 
		dropShadows: false                            // disable drop shadows 
	}); 
	
	$(".menu > li > a.active").append('<strong></strong>');

	if ($('#main-menu').width() == '940' || $('#main-menu').width() == '748') {BorderHeight = '9px'}
		else {BorderHeight = '9px'}
		
		

	
	$('.menu > li > a.active strong, .menu > li.sfHover > a strong').css({height:BorderHeight});
	
	$(".menu > li > a").hover(
		function(){
			$(this).not('.active').append('<strong></strong>').stop().animate({backgroundPosition:'0 0px'}, 100).find('strong').stop().delay(100).animate({height:BorderHeight}, 100);
		}, 
		function(){
			$(this).parent('li').not('.sfHover').find('>a').not('.active').find('strong').stop().animate({height:'0'}, 100).parents('a').stop().delay(100).animate({backgroundPosition:'0 -90px'}, {
					duration:100,
					complete: function(){$(this).find('strong').remove()}
			});
		}
	);
	
	$(".img-border").hover(
		function(){$(this).stop().animate({backgroundColor:'#7ab436'}, 300);}, 
		function(){$(this).stop().animate({backgroundColor:'#fff'}, 300);}
	);
	
	$(".button.st1").hover(
		function(){$(this).parents('.button-wrapper').prepend('<div class="button-line2"></div>').find('.button-line2').stop().animate({left:'0', width: $(this).parents('.button-wrapper').width()}, 150);}, 
		function(){$(this).parents('.button-wrapper').find('.button-line2').stop().animate({left:'50%', width: 0}, {
								duration: 150, 
								complete: function() {$(this).parents('.button-wrapper').find('.button-line2').remove()
								}
							});
		}
	);

	$(".social-buttons li a").hover(
		function(){$(this).stop().animate({height:'32px'}, 100).parent('li').stop().animate({paddingTop:'0px'}, 100);}, 
		function(){$(this).stop().animate({height:'29px'}, 100).parent('li').stop().animate({paddingTop:'3px'}, 100);}
	);	
	
}); 

	$(window).load(function(){
		$().UItoTop({ easingType: 'easeOutQuart' });
	})
	
	function goToByScroll(id){
		$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
	}

$(window).resize(function(){
	if ($('#main-menu').width() == '940' || $('#main-menu').width() == '748') {BorderHeight = '9px'}
		else {BorderHeight = '6px'}
	$('.menu > li > a.active strong, .menu > li.sfHover > a strong').css({height:BorderHeight});
});


$(function(){

// Slider
	$('#slides').slides({
		effect: 'fade',
		fadeSpeed:700,
		preload: true,
		play: 4000,
		pause: 4000,
		generateNextPrev: true,
		generatePagination: true,
		crossfade: true,
		hoverPause: true,
		animationStart: function(current){
			$('.caption').animate({opacity:0});
			if (window.console && console.log) {
				console.log('animationStart on slide: ', current);
			};
		},
		animationComplete: function(current){
			$('.caption').animate({opacity:1});
			if (window.console && console.log) {
				console.log('animationComplete on slide: ', current);
			};
		},
		slidesLoaded: function() {
			$('.caption').animate({opacity:1});
		}
	});
});




