<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
   protected $fillable = [
        'purpose', 'amount', 'type', 'user_id', 'status','approved_by'
     ];
}
