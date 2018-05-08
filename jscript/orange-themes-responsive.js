jQuery(document).ready(function(){
	jQuery(window).bind("resize", orange_responsive);
	orange_responsive();
});

var iPhoneVertical = Array(null,320,"css/responsive/phonevertical.css?"+Date());
var iPhoneHorizontal = Array(321,860,"css/responsive/phonehorizontal.css?"+Date());
var iPad = Array(861,1200,"css/responsive/ipad.css?"+Date());
var dekstop = Array(1201,null,"css/responsive/desktop.css?"+Date());

var is_orange_mobile = false;

function orange_responsive(){
	var newWindowWidth = jQuery(window).width();
	if(newWindowWidth >= dekstop[0]){
		if(jQuery("#style-responsive").attr("href") == dekstop[2])return;
		jQuery("#style-responsive").attr({href : dekstop[2]});
		is_orange_mobile = false;
	}else if(newWindowWidth >= iPad[0] && newWindowWidth <= iPad[1]){
		if(jQuery("#style-responsive").attr("href") == iPad[2])return;
		jQuery("#style-responsive").attr({href : iPad[2]});
		is_orange_mobile = false;
	}else if(newWindowWidth >= iPhoneHorizontal[0] && newWindowWidth <= iPhoneHorizontal[1]){
		if(jQuery("#style-responsive").attr("href") == iPhoneHorizontal[2])return;
		jQuery("#style-responsive").attr({href : iPhoneHorizontal[2]});
		is_orange_mobile = true;
	}else if(newWindowWidth <= iPhoneVertical[1]){
		if(jQuery("#style-responsive").attr("href") == iPhoneVertical[2])return;
		jQuery("#style-responsive").attr({href : iPhoneVertical[2]});
		is_orange_mobile = true;
	}
}

orange_responsive();