var GALLERY_SIZE_RATIO = 0.452;
var MIN_GALLERY_HEIGHT = 520;
var MIN_GALLERY_WIDTH = 1250;
var PHOTO_CREDIT_BOTTOM_PADDING = 19;

$(document).ready( function() {
	
	
	var isFireFox=false;
	if (navigator.userAgent.indexOf("Firefox")!=-1) {
		isFireFox=true;
	}
	
	var isFireFoxPC = false;
	if (isFireFox && navigator.userAgent.indexOf("Windows") != -1) {
		isFireFoxPC = true;
	}
	
	var isIE = window.ActiveXObject ? true : false; // ActiveX is only used in Internet Explorer
	var isIE6=isIE;
	    
	var isIE7=false;
	if (window.external && (typeof window.XMLHttpRequest == "object")) {
		isIE7=true;
		isIE6=false;
	}


	var scrollBarWidth = (!isIE) ? scrollbarWidth() : 0;

	$(".ak-gallery").each( function() {

		var that = this;
		var ieResizeCanceller = true;
		setTimeout( function() {
			ieResizeCanceller=false;
		},100);
		
		var startingGalleryHeight = $(this).width() * GALLERY_SIZE_RATIO;
		$(this).css({height:startingGalleryHeight });

		var bestGalleryHeight = function() {
			var galleryHeight = $(that).width() * GALLERY_SIZE_RATIO;
			var extrasHeights = $("#header").height() + $("#blurb-holder").height() + parseInt($("#header").css("paddingBottom"));
			var viewportHeight = viewportSize().height; 
			var galleryHeightAdjustment = (viewportHeight < (galleryHeight + extrasHeights)) ?  (viewportHeight-extrasHeights) : galleryHeight; 
			galleryHeightAdjustment = (galleryHeightAdjustment < MIN_GALLERY_HEIGHT) ? MIN_GALLERY_HEIGHT : galleryHeightAdjustment;
			return galleryHeightAdjustment; 
		}
		
		var updateBlurbSize = function(dataObj) {
			$("#main-logo").css({height: dataObj.height });
		}
		
		updateBlurbSize({width: $(this).width(),height: $(this).width() * GALLERY_SIZE_RATIO });
		
		var	aGallery = new AKImageGallery({
			domRootEl: that,
			transition: $(that).find("span.ak-gallery-transition").text(),
			domPrevButton: $("#gallery-previous-button").get()[0],
			domNextButton: $("#gallery-next-button").get()[0],
			galleryHeightAdjustment: bestGalleryHeight(),
			imageInfoFunction: function(dataObj) {
				var domAppend = dataObj.domAppend;
				var imageInfoHTML = dataObj.imageInfoHTML;
				$(domAppend).append(imageInfoHTML);
			}
		}).init();
		
		$(window).resize( function() {
			if (ieResizeCanceller) {
				return;	
			}
			var extrasHeights = $("#blurb-holder").height() + parseInt($("#header").css("paddingBottom"));
			
			var viewportWidth = viewportSize().width-scrollBarWidth;
			viewportWidth = (viewportWidth < MIN_GALLERY_WIDTH) ? MIN_GALLERY_WIDTH : viewportWidth;

			var viewportHeight = viewportWidth * GALLERY_SIZE_RATIO;
			
			updateBlurbSize({ width: viewportWidth, height: viewportHeight });
			
			var newGalleryDimensions = {
				width: viewportWidth,
				height: viewportWidth * GALLERY_SIZE_RATIO,
				adjustmentHeight: bestGalleryHeight() 	
			}
			
			aGallery.updateSizeTo( { size: newGalleryDimensions } );
			
		});

		
	});
});


