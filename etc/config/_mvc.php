<?php

// load functions
require_once __DIR__ . '/Phormix/config/_function.php';

// load config
require_once __DIR__ . '/Phormix/config/config.php';

// add routing dir
$aConfig['MVC_ROUTING_DIR'][] = realpath(__DIR__ . '/../') . '/routing';
