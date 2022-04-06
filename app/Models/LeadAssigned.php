<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadAssigned extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    use HasFactory;
    protected $table ='lead_assigned';
}
