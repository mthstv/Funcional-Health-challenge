<?php

namespace App\Events;

use App\Models\Conta;
use App\Models\AccountLog;
use Illuminate\Queue\SerializesModels;

class AccountEvent extends Event
{
    use SerializesModels;

    public $conta;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Conta $conta)
    {
        $this->conta = $conta;
    }

    /**
     * Get the channels the event should broadcast on.
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function contaCreated(Conta $conta)
    {
        $log = new AccountLog();
        $log->conta_id = $conta->id;
        $log->type = 'CRIACAO';
        $log->message = "Conta de número $conta->conta criada com sucesso";
        $log->save();
    }

    public function contaUpdated(Conta $conta)
    {
        $log = new AccountLog();
        $log->conta_id = $conta->id;

        if ($conta->getOriginal('saldo') > $conta->saldo) {
            $movimentacao = $conta->getOriginal('saldo') - $conta->saldo;
            $log->type = 'SAQUE';
            $log->message = "Saque no valor de $movimentacao na conta $conta->conta";
        } else {
            $movimentacao = $conta->saldo - $conta->getOriginal('saldo');
            $log->type = 'DEPOSITO';
            $log->message = "Depósito no valor de $movimentacao na conta $conta->conta";
        }
        
        $log->save();
    }
}
