<?php
namespace App\Type;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MainType extends ObjectType
{
    public function __construct()
    {
        parent::__construct($this->buildConfig());
    }

    /**
     * @return array
     */
    protected function buildConfig()
    {
        return [
            'name' => 'Query',
            'fields' => [
                'echo' => [
                    'type' => Type::string(),
                    'args' => [
                        'message' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => function ($root, $args) {
                        return $root['prefix'] . $args['message'];
                    }
                ],
            ],
        ];
    }
}
