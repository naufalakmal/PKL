(function ($) {
	"use strict";
	
	/*----------------------------
    START - Slider activation
    ------------------------------ */
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
	$('.author-feedback').owlCarousel({
		loop:true,
		autoplay: true,
		autoplayTimeout:4000,
		dots:false,
		nav:false,
		navText: ["<i class='icofont icofont-long-arrow-left'></i>", "<i class='icofont icofont-long-arrow-right'></i>"],
		items:1,
		animateIn: 'zoomOut',
		animateOut: 'slideInLeft',
		responsive:{
			576:{
				nav:true,
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
	
	// ===================== select dropdown menu =======================
	$('.product-price1 button').on('click', function () {
		if ($(".duration-time1").hasClass("fadeout"))
			$(".duration-time1").removeClass("fadeout").addClass("fadein");
		else
			$(".duration-time1").removeClass("fadein").addClass("fadeout");
		return false;
	});
	$('.duration-month1').on('click', function () {
		$(".duration-time1").removeClass("fadein").addClass("fadeout");
		$('.product-price1 button').text('month');
		$('.changes-value1').text('05');
		return false;
	});
	$('.duration-week1').on('click', function () {
		$(".duration-time1").removeClass("fadein").addClass("fadeout");
		$('.product-price1 button').text('week');
		$('.changes-value1').text('02');
		return false;
	});
	$('.duration-year1').on('click', function () {
		$(".duration-time1").removeClass("fadein").addClass("fadeout");
		$('.product-price1 button').text('year');
		$('.changes-value1').text('40');
		return false;
	});
	$('.product-price2 button').on('click', function () {
		if ($(".duration-time2").hasClass("fadeout"))
			$(".duration-time2").removeClass("fadeout").addClass("fadein");
		else
        $(".duration-time2").removeClass("fadein").addClass("fadeout");
		return false;
	});
	$('.duration-month2').on('click', function () {
		$(".duration-time2").removeClass("fadein").addClass("fadeout");
		$('.product-price2 button').text('month');
		$('.changes-value2').text('15');
		return false;
	});
	$('.duration-week2').on('click', function () {
		$(".duration-time2").removeClass("fadein").addClass("fadeout");
		$('.product-price2 button').text('week');
		$('.changes-value2').text('05');
		return false;
	});
	$('.duration-year2').on('click', function () {
		$(".duration-time2").removeClass("fadein").addClass("fadeout");
		$('.product-price2 button').text('year');
		$('.changes-value2').text('80');
		return false;
	});
	$('.product-price3 button').on('click', function () {
		if ($(".duration-time3").hasClass("fadeout"))
			$(".duration-time3").removeClass("fadeout").addClass("fadein");
		else
        $(".duration-time3").removeClass("fadein").addClass("fadeout");
		return false;
	});
	$('.duration-month3').on('click', function () {
        $(".duration-time3").removeClass("fadein").addClass("fadeout");
		$('.product-price3 button').text('month');
		$('.changes-value3').text('30');
		return false;
	});
	$('.duration-week3').on('click', function () {
        $(".duration-time3").removeClass("fadein").addClass("fadeout");
		$('.product-price3 button').text('week');
		$('.changes-value3').text('10');
		return false;
	});
	$('.duration-year3').on('click', function () {
        $(".duration-time3").removeClass("fadein").addClass("fadeout");
		$('.product-price3 button').text('year');
		$('.changes-value3').text('200');
		return false;
	});

}(jQuery));