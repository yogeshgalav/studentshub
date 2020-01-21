<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    //
    public function add($request)
    {
        $guest=$this->where('ip',$request->ip())->first();
        if(!$guest){
            $this->agent=$request->header('User-agent');
            $this->ip=$request->ip();
            $this->save();
        }
    }

    public function subscribe(){
        $this->is_subscribed=true;
        $this->save();
    }

    public function scehduleSubscribeNotification()
    {
        $date = \Carbon\Carbon::now('UTC');
        $job = new \App\Queue();
        $job->run_at = $date;
        $job->job_type = 'App\Jobs\SubscriptionNotification';
        // $job->commitment_id = $this->id;
        // $job->conversation_instance_id = $this->conversation_instance_id;
        // $job->user_id = $this->user_id;
        $job->job_body = json_encode([
            'id' => $this->id,
        ]);
        $job->save();
    }
}
