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

        $newAccountFields = $this->graphql->mutate($query)->getData();
        $this->graphql->assertGraphQlFields($newAccountFields, $query);

        $novaConta = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertNotNull($novaConta);
        $this->assertEquals($novaConta->conta, $this->accountNumber);
        $this->assertEquals($novaConta->saldo, $newAccountFields['saldo']);
        $this->assertEquals($newAccountFields['movimentacoes'][0]['message'], $novaConta->movimentacoes->first()->message);
        dump($newAccountFields['movimentacoes'][0]['message']);

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

        $depositedAccountfields = $this->graphql->mutate($query)->getData();
        $this->graphql->assertGraphQlFields($depositedAccountfields, $query);

        $contaDepositada = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertEquals($contaDepositada->saldo, $depositedAccountfields['saldo']);
        $this->assertEquals($depositedAccountfields['movimentacoes'][1]['message'], $contaDepositada->movimentacoes->last()->message);
        dump($depositedAccountfields['movimentacoes'][1]['message']);

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

        $withdrawAccountfields = $this->graphql->mutate($query)->getData();
        $this->graphql->assertGraphQlFields($withdrawAccountfields, $query);

        $contaSacada = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertNotNull($contaSacada);
        $this->assertEquals($contaSacada->conta, $this->accountNumber);
        $this->assertEquals($contaSacada->saldo, $withdrawAccountfields['saldo']);
        $this->assertEquals($withdrawAccountfields['movimentacoes'][2]['message'], $contaSacada->movimentacoes->last()->message);
        dump($withdrawAccountfields['movimentacoes'][2]['message']);

        /* Checking current balance of the account */
        $params = [
            'conta' => $this->accountNumber
        ];

        $query = new Query('saldo', $params, []);

        $saldo = $this->graphql->query($query)->getData();

        $saldoConta = Conta::query()->where([
            'conta' => $params['conta'],
        ])->first();

        $this->assertNotNull($saldoConta);
        $this->assertEquals($saldoConta->conta, $this->accountNumber);
        $this->assertEquals($saldoConta->saldo, $saldo);
        dump("Saldo atual: $saldoConta->saldo");
    }
}
