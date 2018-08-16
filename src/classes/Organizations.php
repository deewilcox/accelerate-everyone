<?php

namespace AccelerateEveryone;

class Organizations extends Member {

    public function __construct() {

    }

    protected function createOrganization($params) {
        return true;
    }

    protected function updateOrganizationById($id) {
        return true;
    }

    protected function deleteOrganization($id) {
        return true;
    }

    public function getOrganizationByUserId($organizationId) {
        $results = array();


        return $results;
    }

    public function getOrganizationById($OrganizationId) {
        $results = array();


        return $results;
    }
}