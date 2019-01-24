<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Reward_m extends Eloquent
{
    protected $table        = 'reward';
    protected $primaryKey   = 'id_reward';

    public function pengguna()
    {
        require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }

}
