<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Masalah_m extends Eloquent
{
    protected $table        = 'masalah';
    protected $primaryKey   = 'id_masalah';

    public function bagian()
    {
        require_once __DIR__ . '/Bagian_m.php';
        return $this->hasOne('Bagian_m', 'id_bagian', 'id_bagian');
    }

    public function gejala()
    {
    	require_once __DIR__ . '/Gejala_masalah_m.php';
        return $this->hasMany('Gejala_masalah_m', 'id_masalah', 'id_masalah');
    }

    public function solusi()
    {
        require_once __DIR__ . '/Solusi_m.php';
        return $this->hasMany('Solusi_m', 'id_masalah', 'id_masalah');
    }
}
