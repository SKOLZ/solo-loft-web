$(document).ready(function(){
						   
	// Menu
	$('#menu li:first').addClass('first');
	$('#menu li:last').addClass('last');
	
	// Menu desplegable quienes somos
   	$('#menu li:has(ul)').hover( 
      function(e) 
      { 
         $(this).find('ul').show();
		 $("a:first", this).addClass('activo');
      }, 
      function(e) 
      { 
         $(this).find('ul').fadeOut('fast'); 
		 $("a:first", this).removeClass('activo');
      } 
   	);

	// Opacity img
	$(".descargas-carousel img").css('opacity','0.60');
	$(".descargas-carousel img").hover(function () { // on mouse over
		$(this).stop().animate({opacity: 1}, "normal");
	},
	function () { // on mouse out
		$(this).stop().animate({opacity: 0.60}, "normal");
	});
});


// Carouseles
$(document).ready(function() {
    $('#productos-menu').jcarousel({scroll: 7, easing: 'easeInOutBack', animation: 1500});
	$('.descargas-carousel').jcarousel({scroll: 3, easing: 'easeOutBounce', animation: 1500});
});

// COLORBOX
$(document).ready(function(){
	$('.colorbox').colorbox({transition:'fade', opacity:0.85, maxWidth:'80%', maxHeight:'80%', initialWidth: '200px', initialHeight: '200px',  current: "imagen {current} de {total}"});
});

// ANYTHINGSLIDER
$(function () {
	$('#slider').anythingSlider({
		startStopped    	: false,
		delay               : 6000,
		animationTime       : 800,
		easing              : "easeInOutQuad",
		buildNavigation     : false
		
	});
});

$(function () {
	$('#slider-home').anythingSlider({
		startStopped    	: false,
		delay               : 6000,
		animationTime       : 800,
		easing              : "easeInOutQuad",
		width				: 617,
		height              : 335
	});
});


$(document).ready(function(){
	// Menu
   	$('.lista_jquery a').click( 
      function() 
      { 
	  	$('.lista_jquery a').removeClass('activo');
		 $(this).addClass('activo');
      }
   	);
});


// INPUTS
function eFocus(field){if (field.value == field.defaultValue){field.value ='';}}
function eBlur(field){if (field.value == ''){field.value = field.defaultValue;}}

// REFRESCA EL CAPTCHA;
function captchaRefresh(){rand = $.random(99999);$('#captcha_container-cont').attr('src', 'captcha.php?'+rand)}