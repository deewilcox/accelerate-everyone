<?php

namespace AccelerateEveryone;

class Customers extends Member {

    public function __construct() {

    }

    protected function createCustomer($params) {
        return true;
    }

    protected function updateCustomerById($id) {
        return true;
    }

    protected function deleteCustomer($id) {
        return true;
    }

    public function getCustomerByOrganizationId($organizationId) {
        $results = array();


        return $results;
    }

    public function getCustomerById($CustomerId) {
        $results = array();


        return $results;
    }
}