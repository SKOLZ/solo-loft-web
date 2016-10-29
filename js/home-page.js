function extractUrl(input) {
	return input.replace(/"/g,"").replace(/url\(|\)jQuery/ig, "");
}
 
function hitTest(offsetLeft, totalWidth, itemCount, event) {
	var pos = 0;
	var itemWidth = totalWidth/itemCount;

	perc = offsetLeft / totalWidth;
	index = perc*itemCount;
	
	if (event == 'click') {
		index = Math.floor(index);
	} else if (event == 'drag') {
		index = Math.round(index);
	}
	
	return index;
}

(function (jQuery) {
   jQuery.fn.liveDraggable = function (opts) {
      this.live("mouseover", function() {
         if (!jQuery(this).data("init")) {
            jQuery(this).data("init", true).draggable(opts);
         }
      });
   };
}(jQuery));

var timer;
var jQueryslideshow = jQuery('.home-slideshow-holder');

homeCarousel = {
	type: 'both', // slideshow | draggable | both | none
	intervalTime:5000,
	slideTime: 800,
	currentSlide: 0,
	windowWidth: 0,
	slidesCount: 0,
	sliding: false,
	init: function(){
		// Setting globals
		this.slidesCount = jQueryslideshow.find('.slide').length;
		
		// On resize
		this.setWidths();
		jQuery(window).resize( function() {
			homeCarousel.setWidths();
		});
		
		// Preloading
		jQueryslideshow.find('.slide').each(function(i,v){
			bgImg = jQuery(v).css('background-image');
			bgImg = extractUrl(bgImg);

			// Set img loads
			var imageObj = new Image();
			jQuery(imageObj).attr("src", bgImg).load(function(response) {
				jQueryslideshow.find('.slide:eq('+i+')').removeClass('loading');
				
			}); 

			// Last image loaded! do some stuff
			if (i+1 == homeCarousel.slidesCount) {
				
				// Remove layer
				jQuery('.preload-layer img').delay(2000).animate({'opacity':0},500,function(){
					jQuery('.preload-layer').animate({'opacity':0},1000,function(){
						jQuery('.preload-layer').remove();
						// Set slideshow
						if (homeCarousel.type == 'slideshow' || homeCarousel.type == 'both') {
							homeCarousel.setSlideShow();
						}
					})
					jQuery('.info-panel').css({'display':'block'}).animate({opacity:1},2000);
					jQuery('#main-logo').css({'display':'block'}).animate({opacity:1},2000);
					jQuery('.gallery-button-holder').css({'display':'block'}).animate({opacity:1},2000);
				})
				
			}
			
		})

		// Loading gif
		jQuery('.home-slideshow .slide').addClass('loading');
		
		// Drag!
		if (this.type == 'draggable' || this.type == 'both')
			this.setDraggable();
		
		if (this.type == 'none')
			jQuery('.home-slideshow-drag').remove();
		
		// Enable slidebar click
		homeCarousel.setClickDragbar();

		// Keystrokes!
                jQuery(document).keydown(function(e) {
		  switch(e.keyCode) { 
			 case 37: // Move left
				homeCarousel.slideDirection('prev');
			 break;
			 case 39: // Move right
				 homeCarousel.slideDirection('next');
			 break;
		  }
                });


		// Swipe!
		jQuery(document).wipetouch({
			 wipeLeft: function() { 

				if (homeCarousel.currentSlide != homeCarousel.slidesCount && !homeCarousel.sliding) {
					clearTimeout(timer);
					jQuery('.home-slideshow, .bar').stop();
					homeCarousel.moveSlide(homeCarousel.currentSlide);
				} else if (!homeCarousel.sliding) {
					clearTimeout(timer);
					jQuery('.home-slideshow, .bar').stop();
					homeCarousel.moveSlide(0);
				}
					
			 },
			 wipeRight: function() { 
			 }
		})
		
		// Carousel navigation
		jQuerycarouselNav = jQuery('.gallery-button-holder');
		jQuerycarouselNav.find('a').click(function(){
			homeCarousel.slideDirection(jQuery(this).attr('class'));
                        return false;
		});
	},
	setWidths: function() {
		this.windowWidth = jQuery(window).width();
				
		jQueryhomeSlideshow = jQueryslideshow.find('.home-slideshow');
				
		jQueryhomeSlideshow.
			width( this.windowWidth * this.slidesCount );
		
		jQueryhomeSlideshow.find('.slide').
			width( this.windowWidth );
		
		jQuery('.home-slideshow-drag .bar').
			width( jQuery('.home-slideshow-drag').width() / this.slidesCount );	
		
		// Align current slide to left
		jQueryhomeSlideshow.css({'margin-left':parseInt('-'+homeCarousel.windowWidth*homeCarousel.currentSlide)});
			
	},
	pauseSlideShow: function() {
		clearTimeout(timer);
		jQueryslideshow.find('.home-slideshow').stop();
	},
	continueSlideShow: function() {
		homeCarousel.moveSlide(homeCarousel.currentSlide,'right');
	},
	setClickDragbar: function() {
		jQuery('.home-slideshow-drag').click(function(e){
			if (jQuery('.home-slideshow.new').length == 0 && !jQuery(e.target).hasClass('bar') ) {
				var x = e.pageX - this.offsetLeft;

				nextSlide = hitTest (x, jQuery('.home-slideshow-drag').width(), homeCarousel.slidesCount, 'click');
				nextSlide = nextSlide - 1;

				clearTimeout(timer);
				jQuery('.home-slideshow, .bar').stop();

				homeCarousel.moveSlide(nextSlide, 'right');
			}
		});
	},
	setSlideShow: function() {
		timer=setTimeout('homeCarousel.moveSlide(0,"right")',homeCarousel.intervalTime);
	},
	setDraggable: function() {
		jQuery( ".home-slideshow-drag .bar" ).liveDraggable({ 
			containment: ".home-slideshow-drag ", 
			axis: "x", 
			cursor: "move",
			start: function() {
				
				jQuery( ".home-slideshow-drag").unbind('click');   // Disable slidebar click
				homeCarousel.pauseSlideShow();
			},
			drag: function() {
				
				pos = jQuery( ".home-slideshow-drag .bar" ).position();
				nextSlide = hitTest (pos.left, jQuery('.home-slideshow-drag').width(), homeCarousel.slidesCount, 'drag');
		 			
				if (homeCarousel.currentSlide != nextSlide)
					homeCarousel.dragSlide(nextSlide);
			},
			stop: function() {

				homeCarousel.setClickDragbar();	 // Enable slidebar click
				jQuery('.bar').stop().animate({
					'left':jQuery('.home-slideshow-drag .bar').width()*(homeCarousel.currentSlide)}, 500, 'easeOutQuint'
				);
				clearTimeout(timer);
				timer=setTimeout("homeCarousel.continueSlideShow()",homeCarousel.intervalTime);
			}
		});
	   
	},
	dragSlide: function(index) {
		homeCarousel.currentSlide = index;
		
		// Drag slide
		jQueryslideshow.find('.home-slideshow').stop().animate({
			'margin-left':'-'+homeCarousel.windowWidth*index},
			homeCarousel.slideTime,
			'easeOutQuint'
		);
	},
	slideDirection: function (direction) {
		if (direction == 'prev') {
			if (homeCarousel.currentSlide == 0 && !homeCarousel.sliding) {

			} else if (!homeCarousel.sliding) {
				clearTimeout(timer);
				jQuery('.home-slideshow, .bar').stop();
				homeCarousel.moveSlide(homeCarousel.currentSlide,'left');
			}
		} else if (direction == 'next'){
			if (homeCarousel.currentSlide != homeCarousel.slidesCount && !homeCarousel.sliding) {
				clearTimeout(timer);
				jQuery('.home-slideshow, .bar').stop();
				homeCarousel.moveSlide(homeCarousel.currentSlide, 'right');
			} else if (!homeCarousel.sliding) {
				clearTimeout(timer);
				jQuery('.home-slideshow, .bar').stop();
				homeCarousel.moveSlide(0,'right');
			}
		}
	},
	moveSlide: function(index, direction) {
		
		if ( !this.sliding ) {
			
			this.sliding = true;
			jQuery( ".home-slideshow-drag").unbind('click'); // Disable slidebar click
			this.disableDraggable();					// Disable drag

			if(direction == 'right' || direction == 'next') {
				index++;
			} else {
				index--;
			}
			
			this.currentSlide = index;

			jQuery('.container').html(index + ' - ' + this.slidesCount);

			// Check if end is reached
			if ( index == this.slidesCount ) {
				
				// Clone for rerun
				jQueryslideshow.find('.home-slideshow')
					.addClass('old')
					.clone()
					.appendTo('.home-slideshow-holder')
					.removeClass('old')
					.addClass('new')
					.css('margin-left',homeCarousel.windowWidth);


				if ( jQuery('.slide-0 video').length ) {
					jQuery('.home-slideshow.new .slide-0').remove();
					jQuery('.home-slideshow.old .slide-0').prependTo('.home-slideshow.new');					
				}


				jQuery('.home-slideshow-drag .bar')
					.addClass('old')
					.clone()
					.appendTo('.home-slideshow-drag')
					.removeClass('old')
					.addClass('new')
					.css('left',-200);


				// Goodbye old
				jQuery('.home-slideshow.old').animate({
					'margin-left':'-'+homeCarousel.windowWidth*index},
					homeCarousel.slideTime,
					'easeOutQuint'
				);
				jQuery('.bar.old').animate({
					'left':jQuery('.home-slideshow-drag .bar').width()*index}, homeCarousel.slideTime, 'easeOutQuint'
				);

				// Hello new
				jQuery('.home-slideshow.new').animate({
					'margin-left':0}, homeCarousel.slideTime, 'easeOutQuint', 
					function() {
						jQuery('.home-slideshow.new').removeClass('new');
						jQuery('.home-slideshow.old').remove();
						homeCarousel.currentSlide = 0;
						timer=setTimeout('homeCarousel.moveSlide(0,"right")',homeCarousel.intervalTime);
					}
				);
				jQuery('.bar.new').animate({
					'left':0}, homeCarousel.slideTime, 'easeOutQuint',
					function() {
						jQuery('.bar.new').removeClass('new');
						jQuery('.bar.old').remove();
						homeCarousel.enableDraggable();		// Enable drag
						homeCarousel.setClickDragbar();		// Enable slidebar click
						homeCarousel.sliding = false;
					}
				);


			} else {

				// Slide
				jQueryslideshow.find('.home-slideshow').animate({
					'margin-left':'-'+homeCarousel.windowWidth*index}, homeCarousel.slideTime, 'easeOutQuint', 
					function() { 
						timer=setTimeout('homeCarousel.moveSlide('+index+',"right")',homeCarousel.intervalTime);
					}
				);

				jQuery('.home-slideshow-drag .bar').animate({
					'left':jQuery('.home-slideshow-drag .bar').width()*index}, homeCarousel.slideTime, 'easeOutQuint', 
					function() {
						homeCarousel.enableDraggable();	// Enable drag
						homeCarousel.setClickDragbar();	// Enable slidebar click
						homeCarousel.setWidths();
						homeCarousel.sliding = false;
					}
				);

			}
			
		}

	},
	disableDraggable: function() {
		jQuery( ".bar" ).draggable( "option", "disabled", true );
	}
	,
	enableDraggable: function() {
		jQuery( ".bar" ).draggable( "option", "disabled",  false );
	}
}

	
var ani, jQuerycarousel, jQuerycarouselList, imgWidth, imgHeight, animating;