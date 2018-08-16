<?php

namespace AccelerateEveryone;

class Bosses extends Member {

    public function __construct() {

    }

    protected function createBoss($params) {
        return true;
    }

    protected function updateBossById($id) {
        return true;
    }

    protected function deleteBoss($id) {
        return true;
    }

    public function getBossByOrganizationIdId($organizationId) {
        $results = array();


        return $results;
    }

    public function getBossById($bossId) {
        $results = array();


        return $results;
    }
}