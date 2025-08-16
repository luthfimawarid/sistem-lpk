<?php

namespace App\Events;

use App\Models\JobApplication;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class JobApplied implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application->load('job', 'user');
    }

    public function broadcastOn()
    {
        return new Channel('admin-notifications');
    }

    public function broadcastAs()
    {
        return 'job.applied';
    }
}
