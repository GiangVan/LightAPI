<?php

class Account{
    public static function getById(string $id) : array{
        $accounts = DB::query('SELECT * FROM account WHERE id = :id', [':id' => $id]);
        return empty($accounts) ? [] : $accounts[0];
    }
}