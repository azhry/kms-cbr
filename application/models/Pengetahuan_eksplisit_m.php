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

    public function komentar()
    {
        require_once __DIR__ . '/Komentar_eksplisit_m.php';
        return $this->hasMany('Komentar_eksplisit_m', 'id_eksplisit', 'id_eksplisit')
                ->orderBy('created_at', 'DESC');   
    }

    public function like()
    {
        require_once __DIR__ . '/Like_eksplisit_m.php';
        return $this->hasMany('Like_eksplisit_m', 'id_eksplisit', 'id_eksplisit');
    }

}
