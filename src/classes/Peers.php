<?php

namespace AccelerateEveryone;

class Peers extends Member {

    public function __construct() {

    }

    protected function createPeer($params) {
        $errors = ['error'];

        if (empty($params)) {
            $errors['errors'][] = 'Unable to create new Peer. Empty param array.';
            $this->logger('Unable to create new Peer. Empty param array.');
        }

        $requiredParams = ['organization_id','nickname'];
        $errors['errors'][] = validateForm($requiredParams, $params);

        if ($errors) return $errors;

        $organizationId = $params['organization_id'];
        $nickname = $params['nickname'];

        $json = json_encode([
            'organization_id' => $organizationId,
            'nickname' => $nickname,
            'active' => 'Y',
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => date('Y-m-d H:i:s'),
            'removed_datetime' => ''
        ]);
    
        $params = [
            'TableName' => 'ae_peer',
            'Item' => $marshaler->marshalJson($json)
        ];
    
        try {
            $result = $dynamodb->putItem($params);
            $this->logger('Added Peer: ' . $peer['nickname']);
        } catch (DynamoDbException $e) {
            $this->logger('Unable to add Peer: ' . $e->getMessage());
            $errors['error'][] = $e->getMessage() . "\n";
        }

        if ($errors) return $errors;

        return true;
    }

    protected function updatePeerById($params) {
        $errors = ['error'];
        $results = array();

        if (!isset($params['peer_id']) || empty($params['peer_id'])) {
            $errors['error'][] = 'Missing Peer ID';
        }

        if ($errors) return $errors;

        // Check to ensure record exists and get current record
        $currentDataResults = getPeerById($id);
        if (isset($currentDataResults['error'])) return $currentDataResults['error'];

        $currentData = $currentDataResults['Item'];
        $currentOrganizationId = $currentData['organization_id'];
        $currentNickname = $currentData['nickname'];

        // Pull out the keys we want to update
        $peerId = $params['peer_id'];
        $newOrganizationId = isset($params['organization_id']) && !empty($params['organization_id']) 
                            ? $params['organization_id'] 
                            : $currentOrganizationId;

        $newNickname = isset($params['nickname']) && !empty($params['nickname']) 
                            ? $params['nickname'] 
                            : $currentNickname;

        $updateData = [
            ':organization_id' => $newOrganizationId, 
            ':nickname' => $newNickname,
            ':updateDateTime' => date('Y-m-d H:i:s')
        ];
           
        $key = [
            'id' => $peerId
        ];

        $params = [
            'TableName' => 'ae_peer',
            'Key' => getMarshalJson($key),
            'UpdateExpression' => 
                'set organization_id = :organization_id, nickname=:nickname, updateDateTime=:updateDateTime',
            'ExpressionAttributeValues'=> getMarshalJson($updateData),
            'ReturnValues' => 'UPDATED_NEW'
        ];

        try {
            $results = $dynamodb->updateItem($params);
            $logger->info('Updated Peer: ' . $peerId);        
        } catch (DynamoDbException $e) {
            $logger->info('Unable to update item: ' . $e->getMessage());
            $errors['error'][] = 'Unable to update item: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }

    protected function deletePeer($id) {
        $errors = ['error'];
        $results = array();

        if (!isset($params['peer_id']) || empty($params['peer_id'])) {
            $errors['error'][] = 'Missing Peer ID';
        }

        if ($errors) return $errors;

        $key = [
            'id' => $id
        ];

        $params = [
            'TableName' => 'ae_peer',
            'Key' => getMarshalJson($key),
            'ExpressionAttributeValues'=> getMarshalJson($updateData)
        ];

        try {
            $results = $dynamodb->deleteItem($params);
            $logger->info('Deleted Peer: ' . $peerId);        
        } catch (DynamoDbException $e) {
            $logger->info('Unable to delete item: ' . $e->getMessage());
            $errors['error'][] = 'Unable to delete item: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }

    public function getPeerByOrganizationIdId($organizationId) {
        $errors = ['error'];
        $results = array();

        if (!$organizationId) {
            $errors['error'][] = 'Missing organization ID';
        }

        if ($errors) return $errors;

        $data = [
            'organization_id' => $organizationId
        ];

        $params = [
            'TableName' => 'ae_peer',
            'Key' => getMarshalJson($data)
        ];
        
        try {
            $results = $dynamodb->getItem($params);
        } catch (DynamoDbException $e) {
            $logger->info('Unable to get Peer by organization ID: ' . $e->getMessage());
            $errors['error'][] = 'Unable to get Peer by organization ID: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }

    public function getPeerById($PeerId) {
        $errors = ['error'];
        $results = array();

        if (!$peerId) {
            $errors['error'][] = 'Missing Peer ID';
        }

        if ($errors) return $errors;

        $data = [
            'id' => $peerId
        ];

        $params = [
            'TableName' => 'ae_peer',
            'Key' => getMarshalJson($data)
        ];
        
        try {
            $results = $dynamodb->getItem($params);
        } catch (DynamoDbException $e) {
            $logger->info('Unable to get Peer by ID: ' . $e->getMessage());
            $errors['error'][] = 'Unable to get Peer by ID: ' . $e->getMessage();
        }

        if ($errors) return $errors;

        return $results;
    }
}