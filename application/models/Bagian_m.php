<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bagian_m extends Eloquent
{
    protected $table        = 'bagian';
    protected $primaryKey   = 'id_bagian';

}
