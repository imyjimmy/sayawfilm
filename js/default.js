var vid = document.getElementById("bgvid");
var pauseButton = document.querySelector(".pause button");

function vidFade() {
  vid.classList.add("stopfade");
}

vid.addEventListener('ended', function()
{
// only functional if "loop" is removed 
vid.pause();
// to capture IE10
vidFade();
}); 

pauseButton.addEventListener("click", function() {
  vid.classList.toggle("stopfade");
  if (vid.paused) {
    vid.play();
    pauseButton.innerHTML = "<span class='glyphicon glyphicon-pause'></span>";
  } else {
    vid.pause();
    pauseButton.innerHTML = "<span class='glyphicon glyphicon-play'></span>";
  }
})

var md = new MobileDetect(window.navigator.userAgent);

console.log( md.mobile() );          // 'iPhone' | 'Sony' | etc | 'null' if desktop/laptop
console.log( md.phone() );           // 'iPhone'
console.log( md.tablet() );          // null
console.log( md.userAgent() );       // 'Safari'
console.log( md.os() );              // 'iOS'
console.log( md.is('iPhone') );      // true
console.log( md.is('bot') );         // false
console.log( md.version('Webkit') );         // 600.13
console.log( md.versionStr('Build') );       // 'null'
console.log( md.match('playstation|xbox') );	// false

if (md.mobile() != null) {
	//console.log("on a mobile..");
	$('#bgvid').remove();
	$('#pauseButton').remove();
}
