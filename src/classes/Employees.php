<?php

namespace AccelerateEveryone;

class Employees extends Member {

    public function __construct() {

    }

    protected function createEmployee($params) {
        return true;
    }

    protected function updateEmployeeById($id) {
        return true;
    }

    protected function deleteEmployee($id) {
        return true;
    }

    public function getEmployeesByOrganizationId($organizationId) {
        $results = array();


        return $results;
    }

    public function getEmployeeById($EmployeeId) {
        $results = array();


        return $results;
    }
}