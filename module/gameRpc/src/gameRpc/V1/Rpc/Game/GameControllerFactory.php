<?php
namespace gameRpc\V1\Rpc\Game;

class GameControllerFactory
{
    public function __invoke($controllers)
    {
        return new GameController();
    }
}
