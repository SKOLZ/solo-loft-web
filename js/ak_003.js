/* BUG SOLVE
 *
 * This code solves many problems related to when IE6 users have page loads set to always
 ************************************************************************************************/
try {
  document.execCommand("BackgroundImageCache", false, true);
} catch(err) {}

function scrollbarWidth() {
	// Scrollbalken im Body ausschalten
	document.body.style.overflow = 'hidden';
	var width = document.body.clientWidth;
 
	// Scrollbalken
	document.body.style.overflow = 'scroll';
 
	width -= document.body.clientWidth;
 
	// Der IE im Standardmode
	if(!width) width = document.body.offsetWidth-document.body.clientWidth;
 
	// urspr?ngliche Einstellungen
	document.body.style.overflow = '';
 
	return width;
}

// Inheritance function courtesy Ross Harmes/Dunstan Diaz
var extend = function(subClass, superClass) {
	var F = function() {};
	F.prototype = superClass.prototype;
	subClass.prototype = new F();
	subClass.prototype.constructor = subClass;
	subClass.superClass = superClass.prototype;
	if (superClass.prototype.constructor == Object.prototype.constructor) {
		superClass.prototype.constructor = superClass;	
	}	
}

/* CLASS: CUSTOM ANIMATION
 * A pretty rough and ready class for animating multiple elements at once
 * and then only having one callback. It should work better than jQuery's
 * animation class, which updates each element in a different timeout
 * and also does a callback to each element that is animated 
 *********************************************************************************/
var CustomAnimation = function(arrayofanimates, duration, steps, callback) {
	this.steps = steps;
	this.duration = duration;
	this.callback = callback;
	this.timer = "";
		
	// Add initial style values
	for (var counter = (arrayofanimates.length-1); counter>=0; counter --) {
		var thiselement = arrayofanimates[counter].element;
		var thisstyles = arrayofanimates[counter].elStyles;
		for (var counter2= (thisstyles.length-1); counter2>=0; counter2--) {
			var thispartstyle = thisstyles[counter2].elStyle;
			arrayofanimates[counter].elStyles[counter2].startVal = parseInt($(thiselement).css(thispartstyle));
		}
	}
	this.arrayOfAnimates = arrayofanimates;
}
		
CustomAnimation.prototype = {
	startAnimation: function() {
		var steptimeinc = this.duration/this.steps;
		var that = this;
		for (var stepcounter=0; stepcounter<= this.steps; stepcounter ++) {
			var thisoutertotalsteps = this.steps;
			var thisouterduration = this.duration;
			var tempouteranimates = this.arrayOfAnimates;
			( function() {
				var tempanimates = tempouteranimates;
				var thistotalsteps = thisoutertotalsteps;
				var thisduration = thisouterduration;
				var thisstepcounter = stepcounter;

				setTimeout( function() {
					for (var counter = (tempanimates.length-1); counter>=0; counter --) {
						var thiselement = tempanimates[counter].element;
						var thisstyles = tempanimates[counter].elStyles;
						for (var counter2= (thisstyles.length-1); counter2>=0; counter2--) {
							var thispartstyle = thisstyles[counter2].elStyle
							var thisstartval = tempanimates[counter].elStyles[counter2].startVal;
							var thisendval = tempanimates[counter].elStyles[counter2].endVal;
								
							var stepvalue = thisstartval+((thisendval-thisstartval)*thisstepcounter/thistotalsteps);
								// This prevent jittering animations for reasons
								// I am not quite sure of 
								/*if ((thisendval-thisstartval) < 0) {
									stepvalue=Math.floor(stepvalue);
								}
								else {
									stepvalue=Math.ceil(stepvalue);
								}*/
							$(thiselement).css(thisstyles[counter2].elStyle, stepvalue);
						}
					}
						
					if (thisstepcounter == thistotalsteps) {
						that.callback();	
					}
						
				}, parseInt(thisstepcounter/thistotalsteps*thisduration));
			})();
		} 
		
	},
	stopAnimation: function() {
			
	}
}

var viewportSize = function() {
	var myWidth = 0, myHeight = 0;
	if( typeof( window.innerWidth ) == 'number' ) {
		//Non-IE
		myWidth = window.innerWidth;
		myHeight = window.innerHeight;
	} 
	else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
		//IE 6+ in 'standards compliant mode'
		myWidth = document.documentElement.clientWidth;
		myHeight = document.documentElement.clientHeight;
	} 
	else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
		//IE 4 compatible
		myWidth = document.body.clientWidth;
		myHeight = document.body.clientHeight;
	}
	return {
  		width: myWidth,
  		height: myHeight	
	}
}