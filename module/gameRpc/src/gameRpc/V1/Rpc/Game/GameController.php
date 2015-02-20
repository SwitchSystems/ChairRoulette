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
        $rooms = $this->memcached->get('rooms');

        return ['result' => $rooms];
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
        $playerId = $this->params()->fromPost('playerId');
        $playerName = $this->params()->fromPost('playerName');

        $roomData = [
            'roomName' => $roomName,
            'canJoin' => true,
            'currentRound' => 0,
            'players' => [
                [
                    'id' => $playerId,
                    'name' => $playerName
                ]
            ]
        ];

        $rooms = $this->memcached->get('rooms');

        if ($rooms === null) {
            $rooms = [$roomHash];
        } else {
            $rooms[] = $roomHash;
        }

        $this->memcached->set('rooms', $rooms);
        $room = $this->memcached->set($roomHash, $roomData);

        return ['result' => $room];
    }

    public function getRoundAction()
    {
        return ['result' => null];
    }

    public function setRoundAction()
    {

        return ['result' => null];
    }
}
