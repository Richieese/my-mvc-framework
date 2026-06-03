<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));

require BASE_PATH . '/vendor/autoload.php';

$app = new Core\Application(BASE_PATH);
$app->run();
