/* global.js : Functions to support features available globally throughout ResourceSpace */

// prevent all caching of ajax requests by stupid browsers like IE
jQuery.ajaxSetup({ cache: false });

// function to help determine exceptions
function basename(path) {
    return path.replace(/\\/g,'/').replace( /.*\//, '' );
}

// IE 8 does not support console.log unless developer dialog is open, so we need a failsafe here if we're going to use it for debugging
   var alertFallback = false;
   if (typeof console === "undefined" || typeof console.log === "undefined") {
     console = {};
     if (alertFallback) {
         console.log = function(msg) {
              alert(msg);
         };
     } else {
         console.log = function() {};
     }
   }

// Cookie functions
function SetCookie (cookieName,cookieValue,nDays)
	{
	/* Store a cookie */
	var today = new Date();
	var expire = new Date();
	if (nDays==null || nDays==0) nDays=1;
	expire.setTime(today.getTime() + 3600000*24*nDays);
	document.cookie = cookieName+"="+escape(cookieValue)
       + ";expires="+expire.toGMTString();
	}

function getCookie(c_name)
{
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
		x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
		y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
		x=x.replace(/^\s+|\s+$/g,"");
		if (x==c_name)
		{
			return unescape(y);
		}
	}
}



/* Keep a global array of timers */
var timers = new Array();
var loadingtimers = new Array();

function ClearTimers()
	{
	// Remove all existing page timers.
	for (var i = 0; i < timers.length; i++)
    	{
	    clearTimeout(timers[i]);
	    }
	}

function ClearLoadingTimers()
	{
	// Remove all existing page timers.
	for (var i = 0; i < loadingtimers.length; i++)
    	{
	    clearTimeout(loadingtimers[i]);
	    }
	}





/* AJAX loading of central space contents given a link */
function CentralSpaceLoad (anchor,scrolltop)
	{
		
	// Handle straight urls:
	if (typeof(anchor)!=='object'){ 
		var plainurl=anchor;
		var anchor = document.createElement('a');
		anchor.href=plainurl;
	}

	var CentralSpace=jQuery('#CentralSpace');
	
	/* Handle link normally if the CentralSpace element does not exist */
	if (!CentralSpace)
		{
		location.href=anchor.href;
		return false;
		} 

	/* more exceptions, going to or from pages without header */
	var fromnoheader=false;
	var tonoheader=false;
	if (
			basename(window.location.href).substr(0,11)=="preview.php" 
			||
			basename(window.location.href).substr(0,15)=="preview_all.php" 
			||
			basename(window.location.href).substr(0,9)=="index.php" 
			||
			basename(window.location.href).substr(0,8)=="done.php"
			||
			basename(window.location.href).substr(0,16)=="team_plugins.php"
		) { 
			fromnoheader=true; 
		}
		
	if (	
			basename(anchor.href).substr(0,11)=="preview.php"
			||
			basename(anchor.href).substr(0,15)=="preview_all.php"
			||
			basename(anchor.href).substr(0,9)=="index.php" 

		) {
			tonoheader=true;
		}

	// XOR to allow these pages to ajax with themselves
	if( ( tonoheader || fromnoheader ) && !( fromnoheader && tonoheader ) ) { 
			location.href=anchor.href;return false;
		}
	
	var url = anchor.href;
	
	if (url.indexOf("?")!=-1)
		{
		url += '&ajax=true';
		}
	else
		{
		url += '?ajax=true';
		}

	// Fade out the link temporarily while loading. Helps to give the user feedback that their click is having an effect.
	jQuery(anchor).fadeTo(0,0.6);
	
	// Start the timer for the loading box.
	CentralSpaceShowLoading(); 
	var prevtitle=document.title;
	
	CentralSpace.load(url, function (response, status, xhr)
		{
		if (status=="error")
			{
			CentralSpaceHideLoading();
			CentralSpace.html(errorpageload  + xhr.status + " " + xhr.statusText + "<br>" + response);
			jQuery(anchor).fadeTo(0,1);
			}
		else
			{
			// Load completed
			CentralSpaceHideLoading();
			jQuery(anchor).fadeTo(0,1);

			if (rewriteUrls){
				relToAbs("#CentralSpace",url);
			}

			//console.log('loaded ' + url);
		
			// Change the browser URL and save the CentralSpace HTML state in the browser's history record.
			if(typeof(top.history.pushState)=='function')
				{
				var newtitle=document.title;
				
				document.title=prevtitle;
				top.history.pushState(CentralSpace.html(), applicationname, anchor.href);
				
				document.title=newtitle;
				}
			}
			
			/* Scroll to top if parameter set - used when changing pages */
			if (scrolltop==true) {
				if (jQuery("#CollectionDiv").length==0){
					jQuery('body').animate({scrollTop:0}, 'fast');
				} else {
					jQuery('.ui-layout-center').animate({scrollTop:0}, 'fast');
				}	
			}
			
		});
		
		
	return false;
	}


