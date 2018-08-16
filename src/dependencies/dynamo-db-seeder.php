<?php
require '../vendor/autoload.php';

date_default_timezone_set('UTC');

use Aws\DynamoDb\Exception\DynamoDbException;

$sdk = new Aws\Sdk([
    'endpoint'   => 'http://localhost:8000',
    'region'   => 'us-east-1',
    'version'  => 'latest'
]);

$dynamodb = $sdk->createDynamoDb();

// Create Bosses table
$bossParams = [
    'TableName' => 'ae_bosses',
    'KeySchema' => [
        [
            'AttributeName' => 'id',
            'KeyType' => 'NUMBER'  //Partition key
        ],
        [
            'AttributeName' => 'organization_id',
            'KeyType' => 'NUMBER'  //Sort key
        ]
    ],
    'AttributeDefinitions' => [
        [
            'AttributeName' => 'active',
            'AttributeType' => 'S'
        ],
        [
            'AttributeName' => 'nickname',
            'AttributeType' => 'S'
        ],
        [
            'AttributeName' => 'create_datetime',
            'AttributeType' => 'S'
        ],
        [
            'AttributeName' => 'update_datetime',
            'AttributeType' => 'S'
        ],
        [
            'AttributeName' => 'removed_datetime',
            'AttributeType' => 'S'
        ],

    ],
    'ProvisionedThroughput' => [
        'ReadCapacityUnits' => 10,
        'WriteCapacityUnits' => 10
    ]
];

try {
    $result = $dynamodb->createTable($params);
    echo 'Created table.  Status: ' . 
        $result['TableDescription']['TableStatus'] ."\n";

} catch (DynamoDbException $e) {
    echo "Unable to create table:\n";
    echo $e->getMessage() . "\n";
}