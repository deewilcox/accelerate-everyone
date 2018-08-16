<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

use Aws\Exception\AwsException;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

session_start();

// Instantiate the app
$settings = require __DIR__ . '/../config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../src/dependencies/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware/middleware.php';

// Register routes
require __DIR__ . '/../src/routes/app-routes.php';

// Run app
$app->run();