var AKImageGallery = function(dataObj) {
	var self = this;
	self.domRootEl = dataObj.domRootEl;
	self.imageInfoFunction = dataObj.imageInfoFunction;
	self.domImageStorage = $(self.domRootEl).find(".ak-gallery-image-storage").get()[0];
	self.domImages = $(self.domRootEl).find("img").get();
	self.numImages = self.domImages.length;
	self.domNextButton = dataObj.domNextButton;
	self.domPrevButton = dataObj.domPrevButton;
	self.galleryHeightAdjustment = dataObj.galleryHeightAdjustment;
	self.images = new Array();
	self.gallerySize = {
		width: $(this.domRootEl).width(),
		height: $(this.domRootEl).height()	
	}
	self.domStageHolder = $('<div class="ak-gallery-stage-holder"></div>').get()[0];
	self.domStage = $('<div class="ak-gallery-stage"></div>').get()[0];
	self.selectedImageIndex = 0;
	self.previousImage = false;
	self.transition = AKImageTransitions.makeTransition({ transition: (dataObj.transition || "SimpleSwitch") }); // default
	self.currentlyAnimating = false;
	return self;
}

AKImageGallery.prototype = {
	init: function() {
		var self = this;
		$(this.domRootEl).css({height: self.galleryHeightAdjustment });
		$(self.domNextButton).parent().css({display:"none"}); // Needed for ie
		$(self.domNextButton).parent().css({display:"block"}); // Needed for ie
		var counter = 0;
		$.each(self.domImages, function() {
			
			var imageInfoHTML = $(this).parent().find(".ak-gallery-insert-html").html();
			
			var anImage = new AKImage({
				gallery: self,
				displaySize: self.gallerySize,
				domImage: this,
				imageInfoFunction: self.imageInfoFunction,
				imageInfoHTML: imageInfoHTML,
				galleryAdjustmentHeight: self.galleryHeightAdjustment,
				index: counter++
			}).init();
			
			$(this).addClass("image-item");
			$(self.domImageStorage).prepend(anImage.html);
			self.images.push(anImage);
		});
		
		$(self.domStageHolder).css( {
			width: self.gallerySize.width+"px",
			height:	self.gallerySize.height+"px"
		});
		$(self.domStage).css( {
			width: self.gallerySize.width+"px",
			height:	self.gallerySize.height+"px"
		});
		
		$(self.domStageHolder).append(self.domStage);
		$(self.domRootEl).append(self.domStageHolder);
		
		
		$(self.domNextButton).click( function() {
			self.displayNextImage();
			return false;
		});
		$(self.domPrevButton).click( function() {
			self.displayPrevImage();
			return false;
		});
		
		// Initialise transition object
		
		self.transition.init( {
			domStage: self.domStage,
			displaySize: self.gallerySize
		});
		
		self.displayImageForIndex( { index: 0 });

		return self;
	},
	displayImageForIndex: function(dataObj) {
		var self = this;
		var index = dataObj.index;
		var direction = dataObj.direction;
		self.selectedImageIndex = index;
		self.currentlyAnimating = true;	
		self.transition.showImage({
			anImage: self.images[index],
			direction: direction,
			callback: function() {
				self.currentlyAnimating = false;	
			}
		});
		self.previousImage = self.images[index]; 
	},
	displayNextImage: function() {
		var self= this;
		if (self.currentlyAnimating) {
			return false;	
		}
		newIndex = (self.selectedImageIndex >= (self.numImages-1)) ? 0 : self.selectedImageIndex + 1;
		self.displayImageForIndex( { index: newIndex, direction: "forward" });
	},
	displayPrevImage: function() {
		var self= this;
		if (self.currentlyAnimating) {
			return false;	
		}
		newIndex = (self.selectedImageIndex >= 1) ? self.selectedImageIndex - 1 : (self.numImages-1);
		self.displayImageForIndex( { index: newIndex, direction: "backward" });
	},
	updateSizeTo: function(dataObj) {
		var self = this;
		var size = dataObj.size;
		self.gallerySize = size;
		$(self.domRootEl).css({height: size.adjustmentHeight});
		$(self.domStageHolder).css({height: size.height, width: size.width});

		$.each( self.images, function() {
			this.resizeTo({
				size: size
			});	
		});
		
		self.transition.updateDisplaySize({
			size: size
		});
	}
}



