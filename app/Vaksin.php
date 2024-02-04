<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaksin extends Model
{
    protected $primaryKey = 'id';

    protected $table      = 'vaksins';

    public $timestamps    = false;

    public $incrementing  = true;

    protected $guarded = ['id'];

    //protected $fillable   = ['id', 'vaksin', 'status_hapus'];
}
