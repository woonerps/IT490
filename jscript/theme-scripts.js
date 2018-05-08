
// Editable variables
var Slider_Speed = 5000;

// Startup variables
var Slider_CurrentFrame = [];
var Slider_MaxFrames = [];
var Slider_AutoplayStart = [];
var Slider_Temp = [];



jQuery(document).ready(function() {

	jQuery("body").prepend("<ul class='responsive_menu' style='display:none;'></ul><a href='#open-responsive' class='responsive-link icon-text' style='display:none;'>&#9776;</a><div class='responsive-overlay'></div>");

	jQuery(".responsivemenu").each(function() {
		var thisel = jQuery(this);
		jQuery(".responsive_menu").append("<li class='responsive-title'><span class='icon-text'>&#9776;</span>"+thisel.attr("rel")+"</li>"+thisel.html());
	});

	jQuery("a[href='#open-responsive']").click(function() {
		jQuery("body").toggleClass("openmenu");
		return false;
	});

	jQuery("div.responsive-overlay").click(function() {
		jQuery("body").removeClass("openmenu");
	});


	jQuery(".category-panel li a").mouseover(function() {
		var thisel = jQuery(this);
		thisel.css("background-color", thisel.data("hovercolor"));
	}).mouseout(function() {
		jQuery(this).css("background-color", "transparent");
	});

	jQuery(".img-hover-image").each(function() {
		var thisel = jQuery(this).parent();
	});

	jQuery(".slider-block").each(function() {
		var thisel = jQuery(this);
		Slider_CurrentFrame[thisel.attr("id")] = 0;
		Slider_MaxFrames[thisel.attr("id")] = thisel.find("ul > li").size();

		if(thisel.attr("rel") == "autoplay"){
			Slider_Start(thisel.attr("id"));
			thisel.find(".slider-play").addClass("pause");
		}else{
			Slider_Stop(thisel.attr("id"));
			thisel.find(".slider-play").removeClass("pause");
		}

		var context;
		for (var i = Slider_MaxFrames[thisel.attr("id")] - 1; i >= 0; i--) {
			context += "<li><a href='#'>"+i+"</a></li>";
		};
		thisel.parent().parent().find("ul.slider-navi").append(context);
	});

	jQuery(".slider-navi a").click(function() {
		var thisel = jQuery(this);
		var thisindex = thisel.parent().index();
		var thisslider = thisel.parent().parent().attr("rel");

		thisel.parent().parent().children("li").removeClass("active");
		thisel.parent().addClass("active");
		jQuery("#"+thisslider).children("ul").css("left", -Math.abs(thisindex*820)+"px");
		Slider_CurrentFrame[thisslider] = thisindex;

		var newframe = (Slider_CurrentFrame[thisslider]+1 >= Slider_MaxFrames[thisslider])?0:Slider_CurrentFrame[thisslider]+1;
		jQuery("#"+thisslider).find(".slider-arrows[href='#slider-right'] .arrow-img").css("background-image", "url("+jQuery("#"+thisslider).find("li").eq(newframe).find(".slider-image img").attr("src")+")");
		var newframee = (Slider_CurrentFrame[thisslider] < 0)?Slider_MaxFrames[thisslider]:Slider_CurrentFrame[thisslider]-1;
		jQuery("#"+thisslider).find(".slider-arrows[href='#slider-left'] .arrow-img").css("background-image", "url("+jQuery("#"+thisslider).find("li").eq(newframee).find(".slider-image img").attr("src")+")");
		return false;
	});

	jQuery(".slider-block").each(function() {
		jQuery(this).parent().parent().find(".slider-navi li").eq(0).find("a").click();
	});

	jQuery(".slider-block [href='#slider-right']").click(function() {
		var thisel = jQuery(this);
		var thisslider = thisel.parent().attr("id");
		var newframe = (Slider_CurrentFrame[thisslider]+1 >= Slider_MaxFrames[thisslider])?0:Slider_CurrentFrame[thisslider]+1;
		jQuery(".slider-navi[rel='"+thisslider+"'] li").eq(newframe).children("a").click();
		Slider_Reset(thisslider);
		return false;
	});

	jQuery(".slider-block [href='#slider-left']").click(function() {
		var thisel = jQuery(this);
		var thisslider = thisel.parent().attr("id");
		var newframe = (Slider_CurrentFrame[thisslider] < 0)?Slider_MaxFrames[thisslider]:Slider_CurrentFrame[thisslider]-1;
		jQuery(".slider-navi[rel='"+thisslider+"'] li").eq(newframe).children("a").click();
		Slider_Reset(thisslider);
		return false;
	});

	jQuery(".slider-block a.slider-play").click(function() {
		var thisel = jQuery(this);
		var thisslider = thisel.parent().attr("id");
		if(!Slider_AutoplayStart[thisslider]){
			thisel.addClass("pause");
			Slider_Start(thisslider);
		}else{
			thisel.removeClass("pause");
			Slider_Stop(thisslider);
		}
		return false;
	});


	jQuery(".photo-gallery-widget").each(function() {
		var thisel = jQuery(this);
		thisel.find(".gallery-images a[href='#right']").addClass("active");
		thisel.find("ul li").eq(0).addClass("active");
	});



	jQuery(".the-article-content .gallery-images a[href='#right']").click(function() {
		var gonegative = 240;
		galScrollRight(jQuery(this), gonegative);
		return false;
	});

	jQuery(".the-article-content .gallery-images a[href='#left']").click(function() {
		var gonegative = 240;
		galScrollLeft(jQuery(this), gonegative);
		return false;
	});

	jQuery(".sidebar-content .gallery-images a[href='#right']").click(function() {
		var gonegative = 27;
		galScrollRight(jQuery(this), gonegative);
		return false;
	});

	jQuery(".sidebar-content .gallery-images a[href='#left']").click(function() {
		var gonegative = 27;
		galScrollLeft(jQuery(this), gonegative);
		return false;
	});

	jQuery(".photo-gallery-block .gallery-images a[href='#right']").click(function() {
		var gonegative = 40;
		galScrollRight(jQuery(this), gonegative);
		return false;
	});

	jQuery(".photo-gallery-block .gallery-images a[href='#left']").click(function() {
		var gonegative = 40;
		galScrollLeft(jQuery(this), gonegative);
		return false;
	});

	jQuery(".small-thumbnails").each(function() {
		var thisel = jQuery(this);
		thisel.find(".inner-thumbs").css("width", (thisel.find("img").size()*105)+"px");
	});



	function galScrollRight(e, gonegative) {
		var thisel = e.parent().find("ul");
		var allitems = thisel.find("li").size();
		var thisitem = thisel.find("li.active").index();

		if(allitems <= 2){var gonegative = gonegative*2;}
		if(thisitem+1 == allitems)return false;

		if(thisitem+2 == allitems){
			thisel.animate({ left: "-="+(300-gonegative)+"px" }, 300);
			thisel.parent().find("a[href='#right']").removeClass("active");
			thisel.parent().find("a[href='#left']").addClass("active");
		}else
		if(thisitem == 0){
			thisel.animate({ left: "-="+(300-gonegative)+"px" }, 300);
			thisel.parent().find("a[href='#left']").addClass("active");
		}else
		if(thisitem < allitems){
			thisel.animate({ left: "-="+(300)+"px" }, 300);
		}
		thisel.parent().find("ul li").removeClass("active");
		thisel.parent().find("ul li").eq(thisitem+1).addClass("active");
	}

	function galScrollLeft(e, gonegative) {
		var thisel = e.parent().find("ul");
		var allitems = thisel.find("li").size();
		var thisitem = thisel.find("li.active").index();

		if(allitems <= 2){var gonegative = gonegative*2;}
		if(thisitem+1 == 1)return false;

		if(thisitem == 1){
			thisel.animate({ left: "+="+(300-gonegative)+"px" }, 300);
			thisel.parent().find("a[href='#left']").removeClass("active");
			thisel.parent().find("a[href='#right']").addClass("active");
		}else
		if(thisitem+1 == allitems){
			thisel.animate({ left: "+="+(300-gonegative)+"px" }, 300);
			thisel.parent().find("a[href='#right']").addClass("active");
		}else
		if(thisitem+1 > 0){
			thisel.animate({ left: "+="+(300)+"px" }, 300);
		}
		thisel.parent().find("ul li").removeClass("active");
		thisel.parent().find("ul li").eq(thisitem-1).addClass("active");
	}

	jQuery(".tabs").each(function() {
		var thisel = jQuery(this);
		thisel.children("div").css("min-height", (parseInt(thisel.css("height"))-30)+"px");
		thisel.children("div").eq(0).addClass("active");
		thisel.children("ul").children("li").eq(0).addClass("active");
	});

	jQuery(".tabs > ul > li a").click(function() {
		var thisel = jQuery(this).parent();
		thisel.siblings(".active").removeClass("active");
		thisel.addClass("active");
		thisel.parent().siblings("div.active").removeClass("active");
		thisel.parent().siblings("div").eq(thisel.index()).addClass("active");
		// alert(thisel.parent().index());
		return false;
	});

	jQuery(".accordion > div > a").click(function() {
		var thisel = jQuery(this).parent();
		if(thisel.hasClass("active")){
			thisel.removeClass("active");
			return false;
		}
		thisel.siblings("div").removeClass("active");
		thisel.addClass("active");
		return false;
	});

	jQuery(".alert-msg > a").click(function() {
		var thisel = jQuery(this).parent();
		thisel.remove();
		return false;
	});
	
	startTimer();


	jQuery(".lightbox").click(function () {
		jQuery(".lightbox").css('overflow', 'hidden');
		jQuery("body").css('overflow', 'auto');
		jQuery(".lightbox .lightcontent").fadeOut('fast');
		jQuery(".lightbox").fadeOut('slow');
	}).children().click(function(e) {
		return false;
	});

});


