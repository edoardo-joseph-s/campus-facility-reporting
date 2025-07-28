<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_name',
        'event_description',
        'notify_reporter',
        'notify_admin',
        'notify_assignee',
        'is_active',
    ];

    protected $casts = [
        'notify_reporter' => 'boolean',
        'notify_admin' => 'boolean',
        'notify_assignee' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function messageTemplates()
    {
        return $this->hasMany(MessageTemplate::class);
    }
}
