<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\Conta;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class ContaType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Conta',
        'description' => 'Conta bancária',
        'model'         => Conta::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O id da conta'
            ],
            'conta' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O número da conta'
            ],
            'saldo' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O saldo atual da conta'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Data de criação da conta'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Data de atualização da conta'
            ]
        ];
    }
}
