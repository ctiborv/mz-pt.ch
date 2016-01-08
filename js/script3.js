
$(document).ready(function() { 
	$('ul.menu-content').superfish({ 
		delay:       600,                            // one second delay on mouseout 
		animation:   {height:'show'},  // fade-in and slide-down animation 
		speed:       'normal',                          // faster animation speed 
		autoArrows:  false,                           // disable generation of arrow mark-up 
		dropShadows: false                            // disable drop shadows 
	}); 
	
	$(".menu-content > li > a.active").append('<strong></strong>');

	if ($('#main-menu-content').width() == '940' || $('#main-menu-content').width() == '748') {BorderHeight2 = '42px'}
		else {BorderHeight2 = '42px'}
		
		

	
	$('.menu-content > li > a.active strong, .menu-content > li.sfHover > a strong').css({height:BorderHeight2});
	
	$(".menu-content > li > a").hover(
		function(){
			$(this).not('.active').append('<strong></strong>').stop().animate({backgroundPosition:'0 0px'}, 100).find('strong').stop().delay(100).animate({height:BorderHeight2}, 100);
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
	if ($('#main-menu').width() == '940' || $('#main-menu').width() == '748') {BorderHeight2 = '9px'}
		else {BorderHeight2 = '6px'}
	$('.menu-content > li > a.active strong, .menu-content > li.sfHover > a strong').css({height:BorderHeight2});
});



       



