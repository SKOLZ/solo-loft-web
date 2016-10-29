function mainmenu(){
jQuery(" #nav ul ").css({display: "none"}); // Opera Fix
jQuery(" #nav li").hover(function(){
		jQuery(this).find('ul:first').css({visibility: "visible",display: "none"}).show(200);
		},function(){
		jQuery(this).find('ul:first').css({visibility: "hidden"});
		});
}

 
 
 jQuery(document).ready(function(){					
	mainmenu();
});