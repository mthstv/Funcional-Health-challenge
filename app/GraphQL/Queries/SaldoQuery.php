<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use Closure;
use App\Models\Conta;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Error\Error;

class SaldoQuery extends Query
{
    protected $attributes = [
        'name' => 'Saldo',
        'description' => 'Exibe o saldo de uma conta'
    ];

    public function type(): Type
    {
        return Type::int();
    }

    public function args(): array
    {
        return [
            'conta' => [
                'name' => 'conta',
                'type' => Type::nonNull(Type::int())
            ]
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (isset($args['conta'])) {
            $conta = Conta::where('conta', $args['conta'])->first();
            if ($conta) {
                return $conta->saldo;
            } else {
                return new Error('Conta não encontrada');
            }
        }
    }
}
