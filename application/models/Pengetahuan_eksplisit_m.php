<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pengetahuan_eksplisit_m extends Eloquent
{
    protected $table        = 'pengetahuan_eksplisit';
    protected $primaryKey   = 'id_eksplisit';

    public function kategori()
    {
        require_once __DIR__ . '/Kategori_m.php';
        return $this->hasOne('Kategori_m', 'id_kategori', 'id_kategori');
    }

    public function pengguna()
    {
        require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }

}
