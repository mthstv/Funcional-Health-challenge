<?php

declare(strict_types=1);

namespace App\GraphQL\Types;

use App\Models\AccountLog;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL\Type\Definition\Type;

class MovimentacaoType extends GraphQLType
{
    protected $attributes = [
        'name' => 'Movimentacao',
        'description' => 'Histórico de Movimentações',
        'model'         => AccountLog::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O id da movimentação'
            ],
            'id_conta' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O id da conta'
            ],
            'conta' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'O número da conta'
            ],
            'type' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'O tipo da movimentação'
            ],
            'message' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'A mensagem relacionada a movimentação'
            ],
            'created_at' => [
                'type' => Type::string(),
                'description' => 'Data de criação da movimentação'
            ],
            'updated_at' => [
                'type' => Type::string(),
                'description' => 'Data de atualização da movimentação'
            ]
        ];
    }
}
