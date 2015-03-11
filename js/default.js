// var vid = document.getElementById("bgvid");
// var pauseButton = document.querySelector(".pause button");

// function vidFade() {
//   vid.classList.add("stopfade");
// }

// vid.addEventListener('ended', function()
// {
// // only functional if "loop" is removed 
// vid.pause();
// // to capture IE10
// vidFade();
// }); 

// pauseButton.addEventListener("click", function() {
//   vid.classList.toggle("stopfade");
//   if (vid.paused) {
//     vid.play();
//     pauseButton.innerHTML = "<span class='glyphicon glyphicon-pause'></span>";
//   } else {
//     vid.pause();
//     pauseButton.innerHTML = "<span class='glyphicon glyphicon-play'></span>";
//   }
// })

// var md = new MobileDetect(window.navigator.userAgent);

// console.log( md.mobile() );          // 'iPhone' | 'Sony' | etc | 'null' if desktop/laptop
// console.log( md.phone() );           // 'iPhone'
// console.log( md.tablet() );          // null
// console.log( md.userAgent() );       // 'Safari'
// console.log( md.os() );              // 'iOS'
// console.log( md.is('iPhone') );      // true
// console.log( md.is('bot') );         // false
// console.log( md.version('Webkit') );         // 600.13
// console.log( md.versionStr('Build') );       // 'null'
// console.log( md.match('playstation|xbox') );	// false

// if (md.mobile() != null) {
// 	//console.log("on a mobile..");
// 	$('#bgvid').remove();
// 	$('#pauseButton').remove();
// }

$(function() {
    var iframe = $('#trailer')[0];
    var player = $f(iframe);
    var status = $('.status');

    // When the player is ready, add listeners for pause, finish, and playProgress
    player.addEvent('ready', function() {
        status.text('ready');
        
        player.addEvent('pause', onPause);
        player.addEvent('play', onPlay);
        player.addEvent('finish', onFinish);
    });

    // Call the API when a button is pressed
    $('button').bind('click', function() {
        player.api($(this).text().toLowerCase());
    });

    function onPause(id) {
        status.text('paused');
    }

    function onPlay(id) {
        console.log('playing');
        api.playToggle();
    }

    function onFinish(id) {
        status.text('finished');
    }
});