var AKImage = function(dataObj) {
	this.gallery = dataObj.gallery;
	this.displaySize = dataObj.displaySize;
	this.domImage = dataObj.domImage;
	this.imageInfoHTML = dataObj.imageInfoHTML;
	this.imageInfoFunction = dataObj.imageInfoFunction;
	this.domPhotoCredit="";
	this.index = dataObj.index;
	this.galleryAdjustmentHeight = dataObj.galleryAdjustmentHeight;
	this.size = {
		width: 0,
		height: 0	
	}
	this.adjustedDimensions = {
		width: 0,
		height: 0,
		xOffset: 0,
		yOffset: 0
	}
	this.domHolder = $('<div class="ak-image-holder"></div>').get()[0];
	this.html = this.domHolder; 
	this.loaded = false;
	return this;	
}

AKImage.prototype = {
	init: function() {
		var self = this;
		$(this.domHolder).css({
			width: this.displaySize.width, 
			height: this.displaySize.height
		});

		$(self.domHolder).append(self.domImage);

		var loadedFunc = function() {
			self.size = {
				width: $(this).width(),
				height: $(this).height()
			}
			self.fitInBoxOfSize({ 
				boxSize: { 
					width: self.displaySize.width, 
					height: self.displaySize.height 
				}
			});
			$(this).animate({ opacity: 1}, 1000, function() {
			});
			self.loaded = true;
		}
		
		if (this.domImage.complete) {
			setTimeout( function() { // timeout needed for ie
				loadedFunc.apply(self.domImage);
			},1);
		}
		else {
			$(this.domImage).load( function() {
				loadedFunc.apply(this);
			});
		}
		
		if (self.imageInfoFunction) {
			self.imageInfoFunction({
				domAppend: self.domHolder,
				imageInfoHTML: self.imageInfoHTML
			});
			self.domPhotoCredit = $(self.domHolder).find(".gallery-photo-credit").get()[0];
			self.repositionPhotoCredit();
		}
				
		return this;
	},
	fitInBoxOfSize: function(dataObj) {
		var boxSize = dataObj.boxSize;
		if (this.size.width/this.size.height > boxSize.width/boxSize.height) {
			this.adjustedDimensions.height = boxSize.height;
			this.adjustedDimensions.width = Math.round(this.adjustedDimensions.height/this.size.height * this.size.width);
			this.adjustedDimensions.xOffset = -Math.round((this.adjustedDimensions.width - boxSize.width)/2);
			this.adjustedDimensions.yOffset = 0;
		} 
		else {
			this.adjustedDimensions.width = boxSize.width;
			this.adjustedDimensions.height = Math.round(this.adjustedDimensions.width/this.size.width * this.size.height);
			this.adjustedDimensions.yOffset = -Math.round((this.adjustedDimensions.height - boxSize.height)/2);
			this.adjustedDimensions.xOffset = 0;
		}
		$(this.domImage).css({
			width: this.adjustedDimensions.width+"px",
			height: this.adjustedDimensions.height+"px",
			left: this.adjustedDimensions.xOffset+"px",
			top: this.adjustedDimensions.yOffset+"px"
		});
	},
	removeFromDom: function() {
		var self = this;
		$(self.domHolder).remove();
	},
	resizeTo: function(dataObj) {
		var self = this;
		self.displaySize = dataObj.size;
		self.fitInBoxOfSize({ 
			boxSize: self.displaySize
		});
		$(self.html).css({width:self.displaySize.width, height:self.displaySize.height });
		
		self.galleryAdjustmentHeight = self.displaySize.adjustmentHeight;
		self.repositionPhotoCredit();
	},
	repositionPhotoCredit: function() {
		var self = this;
		if (self.domPhotoCredit && self.galleryAdjustmentHeight) {
			var photoCreditOffset = self.displaySize.height - self.galleryAdjustmentHeight+PHOTO_CREDIT_BOTTOM_PADDING;
			$(self.domPhotoCredit).css({bottom:photoCreditOffset+"px"});
		}
		
	}
}



