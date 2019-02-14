<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Like_eksplisit_m extends Eloquent
{
    protected $table        = 'like_eksplisit';
    protected $primaryKey   = 'id_eksplisit';

    public function eksplisit()
    {
    	require_once __DIR__ . '/Pengetahuan_eksplisit_m.php';
        return $this->belongsTo('Pengetahuan_eksplisit_m', 'id_eksplisit', 'id_eksplisit');
    }
}
