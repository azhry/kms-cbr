<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Solusi_m extends Eloquent
{
    protected $table        = 'solusi';
    protected $primaryKey   = 'id_solusi';

    public function masalah()
    {
        require_once __DIR__ . '/Masalah_m.php';
        return $this->hasOne('Masalah_m', 'id_masalah', 'id_masalah');
    }

}