var AKImageTransitions = {
	makeTransition: function(dataObj) {
		return new this[dataObj.transition];
	}
}

AKImageTransitions.SimpleSwitch = function() {};
AKImageTransitions.SimpleSwitch.prototype = {
	init: function(dataObj) {
		var self = this;
		self.domStage = dataObj.domStage;
		self.displaySize = dataObj.displaySize;
		self.previousImage = false;
	},
	showImage: function(dataObj) {
		var self = this;
		self.direction = dataObj.direction
		var callback = dataObj.callback;
		var anImage = dataObj.anImage;
		if (!self.previousImage) {
			// This must be the first image to be displayed
			self.displayFirstImage({
				anImage: anImage,
				callback: function() {
					callback();	
				}
			});
			return;
		}
		self.initialiseAndPlaceNewImage({ anImage: anImage });
		setTimeout( function() {
			self.doTransition({
				anImage: anImage,
				callback: function() {
					if (self.previousImage) {
						self.previousImage.removeFromDom();	
					}
					self.previousImage = anImage;
					callback();
				}
			});
		},1);
	},
	initialiseAndPlaceNewImage: function(dataObj) {
		var self = this;
		$(self.domStage).append(dataObj.anImage.html);
	},
	doTransition: function(dataObj) {
		dataObj.callback();
	},
	displayFirstImage: function(dataObj) {
		var self = this;
		var anImage = dataObj.anImage;
		var callback = dataObj.callback;
		$(self.domStage).append(anImage.html);
		self.previousImage = anImage;
		callback();
	},
	updateDisplaySize: function(dataObj) {
		var self = this;
		self.displaySize = dataObj.size;	
	}
}

AKImageTransitions.FadeIn = function() {
	AKImageTransitions.FadeIn.superClass.constructor.call(this);
}
extend(AKImageTransitions.FadeIn, AKImageTransitions.SimpleSwitch);
AKImageTransitions.FadeIn.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:0});
	$(self.domStage).append(anImage.html);
}
		
AKImageTransitions.FadeIn.prototype.doTransition = function(dataObj) {
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	$(anImage.html).animate({opacity: 1},500, function() {
		callback();
	});
}


AKImageTransitions.CarouselHorizontal = function() {
	AKImageTransitions.CarouselHorizontal.superClass.constructor.call(this);
}
extend(AKImageTransitions.CarouselHorizontal, AKImageTransitions.SimpleSwitch);
AKImageTransitions.CarouselHorizontal.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	self.displayOffset = (self.direction == "backward") ? -self.displaySize.width : self.displaySize.width;
	$(anImage.html).css({left: self.displayOffset+"px"});
	$(self.domStage).append(anImage.html);
	
}
		
AKImageTransitions.CarouselHorizontal.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var timer = Math.abs(self.displaySize.width/2);
	$(self.domStage).animate({left: -self.displayOffset+"px"},timer, function() {
		$(anImage.html).css({left:0});
		$(self.domStage).css({left:0});
		callback();
	});
}


AKImageTransitions.CameraShutter = function() {
	AKImageTransitions.CameraShutter.superClass.constructor.call(this);
}
extend(AKImageTransitions.CameraShutter, AKImageTransitions.SimpleSwitch);
AKImageTransitions.CameraShutter.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:0});
	$(self.domStage).append(anImage.html);
	self.shutterTop = $('<div class="ak-image-gallery-camera-shutter"></div>').get()[0];
	self.shutterBottom = $('<div class="ak-image-gallery-camera-shutter"></div>').get()[0];
	$(self.shutterTop).css({top: 0, left: 0, height: 0, width: self.displaySize.width, opacity: 0});
	$(self.shutterBottom).css({bottom: 0, left: 0, height: 0, width: self.displaySize.width, opacity: 0});
	$(self.domStage).append(self.shutterTop);
	$(self.domStage).append(self.shutterBottom);
}
		
