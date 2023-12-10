<?php

require 'vendor/autoload.php';

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;

function getGraphQLTypes()
{

    $featureType = new ObjectType([
        'name' => 'Feature',
        'fields' => [
            'bestFor' => [
                'type' => Type::string(),
                'description' => 'Weight of the product',
            ],
            'material' => [
                'type' => Type::string(),
                'description' => 'Material of the product',
            ],
            'madeIn' => [
                'type' => Type::string(),
                'description' => 'Material of the product',
            ],
        ],
    ]);


    $productType = new ObjectType([
        'name' => 'Product',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'description' => 'Unique identifier for the product',
            ],
            'sku' => [
                'type' => Type::string(),
                'description' => 'Stock Keeping Unit, unique to each product',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Name of the product',
            ],
            'uri' => [
                'type' => Type::string(),
                'description' => 'URI for the product',
            ],
            'category' => [
                'type' => Type::string(),
                'description' => 'Category of the product',
            ],
            'reviews' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'List of reviews for the product',
                'resolve' => function ($product) {
                    return json_decode($product['reviews']);
                },
            ],
            'sizes' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'List of sizes available for the product',
                'resolve' => function ($product) {
                    return json_decode($product['sizes']);
                },
            ],
            'colors' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'List of colors available for the product',
                'resolve' => function ($product) {
                    return json_decode($product['colors']);
                },
            ],
            'price' => [
                'type' => Type::float(),
                'description' => 'Price of the product',
            ],
            'score' => [
                'type' => Type::float(),
                'description' => 'Score or rating of the product',
            ],
            'gallery' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'List of images in the product gallery',
                'resolve' => function ($product) {
                    return json_decode($product['gallery']);
                },
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'Description of the product',
            ],
            'features' => [
                'type' => Type::listOf($featureType),
                'description' => 'List of features of the product',
                'resolve' => function ($product) {
                    // Assuming $product['features'] is a JSON-encoded string of features
                    $featuresArray = json_decode($product['features'], true);
                    if (!is_array($featuresArray)) {
                        return []; // Return an empty array if the features data is not valid
                    }
                    return array_map(function ($feature) {
                        // Map each feature to conform to the $featureType structure
                        return [
                            'bestFor' => $feature['bestFor'] ?? null, // Match the key as per your database
                            'material' => $feature['material'] ?? null, // Same as above
                            'madeIn' => $feature['madeIn'] ?? null, // Same as above
                        ];
                    }, $featuresArray);
                },
            ],
        ],
    ]);

    $userType = new ObjectType([
        'name' => 'User',
        'fields' => [
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Unique identifier for the user',
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'User email',
            ],
            'password' => [
                'type' => Type::string(),
                'description' => 'User Password',
            ],
            'first_name' => [
                'type' => Type::string(),
                'description' => 'First Name of the user',
            ],
            'last_name' => [
                'type' => Type::string(),
                'description' => 'Last Name of the User',
            ],
            'billing_address' => [
                'type' => Type::string(),
                'description' => 'Billing Address of the User',
            ],
            'shipping_address' => [
                'type' => Type::string(),
                'description' => 'Shipping Address of the User',
            ],
            'phone_number' => [
                'type' => Type::int(),
                'description' => 'Phone Number of the User',
            ],
            'date_created' => [
                'type' => Type::string(),
                'description' => 'The Date when the user was created',
            ],
            'last_updated' => [
                'type' => Type::string(),
                'description' => 'The Last Date the user details have been updated',
            ],
        ],
    ]);

    $reviewType = new ObjectType([
        'name' => 'Review',
        'fields' => [
            'id' => [
                'type' => Type::int(),
                'description' => 'Unique identifier for the review',
            ],
            'product_sku' => [
                'type' => Type::string(),
                'description' => 'Unique identifier for the product being reviewed',
            ],
            'user_id' => [
                'type' => Type::int(),
                'description' => 'Unique identifier for the author of the review',
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Full name of the review author',
            ],
            'rating' => [
                'type' => Type::int(),
                'description' => 'Rating of the product picked by the author',
            ],
            'review_title' => [
                'type' => Type::string(),
                'description' => 'Title of the review',
            ],
            'review_body' => [
                'type' => Type::string(),
                'description' => 'Body of the review',
            ],
            'date_created' => [
                'type' => Type::string(),
                'description' => 'Date when the review was created',
            ],
        ],
    ]);

    $subCategoryType = new ObjectType([
        'name' => 'SubCategory',
        'fields' => [
            'title' => [
                'type' => Type::string(),
                'description' => 'Title of the subcategory group',
            ],
            'subcategories' => [
                'type' => Type::listOf(Type::string()),
                'description' => 'List of subcategories',
            ],
        ],
    ]);

    $categoryType = new ObjectType([
        'name' => 'Category',
        'fields' => [
            'category_id' => [
                'type' => Type::int(),
                'description' => 'Unique identifier for the category',
            ],
            'category_title' => [
                'type' => Type::string(),
                'description' => 'Title of the category',
            ],
            'subcategories' => [
                'type' => Type::listOf($subCategoryType),
                'description' => 'List of subcategory groups for the category',
                'resolve' => function ($category) {
                    return json_decode($category['subcategories'], true);
                },
            ],
        ],
    ]);

    $queryType = new ObjectType([
        'name' => 'Query',
        'fields' => [
            'products' => [
                'type' => Type::listOf($productType),
                'resolve' => function () {
                    $viewProducts = new ViewProducts('localhost', 'root', 'mehdiPMA', 'wanderz');
                    return $viewProducts->getAllProducts();
                }
            ],
            'product' => [
                'type' => $productType,
                'args' => [
                    'id' => Type::nonNull(Type::int())
                ],
                'resolve' => function ($root, $args, $context) {
                    $viewProducts = new ViewProducts('localhost', 'root', 'mehdiPMA', 'wanderz');
                    return $viewProducts->getProductById($args['id']);
                }
            ],
            'user' => [
                'type' => $userType,
                'args' => [
                    'user_id' => Type::nonNull(Type::int())
                ],
                'resolve' => function ($root, $args, $context) {
                    $users = new Users('localhost', 'root', 'mehdiPMA', 'wanderz');
                    return $users->getUserByID($args['user_id']);
                }
            ],
            'categoryByTitle' => [
                'type' => $categoryType,
                'args' => [
                    'title' => Type::nonNull(Type::string()),
                ],
                'resolve' => function ($root, $args) {
                    $categories = new Categories('localhost', 'root', 'mehdiPMA', 'wanderz');
                    return $categories->getCategoryByTitle($args['title']);
                },
            ],
            'reviewById' => [
                'type' => $reviewType,
                'args' => [
                    'id' => Type::nonNull(Type::int()),
                ],
                'resolve' => function ($root, $args) {
                    $productReviews = new ProductReviews('localhost', 'root', 'mehdiPMA', 'wanderz');
                    return $productReviews->getReviewById($args['id']);
                },
            ],

            'reviewsByUserId' => [
                'type' => Type::listOf($reviewType),
                'args' => [
                    'user_id' => Type::nonNull(Type::int()),
                ],
                'resolve' => function ($root, $args) {
                    $productReviews = new ProductReviews('localhost', 'root', 'mehdiPMA', 'wanderz');
                    return $productReviews->getReviewsByUserId($args['user_id']);
                },
            ],
        ],
    ]);

    $mutationType = new ObjectType([
        'name' => 'Mutation',
        'fields' => [
            'addReview' => [
                'type' => $reviewType,
                'args' => [
                    'product_sku' => Type::nonNull(Type::string()),
                    'user_id' => Type::nonNull(Type::int()),
                    'name' => Type::nonNull(Type::string()),
                    'rating' => Type::nonNull(Type::int()),
                    'review_title' => Type::nonNull(Type::string()),
                    'review_body' => Type::nonNull(Type::string()),
                ],
                'resolve' => function ($root, $args) {
                    $productReviews = new ProductReviews('localhost', 'root', 'mehdiPMA', 'wanderz');
                    $newReviewId = $productReviews->addReview(
                        $args['product_sku'],
                        $args['user_id'],
                        $args['name'],
                        $args['rating'],
                        $args['review_title'],
                        $args['review_body']
                    );
                    return $productReviews->getReviewById($newReviewId); // Fetch and return the newly created review
                },
            ],
            'updateReview' => [
                'type' => $reviewType,
                'args' => [
                    'id' => Type::nonNull(Type::int()),
                    'review_body' => Type::string(),
                    // Add other fields that can be updated, if necessary
                ],
                'resolve' => function ($root, $args) {
                    $productReviews = new ProductReviews('localhost', 'root', 'mehdiPMA', 'wanderz');
                    $productReviews->updateReview($args['id'], $args['review_body']);
                    return $productReviews->getReviewById($args['id']);
                },
            ],
            'deleteReview' => [
                'type' => Type::boolean(), // Returns true if deletion is successful
                'args' => [
                    'id' => Type::nonNull(Type::int()),
                ],
                'resolve' => function ($root, $args) {
                    $productReviews = new ProductReviews('localhost', 'root', 'mehdiPMA', 'wanderz');
                    $affectedRows = $productReviews->deleteReview($args['id']);
                    return $affectedRows > 0;
                },
            ],
            'registerUser' => [
                'type' => $userType, // Assumes you have a GraphQL type for user
                'args' => [
                    'email' => Type::nonNull(Type::string()),
                    'password' => Type::nonNull(Type::string()),
                    'first_name' => Type::nonNull(Type::string()),
                    'last_name' => Type::nonNull(Type::string()),
                    'billing_address' => Type::nonNull(Type::string()),
                    'shipping_address' => Type::nonNull(Type::string()),
                    'phone_number' => Type::nonNull(Type::string()),
                ],
                'resolve' => function ($root, $args) {
                    $users = new Users('localhost', 'root', 'mehdiPMA', 'wanderz');
                    $users->registerUser(
                        $args['email'],
                        $args['password'],
                        $args['first_name'],
                        $args['last_name'],
                        $args['billing_address'],
                        $args['shipping_address'],
                        $args['phone_number']
                    );
                },
            ],

            'updateUser' => [
                'type' => $userType,
                'args' => [
                    'user_id' => Type::nonNull(Type::int()),
                    'email' => Type::string(),
                    'first_name' => Type::string(),
                    'last_name' => Type::string(),
                    'billing_address' => Type::string(),
                    'shipping_address' => Type::string(),
                    'phone_number' => Type::string(),
                ],
                'resolve' => function ($root, $args) {
                    $users = new Users('localhost', 'root', 'mehdiPMA', 'wanderz');
                    $users->updateUser(
                        $args['user_id'],
                        $args['email'],
                        $args['first_name'],
                        $args['last_name'],
                        $args['billing_address'],
                        $args['shipping_address'],
                        $args['phone_number']
                    );
                },
            ],
        ],
    ]);


    return [
        'productType' => $productType,
        'featureType' => $featureType,
        'categoryType' => $categoryType,
        'queryType' => $queryType,
        'reviewType' => $reviewType,
        'mutationType' => $mutationType,
    ];
}
