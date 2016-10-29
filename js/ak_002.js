AKImageTransitions.SplitAndFadeIn = function() {
	AKImageTransitions.SplitAndFadeIn.superClass.constructor.call(this);
}
extend(AKImageTransitions.SplitAndFadeIn, AKImageTransitions.SimpleSwitch);
AKImageTransitions.SplitAndFadeIn.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:0});
	$(self.domStage).append(anImage.html);
	self.splitterLeft = $('<div class="ak-image-gallery-splitter"></div>').get()[0];
	self.splitterRight = $('<div class="ak-image-gallery-splitter"></div>').get()[0];
	$(self.splitterLeft).css({top: 0, left: 0, height: self.displaySize.height, width: self.displaySize.width/2+1});
	$(self.splitterRight).css({top: 0, left: self.displaySize.width/2, height: self.displaySize.height, width: self.displaySize.width/2+1});
		
	$(self.splitterLeft).append($(self.previousImage.html).clone());
	
	var rightHTML = $(self.previousImage.html).clone();
	$(rightHTML).css({left: -self.displaySize.width/2});
	$(self.splitterRight).append(rightHTML);

	self.previousImage.removeFromDom();
	$(self.domStage).append(self.splitterLeft);
	$(self.domStage).append(self.splitterRight);
}
		
AKImageTransitions.SplitAndFadeIn.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	var animates2 = new Array();
	animates1.push({ element: self.splitterLeft, elStyles: [{ elStyle: "left", endVal: - self.displaySize.width/2}] });
	animates1.push({ element: self.splitterRight, elStyles: [{ elStyle: "left", endVal: self.displaySize.width }] });
	animates1.push({ element: anImage.html, elStyles: [{ elStyle: "opacity", endVal: 1 }] });
	var splitterAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		$(self.splitterLeft).remove();
		$(self.splitterRight).remove();
		callback();
	});
	splitterAnimation.startAnimation();
}


AKImageTransitions.SplitAndFadeOut = function() {
	AKImageTransitions.SplitAndFadeOut.superClass.constructor.call(this);
}
extend(AKImageTransitions.SplitAndFadeOut, AKImageTransitions.SplitAndFadeIn);
AKImageTransitions.SplitAndFadeOut.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	var animates2 = new Array();
	$(anImage.html).css({opacity:1});
	animates1.push({ element: self.splitterLeft, elStyles: [{ elStyle: "left", endVal: - self.displaySize.width/2},{ elStyle: "opacity", endVal: 0}] });
	animates1.push({ element: self.splitterRight, elStyles: [{ elStyle: "left", endVal: self.displaySize.width },{ elStyle: "opacity", endVal: 0}] });
	var splitterAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		$(self.splitterLeft).remove();
		$(self.splitterRight).remove();
		callback();
	});
	splitterAnimation.startAnimation();
}


AKImageTransitions.SplitAndFadeInAndOut = function() {
	AKImageTransitions.SplitAndFadeInAndOut.superClass.constructor.call(this);
}
extend(AKImageTransitions.SplitAndFadeInAndOut, AKImageTransitions.SplitAndFadeIn);
AKImageTransitions.SplitAndFadeInAndOut.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	var animates2 = new Array();
	animates1.push({ element: self.splitterLeft, elStyles: [{ elStyle: "left", endVal: - self.displaySize.width/2},{ elStyle: "opacity", endVal: 0}] });
	animates1.push({ element: self.splitterRight, elStyles: [{ elStyle: "left", endVal: self.displaySize.width },{ elStyle: "opacity", endVal: 0}] });
	animates1.push({ element: anImage.html, elStyles: [{ elStyle: "opacity", endVal: 1 }] });
	var splitterAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		$(self.splitterLeft).remove();
		$(self.splitterRight).remove();
		callback();
	});
	splitterAnimation.startAnimation();
}

