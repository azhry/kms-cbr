<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pengguna_m extends Eloquent
{
    protected $table        = 'pengguna';
    protected $primaryKey   = 'id_pengguna';

    public function role()
    {
        require_once __DIR__ . '/Role_m.php';
        return $this->hasOne('Role_m', 'id_role', 'id_role');
    }

    public function tacit()
    {
    	require_once __DIR__ . '/Pengetahuan_tacit_m.php';
        return $this->hasMany('Pengetahuan_tacit_m', 'id_pengguna', 'id_pengguna');
    }

    public function eksplisit()
    {
    	require_once __DIR__ . '/Pengetahuan_eksplisit_m.php';
        return $this->hasMany('Pengetahuan_eksplisit_m', 'id_pengguna', 'id_pengguna');
    }

    public function tacit_tervalidasi()
    {
    	require_once __DIR__ . '/Pengetahuan_tacit_m.php';
        return $this->hasMany('Pengetahuan_tacit_m', 'id_pengguna', 'id_pengguna')
        		->where('status', 'Valid');
    }

    public function eksplisit_tervalidasi()
    {
    	require_once __DIR__ . '/Pengetahuan_eksplisit_m.php';
        return $this->hasMany('Pengetahuan_eksplisit_m', 'id_pengguna', 'id_pengguna')
        		->where('status', 'Valid');
    }

}
