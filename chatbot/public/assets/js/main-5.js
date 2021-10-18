(function ($) {
	"use strict";
	
	/*----------------------------
    START - Slider activation
    ------------------------------ */
	$('.screenshot-wrap').slick({
		autoplay: false,
		dots: true,
		autoplaySpeed: 1000,
		slidesToShow: 3,
		centerPadding: '20%',
		centerMode: true,
		prevArrow: '<i class="icofont icofont-long-arrow-left"></i>',
		nextArrow: '<i class="icofont icofont-long-arrow-right"></i>',
		responsive: [{

		  breakpoint: 992,
		  settings: {
			slidesToShow: 1,
			centerPadding: '33.3%'
		  }

		},{

		  breakpoint: 576,
		  settings: {
			slidesToShow: 1,
			centerPadding: '0'
		  }

		}]
	});
	/*var screenshotSlider = $('.screenshot-slider');
	screenshotSlider.owlCarousel({
		loop: true,
		dots:true,
		autoplay: false,
		autoplayTimeout:4000,
		nav: false,
		navText: ["<i class='icofont icofont-long-arrow-left'></i>", "<i class='icofont icofont-long-arrow-right'></i>"],
		responsive:{
			768:{
				nav: true,
				items: 3,
			},
			992:{
				nav: true,
				items: 5,
				margin: 20,
				slideBy: 5,
			}
		}
	});
	screenshotSlider.on("translate.owl.carousel", function(){
		$(".screenshot-single-slide img").removeClass("animated zoomIn").css("opacity", "0");
	});
	screenshotSlider.on("translated.owl.carousel", function(){
		$(".screenshot-single-slide img").addClass("animated zoomIn").css("opacity", "1");
	});
	screenshotSlider.on('changed.owl.carousel', function(property) {
		var current = property.item.index;
		var prevRating = $(property.target).find(".owl-item").eq(current).prev().find('.screenshot-single-slide').html();
		var nextRating = $(property.target).find(".owl-item").eq(current).next().find('.screenshot-single-slide').html();
		$('.screenshot-prev').html(prevRating);
		$('.screenshot-next').html(nextRating);
	});
	$('.screenshot-next').on('click', function() {
		screenshotSlider.trigger('next.owl.carousel', [300]);
		return false;
	});
	$('.screenshot-prev').on('click', function() {
		screenshotSlider.trigger('prev.owl.carousel', [300]);
		return false;
	});*/
	
	
	var feedbackSlider = $('.feedback-slider');
	feedbackSlider.owlCarousel({
		loop:true,
		dots:true,
		autoplay: false,
		autoplayTimeout:4000,
		nav: false,
		navText: ["<i class='icofont icofont-long-arrow-left'></i>", "<i class='icofont icofont-long-arrow-right'></i>"],
		items: 1,
		responsive:{
			768:{
				nav: true,
			}
		}
	});
	feedbackSlider.on("translate.owl.carousel", function(){
		$(".author-single-slide h3").removeClass("animated fadeIn").css("opacity", "0");
		$(".author-single-slide img, .author-single-slide img, .author-rating").removeClass("animated zoomIn").css("opacity", "0");
	});
	feedbackSlider.on("translated.owl.carousel", function(){
		$(".author-single-slide h3").addClass("animated fadeIn").css("opacity", "1");
		$(".author-single-slide img, .author-single-slide img, .author-rating").addClass("animated zoomIn").css("opacity", "1");
	});
	feedbackSlider.on('changed.owl.carousel', function(property) {
		var current = property.item.index;
		var prevRating = $(property.target).find(".owl-item").eq(current).prev().find('.author-single-slide').html();
		var nextRating = $(property.target).find(".owl-item").eq(current).next().find('.author-single-slide').html();
		$('.thumb-prev').html(prevRating);
		$('.thumb-next').html(nextRating);
	});
	$('.thumb-next').on('click', function() {
		feedbackSlider.trigger('next.owl.carousel', [300]);
		return false;
	});
	$('.thumb-prev').on('click', function() {
		feedbackSlider.trigger('prev.owl.carousel', [300]);
		return false;
	});

}(jQuery));