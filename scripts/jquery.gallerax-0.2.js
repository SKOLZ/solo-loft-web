/*

	Gallerax 0.2: A flexible gallery plugin for jQuery
	By nodethirtythree design | http://nodethirtythree.com/

	Dual licensed under the MIT or GPL license.

	//////////////////////////////////////////////////////////////////////////

	MIT license:

	Copyright (c) 2010 nodethirtythree design, http://nodethirtythree.com/

	Permission is hereby granted, free of charge, to any person
	obtaining a copy of this software and associated documentation
	files (the "Software"), to deal in the Software without
	restriction, including without limitation the rights to use,
	copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the
	Software is furnished to do so, subject to the following
	conditions:

	The above copyright notice and this permission notice shall be
	included in all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
	EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
	OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
	NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
	HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
	WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
	FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
	OTHER DEALINGS IN THE SOFTWARE.

	//////////////////////////////////////////////////////////////////////////

	GPL license:

	Copyright (c) 2010 nodethirtythree design, http://nodethirtythree.com/
	
	This program is free software: you can redistribute it and/or modify it
	under the terms of the GNU General Public License as published by the Free 
	Software Foundation, either version 3 of the License, or (at your option) 
	any later version.

	This program is distributed in the hope that it will be useful, but 
	WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY 
	or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License 
	for more details.

	You should have received a copy of the GNU General Public License along 
	with this program. If not, see <http://www.gnu.org/licenses/>. 

	//////////////////////////////////////////////////////////////////////////

*/

