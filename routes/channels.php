<?php

use App\Broadcasting\PoomsaeTabloChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('PoomsaeTablo', PoomsaeTabloChannel::class);
