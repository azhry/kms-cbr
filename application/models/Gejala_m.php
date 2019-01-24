<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Gejala_m extends Eloquent
{
    protected $table        = 'gejala';
    protected $primaryKey   = 'id_gejala';

}