(function($) {

	jQuery.fn.gallerax = function(options) {
		
		var settings = jQuery.extend({
			selectorParent:		jQuery(this)
		}, options);
		
		return jQuery.gallerax(settings);
	}

	jQuery.fn.galleraxFadeOut = function(speed, callback) {
		return this.fadeTo(speed, 0.0, callback);
	}

	jQuery.fn.galleraxFadeIn = function(speed, callback) {
		return this.fadeTo(speed, 1.0, callback);
	}

	jQuery.gallerax = function(options) {

		// Settings
		
			var settings = jQuery.extend({
			
				selectorParent:						null,						// If a jQuery object, all selectors will be restricted to its scope. Otherwise, all selectors will be global.
				
				// Selectors
				
					outputSelector:					null,						// 'Output' image selector
					outputImgSelector:				null,						// (scope: outputSelector) If null, assumes outputSelector points to the output IMG. Otherwise, we look for this child selector within outputSelector.
					captionSelector:				null,						// 'Caption' selector
					thumbnailsSelector:				null,						// 'Thumbnails' selector
					thumbnailsImgSelector:			null,						// (scope: thumbnailsSelector) If null, assumes thumbnailsSelector points to the thumbnail IMGs. Otherwise, we look for this child selector within thumbnailsSelector.
					navNextSelector:				null,						// 'Next' selector
					navPreviousSelector:			null,						// 'Previous' selector
					navFirstSelector:				null,						// 'First' selector
					navLastSelector:				null,						// 'Last' selector
					navStopAdvanceSelector:			null,						// 'Stop Advance' selector
					navPlayAdvanceSelector:			null,						// 'Play Advance' selector

				// General settings

					captionLines:					1,							// Number of caption lines. If this is > 1, the plugin will look for additional caption elements using the captionSelector setting + a number (eg. '.caption2', '.caption3', etc.)
					captionLineSeparator:			';',						// Character used to separate multiple caption lines within a thumbnail's 'title' attribute
					navWrap:						true,						// Wrap navigation when we navigate past the first or last thumbnail
					fade:							0,							// Fade duration for image transitions (0 for no fade, 'slow', 'fast', or a custom duration in ms)
					advanceDelay:					0,							// Time to wait (in ms) before automatically advancing to the next image (0 disables advancement entirely)
					advanceResume:					0,							// Time to wait (in ms) before resuming advancement after a user interrupts it by manually clicking on a thumbnail (0 disables resuming advancement)
					advanceFade:					0,							// Fade duration used for automatic image advancement (0 for no fade, 'slow', 'fast', or a custom duration in ms)
					advanceNavActiveClass:			'active',					// Active advancement navigation class
					thumbnailsActiveClass:			'active',					// Active thumbnail class
					thumbnailsFunction:				null,						// Function used to transform a thumbnail image's 'src' to the output image's 'src' (null indicates the thumbnail 'src' attributes can be used as is, ie. there are no separate full-size images for each thumbnail)
					thumbnailsPreloadOutput:		false						// If a thumbnailsFunction is defined, preload (ie. cache) each output image on page load

			}, options);
			
		// Variables

			// Operational stuff
		
				var isConfigured = true,
					isLocked = false,
					isAdvancing = false,
					cache = new Array(),
					list = new Array(),
					currentIndex = 0,
					oldIndex = 0,
					timeoutID;

			// jQuery objects

				var __output,
					__outputImg,
					__thumbnails,
					__caption,
					__navFirst,
					__navLast,
					__navNext,
					__navPrevious,
					__navStopAdvance,
					__navPlayAdvance;

		// Functions
			
			function cacheImage(url)
			{
				var x = document.createElement('img');
				x.src = url;
				cache.push(x);
			}
			
			function getElement(selector, required)
			{
				var x;
				
				try
				{
					if (selector == null)
						throw 'is undefined';
			
					if (settings.selectorParent)
						x = settings.selectorParent.find(selector);
					else
						x = jQuery(selector);
					
					if (x.length == 0)
						throw 'does not exist';
					
					return x;
				}
				catch (error)
				{
					if (required == true)
					{
						alert('Error: Required selector "' + selector + '" ' + error + '.');
						isConfigured = false;
					}
				}
				
				return null;
			}
			
			function setNewIndex(newIndex)
			{
				oldIndex = currentIndex;

				if (newIndex == null)
					return;

				currentIndex = newIndex;
			}

			function advance()
			{
				if (settings.advanceDelay == 0)
					return;
			
				if (currentIndex + 1 >= list.length)
					setNewIndex(0);
				else
					setNewIndex(currentIndex + 1);
				
				update(settings.advanceFade);

				timeoutID = window.setTimeout(advance, settings.advanceDelay);
			}

			function stopAdvance()
			{
				if (settings.advanceDelay == 0)
					return;

				if (!isAdvancing)
					return;
			
				isAdvancing = false;
				window.clearTimeout(timeoutID);
			}
			
			function restartAdvance()
			{
				if (settings.advanceDelay == 0)
					return;

				if (isAdvancing)
					return;

				isAdvancing = true;
				advance();
			}

			function startAdvance(delay, override)
			{
				if (settings.advanceDelay == 0)
					return;

				if (isAdvancing && !override)
					return;

				if (__navPlayAdvance)
					__navPlayAdvance.addClass(settings.advanceNavActiveClass);
				
				if (__navStopAdvance)
					__navStopAdvance.removeClass(settings.advanceNavActiveClass);

				isAdvancing = true;
				timeoutID = window.setTimeout(advance, (delay ? delay : settings.advanceDelay));
			}

			function holdAdvance()
			{
				if (settings.advanceDelay == 0)
					return;

				window.clearTimeout(timeoutID);

				if (settings.advanceResume == 0)
					return;

				startAdvance(settings.advanceResume, true);
			}

			function updateCaption(caption)
			{
				if (!__caption)
					return;
				
				caption = unescape(caption);
				
				if (settings.captionLines > 1)
				{
					var s = caption.split(settings.captionLineSeparator);
				
					for(var i = 0; i < settings.captionLines; i++)
						__caption[i].html( (s[i] ? s[i] : '' ) );
				}
				else
					__caption.html(caption);
			}

			function update(speed, initial)
			{
				if (isLocked == true)
					return false;

				isLocked = true;

				var l = list[currentIndex];
				var lOld = list[oldIndex];

				if (!speed)
					speed = settings.fade;

				lOld.object.removeClass(settings.thumbnailsActiveClass);
				
				l.object.addClass(settings.thumbnailsActiveClass);
				
				if (__outputImg.attr('src') == l.fullUrl)
				{
					if (initial)
					{
						__outputImg.hide();
						
						if (__outputImg.get(0).complete)
						{
							__outputImg.galleraxFadeIn(speed);
							updateCaption(l.caption);
							isLocked = false;
						}
						else
						{
							__outputImg.load(function() {
								jQuery(this).galleraxFadeIn(speed);
								updateCaption(l.caption);
								isLocked = false;
								jQuery(this).unbind('load');
							});
						}
					}
					else
					{
						isLocked = false;
						updateCaption(l.caption);
					}
				}
				else
				{
					__outputImg.galleraxFadeOut(speed, function() {
						__outputImg.attr('src', l.fullUrl);
						
						if (__outputImg.get(0).complete)
						{
							jQuery(this).galleraxFadeIn(speed);
							updateCaption(l.caption);
							isLocked = false;
						}
						else
						{
							__outputImg.load(function() {
								jQuery(this).galleraxFadeIn(speed);
								updateCaption(l.caption);
								isLocked = false;
								jQuery(this).unbind('load');
							});
						}
					});
				}
			}

		// Initialization

			// Output

				__output = getElement(settings.outputSelector, true);
				__outputImg = (settings.outputImgSelector ? __output.find(settings.outputImgSelector) : __output);

			// Thumbnails

				__thumbnails = getElement(settings.thumbnailsSelector, true);

			// Captions

				if (settings.captionLines > 0)
				{
					if (settings.captionLines > 1)
					{
						var i, x;

						__caption = new Array();
						
						for(i = 0; i < settings.captionLines ; i++)
						{
							x = getElement(settings.captionSelector + (i > 0 ? (i + 1) : ''));
							
							if (x == null)
							{
								alert('Error: Option "captionLines" is set to "' + settings.captionLines + '", but I could not find a caption element for caption line ' + (i + 1) + '.');
								isConfigured = false;
								break;
							}
							
							__caption[i] = x;
						}
					}
					else
						__caption = getElement(settings.captionSelector);
				}
				
			// Navigation

				__navFirst = getElement(settings.navFirstSelector);
				__navLast = getElement(settings.navLastSelector);
				__navNext = getElement(settings.navNextSelector);
				__navPrevious = getElement(settings.navPreviousSelector);
				__navStopAdvance = getElement(settings.navStopAdvanceSelector);
				__navPlayAdvance = getElement(settings.navPlayAdvanceSelector);

			// Check configuration status
			
				if (isConfigured == false)
				{
					alert('Error: One or more configuration errors detected. Aborting.');
					return;
				}


			// Set up

				// Thumbnails
			
					__thumbnails.each(function(index) {
						var y = jQuery(this),
							yi = (settings.thumbnailsImgSelector ? y.find(settings.thumbnailsImgSelector) : y),
							thumbUrl = yi.attr('src'),
							fullUrl = thumbUrl;

						if (settings.thumbnailsFunction)
						{
							fullUrl = settings.thumbnailsFunction(yi.attr('src'));
							
							if (fullUrl != thumbUrl
							&&	settings.thumbnailsPreloadOutput)
								cacheImage(fullUrl);
						}
						
						list[index] = {
							object:		y,
							thumbUrl:	thumbUrl,
							fullUrl:	fullUrl,
							caption:	yi.attr('title')
						};
						
						if (y.hasClass(settings.thumbnailsActiveClass))
						{
							oldIndex = index;
							currentIndex = index;
						}
						
						y.click(function(event) {
							event.preventDefault();
							
							if (isLocked)
								return false;
							
							if (isAdvancing)
								holdAdvance();

							if (currentIndex != index)
							{
								setNewIndex(index);
								update();
							}
						});
						
						yi.hide();
						
						if (yi.get(0).complete)
							yi.galleraxFadeIn(settings.fade);
						else
							yi.load(function() {
								jQuery(this).galleraxFadeIn(settings.fade);
								jQuery(this).unbind('load');
							});
					});

				// Navigation

					if (__navNext)
						__navNext.click(function(event) {
							event.preventDefault();

							if (isLocked)
								return false;

							if (isAdvancing)
								holdAdvance();

							if (currentIndex < list.length - 1)
							{
								setNewIndex(currentIndex + 1);
								update();
							}
							else if (settings.navWrap)
							{
								setNewIndex(0);
								update();
							}
						});

					if (__navPrevious)
						__navPrevious.click(function(event) {
							event.preventDefault();

							if (isLocked)
								return false;

							if (isAdvancing)
								holdAdvance();
						
							if (currentIndex > 0)
							{
								setNewIndex(currentIndex - 1);
								update();
							}
							else if (settings.navWrap)
							{
								setNewIndex(list.length - 1);
								update();
							}
						});

					if (__navFirst)
						__navFirst.click(function(event) {
							event.preventDefault();

							if (isLocked)
								return false;

							if (isAdvancing)
								holdAdvance();
							
							if (currentIndex > 0)
							{
								setNewIndex(0);
								update();
							}
						});

					if (__navLast)
						__navLast.click(function(event) {
							event.preventDefault();

							if (isLocked)
								return false;

							if (isAdvancing)
								holdAdvance();

							if (currentIndex < list.length - 1)
							{
								setNewIndex(list.length - 1);
								update();
							}
						});

					if (__navStopAdvance)
						__navStopAdvance.click(function(event) {
							event.preventDefault();

							if (isLocked)
								return false;

							if (!isAdvancing)
								return false;

							__navStopAdvance.addClass(settings.advanceNavActiveClass);
							
							if (__navPlayAdvance)
								__navPlayAdvance.removeClass(settings.advanceNavActiveClass);

							stopAdvance();
						});

					if (__navPlayAdvance)
						__navPlayAdvance.click(function(event) {
							event.preventDefault();

							if (isLocked)
								return false;
								
							if (isAdvancing)
								return false;

							__navPlayAdvance.addClass(settings.advanceNavActiveClass);
							
							if (__navStopAdvance)
								__navStopAdvance.removeClass(settings.advanceNavActiveClass);

							restartAdvance();
						});

			// Ready

				jQuery().ready(function() {
					update(settings.fade, true);
					startAdvance();
				});
	};

})(jQuery);