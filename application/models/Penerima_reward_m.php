<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Penerima_reward_m extends Eloquent
{
    protected $table        = 'penerima_reward';
    protected $primaryKey   = 'id';

    public function pengguna()
    {
        require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }

    public function reward()
    {
        require_once __DIR__ . '/Reward_m.php';
        return $this->hasOne('Reward_m', 'id_reward', 'id_reward');
    }

}
