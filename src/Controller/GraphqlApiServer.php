<?php
namespace App\Controller;

use App\Type\MainType;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GraphqlApiServer
 *
 * @package App\Controller
 */
class GraphqlApiServer extends AbstractController
{
    public function __invoke(Request $request, MainType $queryType)
    {
        $schema = new Schema([
            'query' => $queryType
        ]);

        $rawInput = $request->getContent();
        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = $input['variables'] ?? null;

        try {
            $rootValue = ['prefix' => 'You said: '];
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

        return $this->json($output);
    }
}
