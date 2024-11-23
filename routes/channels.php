<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('channel-name', function ($user) {
    return true; // Hoặc logic kiểm tra quyền
});
