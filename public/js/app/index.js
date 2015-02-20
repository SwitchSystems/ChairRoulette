"use strict";

$(function() {
	
	fetchRoomsDetails();
	
	// index functions
	function fetchRoomsDetails()
	{
		$('#roomsList').empty();
		
		var roomUrl = 'http://chairroulette.vagrant/api/game/get-rooms-list';
		$.ajax(roomUrl,{
			dataType: 'json',
			error : function() {
				$('#roomsList').append('<div class="alert alert-warning">Oh Nos! Something went wrong finding rooms.</div>');
			},
			success: function(data) {
				renderRooms(data);
			},
		});
	}
	
	
	function renderRooms(rooms)
	{
		if (rooms.length == 0)
		{
			$('#roomsList').append('<div class="alert alert-info">No rooms found</div>');
		} else {
			
			for(var i = 0; i < rooms.length; i++)
			{
				var roomStr = '';
				roomStr += '<div class="room"><form method="get" action="/room/' + rooms[i].roomKey + '/">';
				
				if (rooms[i].canJoin == 1)
				{
					roomStr += '<input type="submit" class="btn btn-primary btn-mini" value="Join Game" />';
				} else {
					roomStr += '<span class="label label-warning roomclosed">Closed</span>';
				}
				
				var players = 0;
				if (rooms[i].players !== undefined)
					players = rooms[i].players.length;
				
				roomStr += ' &nbsp; ' + rooms[i].roomName + ' (' + players + ' Players)';
				
				roomStr += '</form><div class="clear"></div></div>';
				
				$('#roomsList').append(roomStr);
			}
		}
	}
	
	function createRoom()
	{
		
	}
	
});