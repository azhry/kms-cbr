<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Tag_eksplisit_m extends Eloquent
{
    protected $table        = 'tag_eksplisit';
    protected $primaryKey   = 'id_tag';

    public function eksplisit()
    {
    	require_once __DIR__ . '/Pengetahuan_eksplisit_m.php';
        return $this->belongsTo('Pengetahuan_eksplisit_m', 'id_eksplisit', 'id_eksplisit');
    }

    public function pengguna()
    {
    	require_once __DIR__ . '/Pengguna_m.php';
        return $this->hasOne('Pengguna_m', 'id_pengguna', 'id_pengguna');
    }
}