AKImageTransitions.CameraShutter.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	var animates2 = new Array();
	animates1.push({ element: self.shutterTop, elStyles: [{ elStyle: "height", endVal: self.displaySize.height/2+1 },{ elStyle: "opacity", endVal: 1 }] });
	animates1.push({ element: self.shutterBottom, elStyles: [{ elStyle: "height", endVal: self.displaySize.height/2+1 },{ elStyle: "opacity", endVal: 1 }] });
	var closeShutterAnimation = new CustomAnimation(animates1, 200, 20, function() {
		$(anImage.html).css({opacity:1});
		setTimeout( function() {
			animates2.push({ element:self.shutterTop, elStyles: [{ elStyle: "height", endVal: 0 }] });
			animates2.push({ element:self.shutterBottom, elStyles: [{ elStyle: "height", endVal: 0 }] });
			var openShutterAnimation = new CustomAnimation(animates2, 200, 20, function() {
				$(self.shutterTop).remove();
				$(self.shutterBottom).remove();
				callback();
			});
			openShutterAnimation.startAnimation();
		},200);
	});
	closeShutterAnimation.startAnimation();
}


AKImageTransitions.Squares = function() {
	AKImageTransitions.Squares.superClass.constructor.call(this);
}
extend(AKImageTransitions.Squares, AKImageTransitions.SimpleSwitch);
AKImageTransitions.Squares.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:0});
	self.previousImage.removeFromDom();
	$(self.domStage).append(anImage.html);
	
	self.squareCols = Math.round(self.displaySize.width / 100) || 1; 
	self.squareRows = Math.round(self.displaySize.height / 100) || 1;
	
	self.squareSize = {
		 width: Math.ceil(self.displaySize.width/self.squareCols),
		 height: Math.ceil(self.displaySize.height/self.squareRows)
	}

	var createSquareAtRowColWithImage = function(dataObj) {
		var	row = dataObj.row;
		var col = dataObj.col;
		var srcImage = dataObj.srcImage;
		var startingOpacity = dataObj.startingOpacity;
		
		var domSquare = $('<div class="ak-image-gallery-square"></div>').get()[0];
		$(domSquare).css({
			width: self.squareSize.width, 
			height: self.squareSize.height,
			top: self.squareSize.height * row,
			left: self.squareSize.width * col,
			opacity: startingOpacity
		});
		
		var domImage = $(srcImage.html).clone();
		$(domImage).css({
			opacity: 1,
			left:  - self.squareSize.width * col,
			top:  - self.squareSize.height * row
		});
		$(domSquare).append(domImage);
		return domSquare;
	}
	self.domSquares = new Array();
	for (var row = 0; row < self.squareRows; row++) {
		for (var col = 0; col < self.squareCols; col++) {
			var domSquare = createSquareAtRowColWithImage({
				row: row,
				col: col,
				srcImage: self.previousImage,
				startingOpacity: 1	
			});
			self.domSquares.push(domSquare);
			$(self.domStage).append(domSquare);
		}  	
	}
}
		
AKImageTransitions.Squares.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var timerInc = parseInt(1600/(self.squareRows * self.squareCols)); 
	var callback = dataObj.callback;
	$(anImage.html).css({opacity:1});
	for (var row = 0; row < self.squareRows; row++) {
		for (var col = 0; col < self.squareCols; col++) {
			(function() {
				var delay = col * timerInc + row * timerInc/3 * self.squareCols;
				var domSquare = self.domSquares[(row * self.squareCols) + col];
				
				var lastRow = (col == (self.squareCols-1) && row == (self.squareRows-1)) ? true : false; 
				setTimeout( function() {
					$(domSquare).animate({opacity: 0}, 500, function() {
						$(this).remove();
					});
					if (lastRow) {
						callback();	
					}
				},delay);
			})();

		}
	}
}

