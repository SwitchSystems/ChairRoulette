    "use strict";
$(function() {
	
	var board = $('div#game-area');
	board.style.width = '550px';
	board.style.height = '550px';
	var round = '<h1 class="round">Round: ';
	startRound();
	
	function startRound() {
		$('div#gameintro').hide();
		
		var timeout = 10;
		var delay = roundData['delay'];
		
		board.append(round+roundData['roundNumber']+'</h1>');
		
		createChairs();
		displayPlayers();
		
		var counter = setTimeout(musicStop, delay);
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
	
	function musicStop() {
		$('div.chair').show();
		$('audio').stop();
		
		counter = setTimeout(endRound, 5000);
	}
	
	function endRound() {
		$('h1.round').remove();
		$('div.chair').remove();
		
		startRound();
	}
	
	function displayPlayers() {
		var playerData = roundData['activePlayers'];
		var player;
		
		$('div.players p').each(function() {
			this.style.color = 'red';
		});
		
		for(player in playerData) {
			if(! $('p#'+player).length >= 0) {
				$('div.players').append('<p id="'+player'">'+players['name']+'</p>');
			}
			$('p#'+player).style.color = 'green';
		}
	}
	
});
