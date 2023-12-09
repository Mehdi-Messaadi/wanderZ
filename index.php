<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Credentials: true");

($_SERVER['REQUEST_METHOD'] === 'OPTIONS') ? exit(http_response_code(200)) : null;

require 'vendor/autoload.php';
require 'types.php';

include 'includes/autoloader.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

try {
    $types = getGraphQLTypes();
    $schema = new Schema([
        'query' => $types['queryType'],
        'mutation' => $types['mutationType']
    ]);

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];
    $variableValues = isset($input['variables']) ? $input['variables'] : null;

    $rootValue = [];
    $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
    $output = $result->toArray();
} catch (\Exception $e) {
    $output = [
        'errors' => [
            [
                'message' => $e->getMessage()
            ]
        ]
    ];
}

header('Content-Type: application/json');
echo json_encode($output);
