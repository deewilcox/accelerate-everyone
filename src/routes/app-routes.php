<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    $this->logger->info("Accelerate Everyone '/' default route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

// @TODO Implement AWS Cognito
$app->get('/auth', function (Request $request, Response $response, array $args) {


});

// Routes for Organizations
$app->get('/organization/[{$organizationId}]', function (Request $request, Response $response, array $args) {
    $this->logger->info("Getting organization {$organizationId}");

    $organization = new Organizations();
    $results = $organization->getOrganizationById($organizationId);

    // @TODO: Implement middleware for auth
    $response = $this->renderer->render($response, 'organization.phtml', [
        "data" => $results[0],
        "router" => $this->router
    ]);

    return $response;
});

// Routes for Bosses
$app->get('/boss/[{$bossId}]', function (Request $request, Response $response, array $args) {
    $this->logger->info("Getting boss {$bossId}");

    $boss = new Bosses();
    $results = $boss->getBossById($bossId);

    // @TODO: Implement middleware for auth
    $response = $this->renderer->render($response, 'boss.phtml', [
        "data" => $results[0],
        "router" => $this->router
    ]);

    return $response;
});

// Routes for Peers
$app->get('/peer/[{$peerId}]', function (Request $request, Response $response, array $args) {
    $this->logger->info("Getting peer {$peerId}");

    $peer = new Peers();
    $results = $peer->getPeerById($peerId);

    // @TODO: Implement middleware for auth
    $response = $this->renderer->render($response, 'peer.phtml', [
        "data" => $results[0],
        "router" => $this->router
    ]);

    return $response;
});

// Routes for Employees
$app->get('/employee/[{$employeeId}]', function (Request $request, Response $response, array $args) {
    $this->logger->info("Getting employee {$employeeId}");

    $employee = new Employees();
    $results = $employee->getEmployeeById($employeeId);

    // @TODO: Implement middleware for auth
    $response = $this->renderer->render($response, 'employee.phtml', [
        "data" => $results[0],
        "router" => $this->router
    ]);

    return $response;
});

// Routes for Customers
$app->get('/customer/[{$customerId}]', function (Request $request, Response $response, array $args) {
    $this->logger->info("Getting customer {$customerId}");

    $customer = new Customers();
    $results = $customer->getCustomerById($customerId);

    // @TODO: Implement middleware for auth
    $response = $this->renderer->render($response, 'customer.phtml', [
        "data" => $results[0],
        "router" => $this->router
    ]);

    return $response;
});