AKImageTransitions.SplitInFourAndFadeIn = function() {
	AKImageTransitions.SplitAndFadeIn.superClass.constructor.call(this);
}
extend(AKImageTransitions.SplitInFourAndFadeIn, AKImageTransitions.SimpleSwitch);
AKImageTransitions.SplitInFourAndFadeIn.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:0});
	$(self.domStage).append(anImage.html);

	var xAdjuster = ((anImage.adjustedDimensions.xOffset % 2) == 0) ? 0 : 1; 
	var yAdjuster = ((anImage.adjustedDimensions.yOffset % 2) == 0) ? 0 : 1; 

	self.splitterTopLeft = $('<div class="ak-image-gallery-splitter"></div>').get()[0];
	self.splitterTopRight = $('<div class="ak-image-gallery-splitter"></div>').get()[0];
	self.splitterBottomLeft = $('<div class="ak-image-gallery-splitter"></div>').get()[0];
	self.splitterBottomRight = $('<div class="ak-image-gallery-splitter"></div>').get()[0];
	$(self.splitterTopLeft).css({top: 0, left: 0, height: self.displaySize.height/2, width: self.displaySize.width/2});
	$(self.splitterTopRight).css({top: 0, left: self.displaySize.width/2, height: self.displaySize.height/2, width: Math.ceil(self.displaySize.width/2)});
	$(self.splitterBottomLeft).css({top: self.displaySize.height/2, left: 0, height: self.displaySize.height/2+(1-yAdjuster), width: Math.ceil(self.displaySize.width/2)});
	$(self.splitterBottomRight).css({top: self.displaySize.height/2, left: self.displaySize.width/2, height: self.displaySize.height/2+(1-yAdjuster), width: Math.ceil(self.displaySize.width/2)});
		
	$(self.splitterTopLeft).append($(self.previousImage.html).clone());
	
	var topRightHTML = $(self.previousImage.html).clone();
	$(topRightHTML).css({left: -self.displaySize.width/2});
	$(self.splitterTopRight).append(topRightHTML);

	var bottomLeftHTML = $(self.previousImage.html).clone();
	$(bottomLeftHTML).css({top: -self.displaySize.height/2});
	$(self.splitterBottomLeft).append(bottomLeftHTML);

	var bottomRightHTML = $(self.previousImage.html).clone();
	$(bottomRightHTML).css({left: -self.displaySize.width/2+xAdjuster, top: -self.displaySize.height/2+yAdjuster});
	$(self.splitterBottomRight).append(bottomRightHTML);

	self.previousImage.removeFromDom();
	$(self.domStage).append(self.splitterTopLeft);
	$(self.domStage).append(self.splitterTopRight);
	$(self.domStage).append(self.splitterBottomLeft);
	$(self.domStage).append(self.splitterBottomRight);
}
		
AKImageTransitions.SplitInFourAndFadeIn.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	animates1.push({ element: self.splitterTopLeft, elStyles: [
		{ elStyle: "left", endVal: - self.displaySize.width/2},
		{ elStyle: "top", endVal: - self.displaySize.height/2}
	] });
	animates1.push({ element: self.splitterTopRight, elStyles: [
		{ elStyle: "left", endVal: self.displaySize.width},
		{ elStyle: "top", endVal: - self.displaySize.height/2}
	] });
	animates1.push({ element: self.splitterBottomLeft, elStyles: [
		{ elStyle: "left", endVal: - self.displaySize.width/2},
		{ elStyle: "top", endVal: self.displaySize.height}
	] });
	animates1.push({ element: self.splitterBottomRight, elStyles: [
		{ elStyle: "left", endVal: self.displaySize.width},
		{ elStyle: "top", endVal: self.displaySize.height}
	] });

	animates1.push({ element: anImage.html, elStyles: [{ elStyle: "opacity", endVal: 1 }] });
	var splitterAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		$(self.splitterTopLeft).remove();
		$(self.splitterTopRight).remove();
		$(self.splitterBottomLeft).remove();
		$(self.splitterBottomRight).remove();
		callback();
	});
	splitterAnimation.startAnimation();
}

AKImageTransitions.SplitInFourAndFadeInAndOut = function() {
	AKImageTransitions.SplitInFourAndFadeInAndOut.superClass.constructor.call(this);
}
extend(AKImageTransitions.SplitInFourAndFadeInAndOut, AKImageTransitions.SplitInFourAndFadeIn);
AKImageTransitions.SplitInFourAndFadeInAndOut.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	
	animates1.push({ element: self.splitterTopLeft, elStyles: [
		{ elStyle: "left", endVal: - self.displaySize.width/2},
		{ elStyle: "top", endVal: - self.displaySize.height/2},
		{ elStyle: "opacity", endVal: 0}
	] });
	animates1.push({ element: self.splitterTopRight, elStyles: [
		{ elStyle: "left", endVal: self.displaySize.width},
		{ elStyle: "top", endVal: - self.displaySize.height/2},
		{ elStyle: "opacity", endVal: 0}
	] });
	animates1.push({ element: self.splitterBottomLeft, elStyles: [
		{ elStyle: "left", endVal: - self.displaySize.width/2},
		{ elStyle: "top", endVal: self.displaySize.height},
		{ elStyle: "opacity", endVal: 0}
	] });
	animates1.push({ element: self.splitterBottomRight, elStyles: [
		{ elStyle: "left", endVal: self.displaySize.width},
		{ elStyle: "top", endVal: self.displaySize.height},
		{ elStyle: "opacity", endVal: 0}
	] });

	animates1.push({ element: anImage.html, elStyles: [{ elStyle: "opacity", endVal: 1 }] });
	var splitterAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		$(self.splitterTopLeft).remove();
		$(self.splitterTopRight).remove();
		$(self.splitterBottomLeft).remove();
		$(self.splitterBottomRight).remove();
		callback();
	});
	splitterAnimation.startAnimation();
}

