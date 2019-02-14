<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Notifikasi_m extends Eloquent
{
    protected $table        = 'notifikasi';
    protected $primaryKey   = 'id_notifikasi';

    public function pengguna()
    {
    	require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }
}
