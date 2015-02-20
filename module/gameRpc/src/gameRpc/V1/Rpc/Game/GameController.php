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

    public function getRoomsListAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $room = $this->memcached->get($roomHash);

        return ['result' => $room];
    }

    public function addPlayerToRoom()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $room = $this->memcached->get($roomHash);


    }

    public function createRoomAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $roomName = $this->params()->fromPost('roomName');
        $id = $this->params()->fromPost('id');
        $playerName = $this->params()->fromPost('playerName');

        $roomData = [
            'roomName' => $roomName,
            'canJoin' => true,
            'currentRound' => 0,
            'players' => [
                [
                    'id' => $id,
                    'name' => $playerName
                ]
            ]
        ];

        $room = $this->memcached->set($roomHash, $roomData);

        return ['result' => $room];
    }

    public function getRoundAction()
    {
    	$roomHash = $this->params()->fromPost('roomHash');
    	$room = $this->memcached->get($roomHash);
    	
    	$round = $this->memcached->get($roomHash.'_'.$room->roundNumber);
    	
        return ['result' => $round];
    }

    public function getRoundAction()
    {
    	$roomHash = $this->params()->fromPost('roomHash');
    	
    	$round = $this->memcached->get($roomHash.'_'.$room->roundNumber);

        return ['result' => $round];
    }
    
    public function sitOnChairAction()
    {
    	$roomHash = $this->params()->fromPost('roomHash');
    	$chairHash = $this->params()->fromPost('chairHash');
    	$reactionTime = $this->params()->fromPost('reaction');
    	$userHash = $this->params()->fromPost('userHash');
    	
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
    	for($i=0;$i<count($roundActivePlayers)-1;$i++)
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
