<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use Closure;
use App\Models\Conta;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateContaMutation extends Mutation
{
    protected $attributes = [
        'name' => 'CreateConta',
        'description' => 'Conta mutation'
    ];

    public function type(): Type
    {
        return GraphQL::type('conta');
    }

    public function args(): array
    {
        return [
            'conta' => [
                'type' => Type::nonNull(Type::int()),
                'rules' => ['min:5']
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $conta = new Conta();
        $args['saldo'] = 0;
        $conta->fill($args);
        $conta->save();

        return $conta;
    }
}
