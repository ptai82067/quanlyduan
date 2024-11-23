<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RecordUpdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $tableName;
    public $eventType;
    public $record;

    public function __construct($tableName, $eventType, $record)
    {
        $this->tableName = $tableName;
        $this->eventType = $eventType;
        $this->record = $record->toArray(); // Truyền trực tiếp dữ liệu
       
    }

    public function broadcastOn()
    {
        return new Channel('my-channel'); // Tên kênh
    }

    public function broadcastWith()
    {
        return [
            'tableName' => $this->tableName,
            'eventType' => $this->eventType,
            'record' => $this->record
        ];
    }
    public function broadcastAs()
    {
        return 'my-event'; // Tên sự kiện
    }
}

