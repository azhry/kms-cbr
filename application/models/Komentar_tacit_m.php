<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Komentar_tacit_m extends Eloquent
{
    protected $table        = 'komentar_tacit';
    protected $primaryKey   = 'id_komentar';

    public function pengguna()
    {
        require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }

    public function pengetahuan_tacit()
    {
        require_once __DIR__ . '/Pengetahuan_tacit_m.php';
        return $this->hasOne('Pengetahuan_tacit_m', 'id_tacit', 'id_tacit');
    }

}