/* When back button is clicked, reload AJAX content stored in browser history record */
top.window.onpopstate = function(event)
	{
	if (!event.state) {return true;} // No state
	jQuery('#CentralSpace').html(event.state);
	}


/* AJAX posting of a form, result are displayed in the CentralSpace area. */
function CentralSpacePost (form,scrolltop)
	{
	var url=form.action;
	var CentralSpace=jQuery('#CentralSpace');// for ajax targeting top div

	if (url.indexOf("?")!=-1)
		{
		url += '&ajax=true';
		}
	else
		{
		url += '?ajax=true';			
		}

	CentralSpaceShowLoading();		
	
	var prevtitle=document.title;
	jQuery.post(url,jQuery(form).serialize(),function(data)
		{
		CentralSpaceHideLoading();
		CentralSpace.html(data);
		if (rewriteUrls){relToAbs("#CentralSpace",url);}
		
		//console.log('ajax posted to ' + form.action);
		
		// Change the browser URL and save the CentralSpace HTML state in the browser's history record.
		if(typeof(top.history.pushState)=='function')
			{
			var newtitle=document.title;
				
			document.title=prevtitle;
			top.history.pushState(data, applicationname, form.action);
				
			document.title=newtitle;		
			}
			
		/* Scroll to top if parameter set - used when changing pages */
		if (scrolltop==true) {
			if (jQuery("#CollectionDiv").length==0){
				jQuery('body').animate({scrollTop:0}, 'fast');
			} else {
				jQuery('.ui-layout-center').animate({scrollTop:0}, 'fast');
			}	
		}
			
		return false;
		})

	.error(function(result) {
		if (result.status>0)                        
			{
			CentralSpaceHideLoading();
			CentralSpace.html(errorpageload + result.status + ' ' + result.statusText + '<br>URL:  ' + url + '<br>POST data: ' + jQuery(form).serialize()); 
			return false;
			}
		});
	return false;
	}


function CentralSpaceShowLoading()
	{
	ClearLoadingTimers();
	loadingtimers.push(window.setTimeout("jQuery('#CentralSpace').fadeTo('fast',0.7);jQuery('#LoadingBox').fadeIn('fast');",ajaxLoadingTimer));
	}

function CentralSpaceHideLoading()
	{
	ClearLoadingTimers();
	jQuery('#LoadingBox').fadeOut('fast');  
	jQuery('#CentralSpace').fadeTo('fast',1);
	}



