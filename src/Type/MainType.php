<?php
namespace App\Type;

use App\Entity\Product;
use App\Manager\OrderManager;
use App\Manager\ProductManager;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class MainType
{
    /**
     * @var ProductManager
     */
    private $productManager;

    /** @var ObjectType */
    protected $productType;

    /** @var ObjectType */
    protected $orderType;
    /**
     * @var OrderManager
     */
    protected $orderManager;

    public function __construct(ProductManager $productManager, OrderManager $orderManager)
    {
        $this->productManager = $productManager;
        $this->orderManager = $orderManager;
    }

    public function getQuery(): ObjectType
    {
        return new ObjectType([
            'name' => 'Query',
            'fields' => [
                'orders' => [
                    'type' => Type::listOf($this->getOrderType()),
                    'resolve' => [$this->orderManager, 'getOrders']
                ],
                'products' => [
                    'type' => Type::listOf($this->getProductType()),
                    'resolve' => [$this->productManager, 'getProducts'],
                ],
                'product' => [
                    'type' => $this->getProductType(),
                    'args' => [
                        'id' => Type::int()
                    ],
                    'resolve' => function ($root, $args) {
                        return $this
                            ->productManager
                            ->getProduct($args['id']);
                    },
                ]
            ],
        ]);
    }

    public function getMutation(): ObjectType
    {
        return new ObjectType([
            'name' => 'Mutation',
            'fields' => [
                'createProduct' => [
                    'type' => $this->getProductType(),
                    'args' => [
                        'name' => Type::string(),
                        'description' => Type::string(),
                        'price' => Type::float(),
                    ],
                    'resolve' => function ($root, $args) {
                        $product = new Product();
                        $product
                            ->setName($args['name'])
                            ->setDescription($args['description'])
                            ->setPrice($args['price']);

                        return $this->productManager->create($product);
                    }
                ]
            ],

        ]);
    }

    public function getProductType(): ObjectType
    {
        if (!$this->productType) {
            $this->productType =  new ObjectType([
                'name' => 'Product',
                'fields' => [
                    'id' => Type::int(),
                    'name' => Type::string(),
                    'description' => Type::string(),
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

        return $this->productType;
    }

    public function getOrderType(): ObjectType
    {
        if (!$this->orderType) {
            $this->orderType =  new ObjectType([
                'name' => 'Order',
                'fields' => [
                    'id' => Type::int(),
                    'creationDate' => Type::string(),
                    'amount' => Type::float(),
                    'username' => Type::string(),
                    'products' => Type::listOf($this->getProductType()),
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

        return $this->orderType;
    }
}
