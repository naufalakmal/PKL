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
	$('.author-feedback').owlCarousel({
		loop:true,
		autoplay: true,
		autoplayTimeout:4000,
		dots:true,
		nav:false,
		navText: ["<i class='icofont icofont-long-arrow-left'></i>", "<i class='icofont icofont-long-arrow-right'></i>"],
		items:1,
		responsive:{
			0:{
				items: 1,
				margin:0,
			},
			576:{
				items: 1,
				nav:true,
			},
			992:{
				items: 2,
			},
		}
	});

}(jQuery));