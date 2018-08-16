<?php

namespace AccelerateEveryone;

class Peers extends Member {

    public function __construct() {

    }

    protected function createPeer($params) {
        return true;
    }

    protected function updatePeerById($id) {
        return true;
    }

    protected function deletePeer($id) {
        return true;
    }

    public function getPeerByOrganizationId($organizationId) {
        $results = array();


        return $results;
    }

    public function getPeerById($PeerId) {
        $results = array();


        return $results;
    }
}