<?php

namespace AccelerateEveryone;

class Users extends Member {

    public function __construct() {

    }

    protected function createUser($params) {
        $errors = ['error'];

        if (empty($params)) {
            $errors['errors'][] = 'Unable to create new User. Empty param array.';
            $this->logger('Unable to create new User. Empty param array.');
        }

        $requiredParams = ['user_id','nickname'];
        $errors['errors'][] = validateForm($requiredParams, $params);

        if ($errors) return $errors;

        $userId = $params['user_id'];
        $nickname = $params['nickname'];

        $json = json_encode([
            'user_id' => $userId,
            'nickname' => $nickname,
            'active' => 'Y',
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => date('Y-m-d H:i:s'),
            'removed_datetime' => ''
        ]);
    
        $params = [
            'TableName' => 'ae_user',
            'Item' => $marshaler->marshalJson($json)
        ];
    
        try {
            $result = $dynamodb->putItem($params);
            $this->logger('Added User: ' . $user['nickname']);
        } catch (DynamoDbException $e) {
            $this->logger('Unable to add User: ' . $e->getMessage());
            $errors['error'][] = $e->getMessage() . "\n";
        }

        if ($errors) return $errors;

        return true;
    }

    protected function updateUserById($params) {
        $errors = ['error'];
        $results = array();

        if (!isset($params['user_id']) || empty($params['user_id'])) {
            $errors['error'][] = 'Missing User ID';
        }

        if ($errors) return $errors;

        // Check to ensure record exists and get current record
        $currentDataResults = getUserById($id);
        if (isset($currentDataResults['error'])) return $currentDataResults['error'];

        $currentData = $currentDataResults['Item'];
        $currentUserId = $currentData['user_id'];
        $currentNickname = $currentData['nickname'];

        // Pull out the keys we want to update
        $userId = $params['user_id'];
        $newUserId = isset($params['user_id']) && !empty($params['user_id']) 
                            ? $params['user_id'] 
                            : $currentUserId;

        $newNickname = isset($params['nickname']) && !empty($params['nickname']) 
                            ? $params['nickname'] 
                            : $currentNickname;

        $updateData = [
            ':user_id' => $newUserId, 
            ':nickname' => $newNickname,
            ':updateDateTime' => date('Y-m-d H:i:s')
        ];
           
        $key = [
            'id' => $userId
        ];

        $params = [
            'TableName' => 'ae_user',
            'Key' => getMarshalJson($key),
            'UpdateExpression' => 
                'set user_id = :user_id, nickname=:nickname, updateDateTime=:updateDateTime',
            'ExpressionAttributeValues'=> getMarshalJson($updateData),
            'ReturnValues' => 'UPDATED_NEW'
        ];

        try {
            $results = $dynamodb->updateItem($params);
            $logger->info('Updated User: ' . $userId);        
        } catch (DynamoDbException $e) {
            $logger->info('Unable to update item: ' . $e->getMessage());
            $errors['error'][] = 'Unable to update item: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }

    protected function deleteUser($id) {
        $errors = ['error'];
        $results = array();

        if (!isset($params['user_id']) || empty($params['user_id'])) {
            $errors['error'][] = 'Missing User ID';
        }

        if ($errors) return $errors;

        $key = [
            'id' => $id
        ];

        $params = [
            'TableName' => 'ae_user',
            'Key' => getMarshalJson($key),
            'ExpressionAttributeValues'=> getMarshalJson($updateData)
        ];

        try {
            $results = $dynamodb->deleteItem($params);
            $logger->info('Deleted User: ' . $userId);        
        } catch (DynamoDbException $e) {
            $logger->info('Unable to delete item: ' . $e->getMessage());
            $errors['error'][] = 'Unable to delete item: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }

    public function getuserById($userId) {
        $errors = ['error'];
        $results = array();

        if (!$userId) {
            $errors['error'][] = 'Missing User ID';
        }

        if ($errors) return $errors;

        $data = [
            'id' => $userId
        ];

        $params = [
            'TableName' => 'ae_user',
            'Key' => getMarshalJson($data)
        ];
        
        try {
            $results = $dynamodb->getItem($params);
        } catch (DynamoDbException $e) {
            $logger->info('Unable to get User by ID: ' . $e->getMessage());
            $errors['error'][] = 'Unable to get User by ID: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }
}