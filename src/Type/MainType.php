<?php
namespace App\Type;

use App\Manager\ProductManager;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class MainType extends ObjectType
{
    /**
     * @var ProductManager
     */
    private $productManager;

    public function __construct(ProductManager $productManager)
    {
        $this->productManager = $productManager;

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
                'products' => [
                    'type' => Type::listOf($this->getProductType()),
                    'resolve' => [$this->productManager, 'getProducts'],
                ],
            ],
        ];
    }

    public function getProductType(): ObjectType
    {
        return new ObjectType([
            'name' => 'Product',
            'fields' => [
                'id' => Type::int(),
                'name' => Type::string()
            ],
            'resolveField' => static function ($value, $args, $context, ResolveInfo $info) {
                $getterName = 'get' . ucfirst($info->fieldName);

                if (!method_exists($value, $getterName)) {
                    throw new \Exception('Ce getter n\'existe pas !');
                }

                return $value->$getterName();
            }
        ]);
    }
}
