(function ($) {
	"use strict";
	
	/*----------------------------
    START - Slider activation
    ------------------------------ */
	$('.screenshot-area-slider').owlCarousel({
		loop:true,
		dots:true,
		autoplay: true,
		autoplayTimeout:4000,
		nav:true,
		navText: ["<i class='icofont icofont-long-arrow-left'></i>", "<i class='icofont icofont-long-arrow-right'></i>"],
		margin:20,
		responsive:{
			0:{
				items: 1,
				margin:0,
			},
			576:{
				items: 2,
			},
			768:{
				items: 3,
			},
			992:{
				items: 4,
			},
			1900:{
				items: 4,
			}
		}
	})
	$('.our-team').owlCarousel({
		loop:true,
		dots:true,
		autoplay: true,
		autoplayTimeout:4000,
		nav: false,
		margin:20,
		responsive:{
			0:{
				items: 1,
				margin:0,
			},
			576:{
				items: 2,
			},
			768:{
				items: 3,
			},
			991:{
				items: 4,
			}
		}
	});
	
	/*----------------------------
	START - videos popup
	------------------------------ */
	$('.popup-youtube').magnificPopup({type:'iframe'});
	//iframe scripts
	$.extend(true, $.magnificPopup.defaults, {  
		iframe: {
			patterns: {
				//youtube videos
				youtube: {
					index: 'youtube.com/', 
					id: 'v=', 
					src: 'https://www.youtube.com/embed/%id%?autoplay=1' 
				}
			}
		}
	});

	/*--------------------------------
	START - PIE CHART
	--------------------------------*/
	$('.activity-box-chart').easyPieChart({
		animate: 2000,
		scaleColor: false,
		lineWidth: 10,
		barColor: '#ec3851',
		trackColor: '#e0e0e0',
		size: 180
	});

}(jQuery));