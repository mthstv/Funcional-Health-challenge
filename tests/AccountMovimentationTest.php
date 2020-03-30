<?php

use App\Models\Conta;
use GraphQLClient\Query;
use GraphQLClient\Field;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccountMovimentationTest extends TestCase
{
    /**
     * Testing value Withdraw.
     *
     * @return void
     */
    public function testAccountMovimentation()
    {
        /* Generating random account number */
        $this->accountNumber = rand(10000, 99999);

        /* Creating a account */
        $params = [
            'conta' => $this->accountNumber
        ];

        $query = new Query('criarConta', $params, [
            new Field('conta'),
            new Field('saldo'),
            new Field('movimentacoes', [
                new Field('message')
            ])
        ]);

        $fields = $this->graphql->mutate($query)->getData();
        $this->graphql->assertGraphQlFields($fields, $query);

        $conta = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertNotNull($conta);
        $this->assertEquals($conta->conta, $this->accountNumber);
        $this->assertEquals($conta->saldo, $fields['saldo']);
        $this->assertEquals($fields['movimentacoes'][0]['message'], $conta->movimentacoes->first()->message);
        dump($fields['movimentacoes'][0]['message']);

        /* Depositing 10 to the account */
        $params = [
            'conta' => $this->accountNumber,
            'valor' => 10
        ];

        $query = new Query('depositar', $params, [
            new Field('conta'),
            new Field('saldo'),
            new Field('movimentacoes', [
                new Field('message')
            ])
        ]);

        $fields = $this->graphql->mutate($query)->getData();
        $this->graphql->assertGraphQlFields($fields, $query);

        $conta = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertEquals($conta->saldo, $fields['saldo']);
        $this->assertEquals($fields['movimentacoes'][1]['message'], $conta->movimentacoes->last()->message);
        dump($fields['movimentacoes'][1]['message']);

        /* Withdrawing 5 from the account */
        $params = [
            'conta' => $this->accountNumber,
            'valor' => 5
        ];

        $query = new Query('sacar', $params, [
            new Field('conta'),
            new Field('saldo'),
            new Field('movimentacoes', [
                new Field('message')
            ])
        ]);

        $fields = $this->graphql->mutate($query)->getData();
        $this->graphql->assertGraphQlFields($fields, $query);

        $conta = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertNotNull($conta);
        $this->assertEquals($conta->conta, $this->accountNumber);
        $this->assertEquals($conta->saldo, $fields['saldo']);
        $this->assertEquals($fields['movimentacoes'][2]['message'], $conta->movimentacoes->last()->message);
        dump($fields['movimentacoes'][2]['message']);

        /* Checking current balance of the account */
        $params = [
            'conta' => $this->accountNumber
        ];

        $query = new Query('saldo', $params, []);

        $saldo = $this->graphql->query($query)->getData();

        $conta = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertNotNull($conta);
        $this->assertEquals($conta->conta, $this->accountNumber);
        $this->assertEquals($conta->saldo, $saldo);
        dump("Saldo atual: $conta->saldo");
    }
}
