// responsiveImg
$(function(){
	var options = {
		size: [
			{device:'web',size:null},
			{device:'mobile',size:1024}
			
		]
	}
		,list = []
		,win = $(window)
		,before_model = null
		,inited = false
		,chkWidth = 1440;

	function cal(width){
		var model = '';	
		chkWidth = 1440;
		model = 'web';
		
		for(var i = 0;i < options.size.length; i++)
		{
			if(options.size[i].size>=width && options.size[i].size <= chkWidth)
			{
				model = options.size[i].device;
				if(options.size[i].size != null)
					chkWidth = options.size[i].size;
			}
		}
		return model;
	}
	function sort_func(a,b){
		return a.size == null ? false : b.size == null ? true : (a.size > b.size);
	}
	function resize(){
		//var w = win.width();
		var w = viewportWidth();		
		var model = cal(w);		
		if(model == before_model) return;
		before_model = model;
		$.each(list,function(i,elem){
			var src = null;
			(src = elem.getAttribute('data-media-'+model)) && (elem.src != src) && (elem.src = src);
		});
	}
	function init(args,THIS){
		if(args){
			$.extend(options,args);
		}
		list = $(THIS);
		options.size.sort(sort_func);
		inited || win.on('resize',resize) && (inited = true)
		resize();
		if(check_allDevice() != "")
			$(".new_sec_pdp").addClass("device");
		else
			$(".new_sec_pdp").addClass("pc");

		function getInternetExplorerVersion()
		{
		  var rv = -1; // Return value assumes failure.
		  if (navigator.appName == 'Microsoft Internet Explorer')
		  {
		    var ua = navigator.userAgent;
		    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
		    if (re.exec(ua) != null)
		      rv = parseFloat( RegExp.$1 );
		  }
		  return rv;
		}
		var ieVersion = getInternetExplorerVersion();
		if (ieVersion == 8) {
			document.body.onresize = function () {
				resize();
			};
		}
		else {
			window.addEventListener("resize", resize);		
		}
	}
	function refresh(elem){
		list = $(elem);
	}
	var method = {
		init: init,
		refresh: refresh
	}
	$.fn.responsive = function(args){
		if(typeof args == 'undefined'){
			method['init'](null,this);
		}else if(typeof args == 'object'){
			method['init'](args,this);
		}else if(typeof args == 'string' && method[args]){
			method[args](this);
		}
		return this;
	}


	$('img.responsiveImg').responsive({
		size:[
			{device:'web',size:null},
			{device:'mobile',size:1024}
		]
	});
});

function viewportWidth() 
{  
	
	if (typeof document.documentElement.clientWidth != 'undefined' && typeof window.innerWidth != 'undefined')  
	{
		if(document.documentElement.clientWidth > window.innerWidth)
			return document.documentElement.clientWidth;
		else
			return window.innerWidth;  
	}else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0)
	{
		return document.documentElement.clientWidth;  
	}else{
		return viewportwidth = document.getElementsByTagName('body')[0].clientWidth;
	} 
}

function check_allDevice(){
	var mobileKeyWords = new Array('iPhone', 'iPad', 'iPod', 'BlackBerry', 'Android', 'Windows CE', 'LG', 'MOT', 'SAMSUNG', 'SonyEricsson'); 
	var device_name = '';
	for (var word in mobileKeyWords){
		if (navigator.userAgent.match(mobileKeyWords[word]) != null){
			device_name = mobileKeyWords[word];
			break;
		}
	}

	return device_name;
}

