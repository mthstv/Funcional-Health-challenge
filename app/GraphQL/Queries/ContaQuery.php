<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\Conta;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class ContaQuery extends Query
{
    protected $attributes = [
        'name' => 'Conta',
        'description' => 'Conta query'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('conta'));
    }

    public function args(): array
    {
        return [
            'conta' => [
                'name' => 'conta',
                'type' => Type::int()
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (isset($args['conta'])) {
            return Conta::where('conta', $args['conta'])->get();
        }

        return Conta::all();
    }
}
