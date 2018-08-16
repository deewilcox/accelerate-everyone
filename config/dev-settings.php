<?php
return [
    'settings' => [
        'env' => 'dev',
        
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
	    'determineRouteBeforeAppMiddleware' => true, // Determine the route in the Request object

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'ae-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // AWS settings
        'aws' => [
            'profile' => 'ae-dev',
            'region'   => 'us-east-1',
            'version'  => 'latest',
            'endpoint'   => 'http://localhost:8000',
            'DynamoDb' => [
                'arn' => ''
            ]
        ],
    ],
];