function lightboxclose(){
	jQuery(".lightbox").css('overflow', 'hidden');
	jQuery(".lightbox .lightcontent").fadeOut('fast');
	jQuery(".lightbox").fadeOut('slow');
	jQuery("body").css('overflow', 'auto');
}

function startTimer(){
	setInterval(function(){
	jQuery(".countdown-text").each(function (){
		var currentTime = jQuery(this).attr("rel");
		var seconds = new Date().getTime() / 1000;
		var seconds = Math.floor(seconds);
		if(currentTime > seconds){
			jQuery(this).html(secondsToHms(currentTime-seconds));
		}else{
			jQuery(this).css("color", "#e62d24");
			jQuery(this).html("00:00:00:00");
		}
	})}, 1000);
}

function addZero(number){
	if(number.toString().length == 1){
		return "0"+number;
	}else{
		return number;
	}
}

function secondsToHms(d) {
	d = Number(d);
	var h = Math.floor(d / 3600);
	var days = addZero(Math.floor(h / (24)));
	var h = addZero(Math.floor((d / 3600)-(days*24)));
	var m = addZero(Math.floor(d % 3600 / 60));
	var s = addZero(Math.floor(d % 3600 % 60));
	return days+":"+h+":"+m+":"+s;
}


// Slider Functions

function Slider_Start(thiselid) {
	if(Slider_AutoplayStart[thiselid])return false;
	Slider_AutoplayStart[thiselid] = true;
	Slider_Temp[thiselid] = setInterval("Slider_Autoplay('"+thiselid+"')", Slider_Speed);
}

function Slider_Stop(thiselid) {
	if(!Slider_AutoplayStart[thiselid])return false;
	Slider_AutoplayStart[thiselid] = false;
	clearInterval(Slider_Temp[thiselid]);
}

function Slider_Reset(thiselid) {
	if(!Slider_AutoplayStart[thiselid])return false;
	Slider_AutoplayStart[thiselid] = true;
	clearInterval(Slider_Temp[thiselid]);
	Slider_Temp[thiselid] = setInterval("Slider_Autoplay('"+thiselid+"')", Slider_Speed);
}

function Slider_Autoplay(thiselid) {
	jQuery(".slider-block#" + thiselid + " a[href='#slider-right']").click();
}


