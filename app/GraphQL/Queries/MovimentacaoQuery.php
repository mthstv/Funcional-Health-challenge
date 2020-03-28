<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\AccountLog;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Facades\GraphQL;

class MovimentacaoQuery extends Query
{
    protected $attributes = [
        'name' => 'Movimentacao',
        'description' => 'Exibe o histórico de movimentação/criação de uma ou de todas as contas'
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('movimentacao'));
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
            return AccountLog::where('conta', $args['conta'])->get();
        }

        return AccountLog::all();
    }
}