AKImageTransitions.SquaresFadeInAndOut = function() {
	AKImageTransitions.SquaresFadeInAndOut.superClass.constructor.call(this);
}
extend(AKImageTransitions.SquaresFadeInAndOut, AKImageTransitions.SimpleSwitch);
AKImageTransitions.SquaresFadeInAndOut.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:0});
	self.previousImage.removeFromDom();
	$(self.domStage).append(anImage.html);
	
	self.squareCols = Math.round(self.displaySize.width / 100) || 1; 
	self.squareRows = Math.round(self.displaySize.height / 100) || 1;
	
	self.squareSize = {
		 width: Math.ceil(self.displaySize.width/self.squareCols),
		 height: Math.ceil(self.displaySize.height/self.squareRows)
	}

	var createSquareAtRowColWithImage = function(dataObj) {
		var	row = dataObj.row;
		var col = dataObj.col;
		var srcImage = dataObj.srcImage;
		var startingOpacity = dataObj.startingOpacity;
		var scale = (dataObj.scale) ? dataObj.scale : 1;
		
		var domSquare = $('<div class="ak-image-gallery-square"></div>').get()[0];
		$(domSquare).css({
			width: (self.squareSize.width *scale), 
			height: (self.squareSize.height * scale),
			top: (self.squareSize.height * row) + (self.squareSize.height *(1-scale)),
			left: (self.squareSize.width * col) + (self.squareSize.height *(1-scale)),
			opacity: startingOpacity
		});
		
		var domImage = $(srcImage.html).clone();
		$(domImage).css({
			opacity: 1,
			left:  - self.squareSize.width * col,
			top:  - self.squareSize.height * row
		});
		$(domSquare).append(domImage);
		return {
			dom: domSquare,
			yOffset: self.squareSize.height * row,
			xOffset: self.squareSize.width * col
		}
	}

	self.squares = new Array();
	self.newSquares = new Array();

	for (var row = 0; row < self.squareRows; row++) {
		for (var col = 0; col < self.squareCols; col++) {
			
			var aSquare = createSquareAtRowColWithImage({
				row: row,
				col: col,
				srcImage: self.previousImage,
				startingOpacity: 1	
			});
			self.squares.push(aSquare);
			$(self.domStage).append(aSquare.dom);
			
			var aNewSquare = createSquareAtRowColWithImage({
				row: row,
				col: col,
				srcImage: anImage,
				startingOpacity: 0
			});
			self.newSquares.push(aNewSquare);
			$(self.domStage).append(aNewSquare.dom);
		}  	
	}
}
		
AKImageTransitions.SquaresFadeInAndOut.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var timerInc = 50;
	var callback = dataObj.callback;
	$(anImage.html).css({opacity:0});
	for (var row = 0; row < self.squareRows; row++) {
		for (var col = 0; col < self.squareCols; col++) {
			(function() {
				var delay = col * timerInc + row * timerInc/3 * self.squareCols;
				var aSquare = self.squares[(row * self.squareCols) + col];
				var aNewSquare = self.newSquares[(row * self.squareCols) + col];
				
				var lastRow = (col == (self.squareCols-1) && row == (self.squareRows-1)) ? true : false; 
				setTimeout( function() {
					$(aSquare.dom).animate({opacity: 0 }, 500, function() {
						$(this).remove();
					});
				},delay);
				setTimeout( function() {
					
					$(aNewSquare.dom).animate({ opacity: 1}, 500, function() {
						if (lastRow) {
							$(anImage.html).css({opacity:1});
							$.each(self.newSquares, function() {
								$(this.dom).remove();
							});
							callback();	
						}
					});
				},delay+900);
			})();

		}
	}
}