function relToAbs(context,url){

	var context=jQuery(context);

	var urlsplit=url.split(baseurl_short);
	if (urlsplit.length>1 && baseurl_short!="/"){
			url=baseurl_short+urlsplit[1];
			}
	else {url=url.replace(baseurl,'');}

	// rewrite relative urls http://aknosis.com/2011/07/17/using-jquery-to-rewrite-relative-urls-to-absolute-urls-revisited/        
	context.find('a').not('a:not([href]),[href^="http"],[href^="https"],[href^="mailto:"],[href^="#"]').each(function() {
		jQuery(this).attr('href', function(index, value) {
			if (value.substr(0,1) !== "/") {
				//alert (url.substring(0,url.lastIndexOf('/')+1)+ '   '+value);
				var newvalue = url.substring(0,url.lastIndexOf('/')+1) + value;
				if (rewriteUrlsDebug){console.log('rewrote a.href '+value + ' as '+newvalue);}
				return newvalue;
			}			
		});
	});
	// do the same with image src tags   
	context.find('img').not('img:not([src]),[src^="http"],[src^="https"],[src^="mailto:"],[src^="#"],[src^="data:"]').each(function() {
							
		jQuery(this).attr('src', function(index, value) {
			if (value.substr(0,1) !== "/") {
				var newvalue = url.substring(0,url.lastIndexOf('/')+1) + value;
				if (rewriteUrlsDebug){console.log('rewrote img '+value + ' as '+newvalue);} 	
				return newvalue;
			}
		});
	});   

	// do the same with form action   
	context.find('form').not('form:not([action]),[action^="http"],[action^="https"],[action^="#"]').each(function() {
		
		jQuery(this).attr('action', function(index, value) {
			if (value === "") { // support blank form actions by adding the url given
				var newvalue = url;
				if (rewriteUrlsDebug){console.log('rewrote blank form action '+value + ' as '+newvalue);}
				return newvalue;
			}
			else if (value.substr(0,1) !== "/") {
				var newvalue = url.substring(0,url.lastIndexOf('/')+1) + value;
				if (rewriteUrlsDebug){console.log('rewrote form action '+value + ' as '+newvalue);}
				return newvalue;
			}
			
		});
	});  

	// fix any iframes
	context.find('iframe').not('iframe:not([src]),[src^="http"],[src^="https"],[src^="#"]').each(function() {
		
		jQuery(this).attr('src', function(index, value) {
			if (value.substr(0,1) !== "/") {
				var newvalue = url.substring(0,url.lastIndexOf('/')+1) + value;
				if (rewriteUrlsDebug){console.log('rewrote iframe.src '+value + ' as '+newvalue);}
				return newvalue;
			}
		});
	});   

	// same with script src
	context.find('script').not('script:not([src]),[src^="http"],[src^="https"],[src^="#"]').each(function() {
		
		jQuery(this).attr('src', function(index, value) {
			if (value.substr(0,1) !== "/") {
				var newvalue = url.substring(0,url.lastIndexOf('/')+1) + value;
				if (rewriteUrlsDebug){console.log('rewrote script src '+value + ' as '+newvalue);} 
				return newvalue;
			}
		});
	});   
	  
}

// initial page load
if (rewriteUrls){
	jQuery(document).ready(function(){
		if (rewriteUrlsDebug){console.log("checking "+location.href);}
		relToAbs(this,location.href);
	});
}






/* AJAX loading of CollectionDiv contents given a link */
function CollectionDivLoad (anchor,scrolltop)
	{
	// Handle straight urls:
	if (typeof(anchor)!=='object'){ 
		var plainurl=anchor;
		var anchor = document.createElement('a');
		anchor.href=plainurl;
	}
	
	/* Handle link normally if the CollectionDiv element does not exist */
	
	if (jQuery('#CollectionDiv').length==0 && top.collections!==undefined)
		{
		top.collections.location.href=anchor.href;
		return false;
		} 
		
	/* Scroll to top if parameter set - used when changing pages */
	if (scrolltop==true) {jQuery('.ui-layout-south').animate({scrollTop:0}, 'fast');};
	
	var url = anchor.href;
	
	if (url.indexOf("?")!=-1)
		{
		url += '&ajax=true';
		}
	else
		{
		url += '?ajax=true';
		}
	
	jQuery('#CollectionDiv').load(url, function ()
		{
		if (rewriteUrls){
			relToAbs("#CollectionDiv",url);
		}
		// it's helpful at this stage to know when an ajax load happened for debugging purposes
		console.log('loaded CollectionDiv ' + url);
			
		});
		
		
	return false;
	}


function directDownload(url)
	{
	dlIFrma = document.getElementById('dlIFrm');
	dlIFrma.src = url;  
	}
