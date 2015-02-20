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

    public function getRoomAction()
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
        return ['result' => null];
    }

    public function setRoundAction()
    {

        return ['result' => null];
    }
}
