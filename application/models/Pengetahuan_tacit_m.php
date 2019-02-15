<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Pengetahuan_tacit_m extends Eloquent
{
    protected $table        = 'pengetahuan_tacit';
    protected $primaryKey   = 'id_tacit';

    public function pengguna()
    {
        require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }

    public function kategori()
    {
        require_once __DIR__ . '/Kategori_m.php';
        return $this->hasOne('Kategori_m', 'id_kategori', 'id_kategori');
    }

    public function komentar()
    {
        require_once __DIR__ . '/Komentar_tacit_m.php';
        return $this->hasMany('Komentar_tacit_m', 'id_tacit', 'id_tacit')
                ->orderBy('created_at', 'DESC');   
    }

    public function like()
    {
        require_once __DIR__ . '/Like_tacit_m.php';
        return $this->hasMany('Like_tacit_m', 'id_tacit', 'id_tacit');
    }

    public function tag()
    {
        require_once __DIR__ . '/Tag_tacit_m.php';
        return $this->hasMany('Tag_tacit_m', 'id_tacit', 'id_tacit');
    }
}