AKImageTransitions.ZoomOut = function() {
	AKImageTransitions.ZoomOut.superClass.constructor.call(this);
}
extend(AKImageTransitions.ZoomOut, AKImageTransitions.SimpleSwitch);
AKImageTransitions.ZoomOut.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	$(anImage.html).css({opacity:1});
	$(self.domStage).append(anImage.html);
	$(self.domStage).append(self.previousImage.html);
}
		
AKImageTransitions.ZoomOut.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	var prevImage = self.previousImage;
	var zoomVal = 2;
	
	var finalXOffset = - ((prevImage.adjustedDimensions.width * zoomVal)-self.displaySize.width)/2;
	var finalYOffset = - ((prevImage.adjustedDimensions.height * zoomVal)-self.displaySize.height)/2;
	
	animates1.push({ element: prevImage.domImage, elStyles: [
			{ elStyle: "left", endVal: finalXOffset},
			{ elStyle: "top", endVal: finalYOffset},
			{ elStyle: "width", endVal: prevImage.adjustedDimensions.width * zoomVal},
			{ elStyle: "height", endVal: prevImage.adjustedDimensions.height * zoomVal}
		] 
	});
	
	animates1.push({ element: prevImage.html, elStyles: [{ elStyle: "opacity", endVal: 0 }] });
	//animates1.push({ element: anImage.html, elStyles: [{ elStyle: "opacity", endVal: 1 }] });
	var zoomAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		self.previousImage.removeFromDom();
		$(self.previousImage.domImage).css({
			left: prevImage.adjustedDimensions.xOffset,
			top: prevImage.adjustedDimensions.yOffset,
			width: prevImage.adjustedDimensions.width,
			height: prevImage.adjustedDimensions.height
		});
		callback();
	});
	zoomAnimation.startAnimation();
}

AKImageTransitions.ZoomOutAndZoomIn = function() {
	AKImageTransitions.ZoomOutAndZoomIn.superClass.constructor.call(this);
}
extend(AKImageTransitions.ZoomOutAndZoomIn, AKImageTransitions.SimpleSwitch);
AKImageTransitions.ZoomOutAndZoomIn.prototype.initialiseAndPlaceNewImage = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	self.zoomVal = 1.1;
	var startXOffset = - ((anImage.adjustedDimensions.width * self.zoomVal)-self.displaySize.width)/2;
	var startYOffset = - ((anImage.adjustedDimensions.height * self.zoomVal)-self.displaySize.height)/2;

	$(anImage.domImage).css({
		left: startXOffset,
		top: startYOffset,
		width: anImage.adjustedDimensions.width * self.zoomVal,
		height: anImage.adjustedDimensions.height * self.zoomVal,
		opacity: 1
	});

	$(anImage.html).css({opacity:0});
	$(self.domStage).append(anImage.html);
	$(self.domStage).append(self.previousImage.html);

}
		
AKImageTransitions.ZoomOutAndZoomIn.prototype.doTransition = function(dataObj) {
	var self = this;
	var anImage = dataObj.anImage;
	var callback = dataObj.callback;
	var animates1 = new Array();
	var prevImage = self.previousImage;
	var zoomVal = self.zoomVal;
	
	var finalXOffset = - ((prevImage.adjustedDimensions.width * zoomVal)-self.displaySize.width)/2;
	var finalYOffset = - ((prevImage.adjustedDimensions.height * zoomVal)-self.displaySize.height)/2;
	
	animates1.push({ element: prevImage.domImage, elStyles: [
			{ elStyle: "left", endVal: finalXOffset},
			{ elStyle: "top", endVal: finalYOffset},
			{ elStyle: "width", endVal: prevImage.adjustedDimensions.width * zoomVal},
			{ elStyle: "height", endVal: prevImage.adjustedDimensions.height * zoomVal}
		] 
	});
	
	animates1.push({ element: anImage.domImage, elStyles: [
			{ elStyle: "left", endVal: anImage.adjustedDimensions.xOffset},
			{ elStyle: "top", endVal: anImage.adjustedDimensions.yOffset},
			{ elStyle: "width", endVal: anImage.adjustedDimensions.width},
			{ elStyle: "height", endVal: anImage.adjustedDimensions.height}
		] 
	});
	
	animates1.push({ element: prevImage.html, elStyles: [{ elStyle: "opacity", endVal: 0 }] });
	animates1.push({ element: anImage.html, elStyles: [{ elStyle: "opacity", endVal: 1 }] });
	var zoomAnimation = new CustomAnimation(animates1, 500, 50, function() {
		$(anImage.html).css({opacity:1});
		self.previousImage.removeFromDom();
		$(self.previousImage.domImage).css({
			left: prevImage.adjustedDimensions.xOffset,
			top: prevImage.adjustedDimensions.yOffset,
			width: prevImage.adjustedDimensions.width,
			height: prevImage.adjustedDimensions.height
		});
		callback();
	});
	zoomAnimation.startAnimation();
}
