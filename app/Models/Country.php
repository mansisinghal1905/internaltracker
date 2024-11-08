<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Country extends Model
{
    use HasFactory;
 public $table = 'countries';
    public function getNameAttribute($details)
    {
        $res = '';
        if (!empty($details)) {
            $res = $details;
        }
        return $res;
    }


}
