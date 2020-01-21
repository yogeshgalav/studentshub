<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    protected  $guarded = ['id', 'created_at', 'updated_at'];
    public function getLatestBatchByStudent(User $user)
    {

    }
    public function getStudentsByBatch(Batch $batch)
    {
        
    }
}
