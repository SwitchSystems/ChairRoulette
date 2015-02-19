    "use strict";
$(function() {
	
	var board = $('div.game-board');
	var round = '<h1 class="round">Round: ';
	
	startRound();
	
	function startRound() {
		var timeout = 10;
		var delay = roundData['delay'];
		
		board.append(round+roundData['roundNumber']+'</h1>');
		
		createChairs();
		
		var counter = setInterval(musicPlay, 1);
	}
	
	function createChairs() {
		var chairs = roundData['chairs'];
		var chair;
		
		for(chair in chairs) {
			board.append('<div class="chair" id="'+chair['id']+'">');
			chairElement = $('div#'+chair['id']);
			chairElement.style.position = "absolute";
			chairElement.style.left = chair['x'];
			chairElement.style.top = chair['y'];
			chairElement.hide();
		}
		
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
		$('h1.round').remove();
		$('div.chair').remove();
		
		startRound();
	}
	
});