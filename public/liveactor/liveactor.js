function hide(obj){
var divobject = document.getElementById(obj);
divobject.style.display = "none";
}

function show(obj){
var divobject = document.getElementById(obj);
divobject.style.display = "";
}

function createCookie( name, value, expires, path, domain, secure, playoncepervisit ) 
{
// set time, it's in milliseconds
var today = new Date();
today.setTime( today.getTime() );
if ( playoncepervisit == true ){
	var expires_date = new Date( today.getTime() - 6000);
	document.cookie = name + "=" +escape( value ) + ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + ( ( path ) ? ";path=" + path : "" ) + ( ( domain ) ? ";domain=" + domain : "" ) + ( ( secure ) ? ";secure" : "" );
}else{
	if ( expires ){expires = expires * 1000 * 60 * 60;}
	var expires_date = new Date( today.getTime() + (expires) );
	document.cookie = name + "=" +escape( value ) + ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) + ( ( path ) ? ";path=" + path : "" ) + ( ( domain ) ? ";domain=" + domain : "" ) + ( ( secure ) ? ";secure" : "" );
	}
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		//if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		if (c.indexOf(nameEQ) == 0) return true;
	}
	return false;
}

function getFlashMovieObject(movieName)
{
  if (window.document[movieName]) 
  {
      return window.document[movieName];
  }
  if (navigator.appName.indexOf("Microsoft Internet")==-1)
  {
    if (document.embeds && document.embeds[movieName])
      return document.embeds[movieName]; 
  }
  else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
  {
    return document.getElementById(movieName);
  }
}

function playtime(Ttime,Video,playoncepervisit){
	var flashmovie = getFlashMovieObject("mymovie");
	if (readCookie(Video)){
	flashmovie.SetVariable("cookieautoplay", "false");
	}else{
	createCookie(Video, 'timeout', Ttime, '/', '', '' , playoncepervisit);
	flashmovie.SetVariable("cookieautoplay", "true");
	}
}
function playvideo(videotoplay){
	var flashmovie = getFlashMovieObject(videotoplay);
	flashmovie.SetVariable("playvideo", "true");	
}
function stopvideo(videotoplay){
	var flashmovie = getFlashMovieObject(videotoplay);
	flashmovie.SetVariable("stopvideo", "true");	
}
function pausevideo(videotoplay){
	var flashmovie = getFlashMovieObject(videotoplay);
	flashmovie.SetVariable("pausevideo", "true");	
}