<?php
namespace gameRpc\V1\Rpc\Game;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;

class GameController extends AbstractActionController
{
    protected $memcached;

    public function __construct($memcached)
    {
        $this->memcached = $memcached;
    }

    public function getRoomAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $room = $this->memcached->get($roomHash);

        return ['result' => $room];
    }

    public function unJoinRoomAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $room = $this->memcached->get($roomHash);
        $playerId = $this->params()->fromPost('playerId');

        unset($room['players'][$playerId]);

        return ['result' => $room];
    }

    public function deactivateRoomAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $room = $this->memcached->get($roomHash);
        $room['isActive'] = false;

        return ['result' => $room];
    }

    public function getRoomsListAction()
    {
        $rooms = $this->memcached->get('rooms');

        return ['result' => $rooms];
    }

    public function addPlayerToRoomAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $playerId = $this->params()->fromPost('id');
        $playerName = $this->params()->fromPost('name');
        $room = $this->memcached->get($roomHash);

        if ($room['playerCount'] == 4) {
            return ['result' => 'Sorry the room is full'];
        }

        $room['playerCount'] = $room['playerCount'] + 1;
        $room['players'][] = ['id' => $playerId, 'name' => $playerName];

        return ['result' => $room];
    }

    public function createRoomAction()
    {
    	
        $roomName = $this->params()->fromPost('roomName');
        $roomHash = md5($roomName + time());
        $playerId = $this->params()->fromPost('playerId');
        $playerName = $this->params()->fromPost('playerName');

        $roomData = [
            'roomName' => $roomName,
            'roomHash' => $roomHash,
            'canJoin' => true,
            'isActive' => true,
            'currentRound' => 0,
            'playerCount' => 1,
            'players' => [
                [
                    'id' => $playerId,
                    'name' => $playerName
                ]
            ],
        ];

        $rooms = $this->memcached->get('rooms');
        $room = $this->memcached->set($roomHash, $roomData);

        if ($rooms === null) {
            $rooms = [$room];
        } else {
            $rooms[$roomHash] = $room;
        }

        $this->memcached->set('rooms', $rooms);

        return ['result' => $room];
    }

    public function getRoundAction()
    {
    	$roomHash = $this->params()->fromPost('roomHash');
    	$room = $this->memcached->get($roomHash);
    	
    	$round = $this->memcached->get($roomHash.'_'.$room->roundNumber);

        return ['result' => $round];
    }
    
    public function sitOnChairAction()
    {
    	$roomHash = $this->params()->fromPost('roomHash');
    	$chairHash = $this->params()->fromPost('chairHash');
    	$reactionTime = $this->params()->fromPost('reaction');
    	$userHash = $this->params()->fromPost('userHash');
        $room = $this->memcached->get($roomHash);

        $round = $this->memcached->get($roomHash.'_'.$room->roundNumber);
    	
    	$player = new \stdClass();
    	$player->id = $userHash;
    	$player->time = $reactionTime;
    	
    	$round->chairs->{$chairHash}->players[] = $player;
    	
    	$this->memcached->set($roomHash.'_'.$room->roundNumber,$round);
    	
    	return ['result' => $round];
    }
    
    public function createRoundAction()
    {
    	$roomHash = $this->params()->fromPost('roomHash');
    	$room = $this->memcached->get($roomHash);
    	exit(var_dump($room));
    	//increment round
    	$room->currentRound++;

        //create new round object
    	$round = new \stdClass();
    	$round->roundNumber = $room->currentRound;
    	$round->delay = mt_rand(5,15);
        $round->startTime = time();
    	$round->status = 'play';
    	$round->activePlayers = [];
    	
    	foreach($room->players as $player)
    		$round->activePlayers[] = $player->name;
    	
    	$round->chairs = new \stdClass();
    	for($i=0;$i<count($round->activePlayers)-1;$i++)
    	{
    		$chair = new \stdClass();
    		$chair->id = uniqid(null,true);
    		$chair->x = mt_rand(0,500);
    		$chair->y = mt_rand(0,500);
    		$chair->players = [];
    		
    		$round->chairs->{uniqid(null,true)} = $chair;
    	}
    	
    	
    	$this->memcached->set($roomHash,$room);
    	$this->memcached->set($roomHash.'_'.$room->currentRound);
    	
    	return ['result' => $round];
    }
    
}
