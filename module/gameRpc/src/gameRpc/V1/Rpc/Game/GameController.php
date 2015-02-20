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

    public function setRoomAction()
    {
        $roomHash = $this->params()->fromPost('roomHash');
        $this->params()->fromPost('roomData');

        $roomData = [

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
