<?php
return array(
    'controllers' => array(
        'factories' => array(
            'gameRpc\\V1\\Rpc\\Game\\Controller' => 'gameRpc\\V1\\Rpc\\Game\\GameControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'game-rpc.rpc.game' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/game',
                    'defaults' => array(
                        'controller' => 'gameRpc\\V1\\Rpc\\Game\\Controller',
                        'action' => 'game',
                    ),
                ),
                'child_routes' => [
                    'getRoom' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/get-room',
                            'defaults' => array(
                                'action'     => 'getRoom',
                            ),
                        ),
                    ),
                    'setRoom' => array(
                        'type' => 'Zend\Mvc\Router\Http\Segment',
                        'options' => array(
                            'route'    => '/set-room',
                            'defaults' => array(
                                'action'     => 'setRoom',
                            ),
                        ),
                    ),
                ]
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'game-rpc.rpc.game',
        ),
    ),
    'zf-rpc' => array(
        'gameRpc\\V1\\Rpc\\Game\\Controller' => array(
            'service_name' => 'game',
            'http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'route_name' => 'game-rpc.rpc.game',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'gameRpc\\V1\\Rpc\\Game\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'gameRpc\\V1\\Rpc\\Game\\Controller' => array(
                0 => 'application/vnd.game-rpc.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
                3 => 'application/x-www-form-urlencoded'
            ),
        ),
        'content_type_whitelist' => array(
            'gameRpc\\V1\\Rpc\\Game\\Controller' => array(
                0 => 'application/vnd.game-rpc.v1+json',
                1 => 'application/json',
                2 => 'application/x-www-form-urlencoded'

            ),
        ),
    ),
);
