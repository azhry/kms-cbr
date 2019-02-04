<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Reward_m extends Eloquent
{
    protected $table        = 'reward';
    protected $primaryKey   = 'id_reward';

    public function penerima()
    {
        require_once __DIR__ . '/Penerima_reward_m.php';
        return $this->hasMany('Penerima_reward_m', 'id_reward', 'id_reward');
    }

}
