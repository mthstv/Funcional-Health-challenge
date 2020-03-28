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

class CriarContaMutation extends Mutation
{
    protected $attributes = [
        'name' => 'criarConta',
        'description' => 'Cria uma nova conta especificando o número ou gerando um número aleatório'
    ];

    public function type(): Type
    {
        return GraphQL::type('conta');
    }

    public function args(): array
    {
        return [
            'conta' => [
                'type' => Type::int(),
                'rules' => ['min:5', 'max:5', 'unique:contas']
            ]
        ];
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'conta.min' => 'A conta deve possuir 5 dígitos',
            'conta.max' => 'A conta deve possuir 5 dígitos',
            'conta.unique' => 'Essa conta já existe',
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        $conta = new Conta();
        $args['saldo'] = 0;
        if (!isset($args['conta'])) {
            $args['conta'] = rand(10000, 99999);
        }
        $conta->fill($args);
        $conta->save();

        return $conta;
    }
}
