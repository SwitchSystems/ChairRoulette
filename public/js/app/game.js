    "use strict";
$(function() {
	
	startRound();
	
	function startRound() {
		var timeout = 10;
		var delay = roundData['delay'];
		
		createChairs();
		
		var counter = setInterval(musicPlay, 1);
	}
	
	function createChairs() {
		
	}
	
	function musicPlay() {
		delay = delay - 1;
		if (delay <= 0)
	    {
	       clearInterval(counter);
	       musicStop();
	       return;
	    }
	}
	
	function musicStop() {
		$('div.chair').show();
		$('audio').stop();
		
		counter = setInterval(timeoutRound, 1000);
	}
	
	function timeoutRound() {
		timeout = timeout - 1;
		if (timeout <= 0)
	    {
	       clearInterval(counter);
	       endRound();
	       return;
	    }
	}
	
	function endRound() {
		$('div.chair').remove();
		
		startRound();
	}
	
});