<?php

return [
    '/' => 'user/user/login',

    '<module:\w+>/<controllers:\w+>/<id:\d+>' => '<module>/<controllers>/views?id=',
    '<module:\w+>/<controllers:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controllers>/<action>',
    '<module:\w+>/<controllers:\w+>/<action:\w+>' => '<module>/<controllers>/<action>',
];