<?php

namespace App\AbstractClass;

abstract class FactureStatusValues
{
    static array $status = array(
        0 => '<span class="badge badge-info">Nouvelle</span>',
        1 => '<span class="badge badge-warning">Vérifié par le finance</span>',
        2 => '<span class="badge badge-primary">Vérifié par Achat</span>',
        3 => '<span class="badge badge-secondary">Validé par le service concerné</span>',
        4 => '<span class="badge badge-success">à Payer</span>',
        5 => '<span class="badge badge-danger">Refusé</span>',
    );
    static array $statusLabel = array(
        0 => 'Nouvelle',
        1 => 'Vérifié par le finance',
        2 => 'Vérifié par Achat',
        3 => 'Validé par le service concerné',
        4 => 'à Payer',
        5 => 'Refusé',
    );
}