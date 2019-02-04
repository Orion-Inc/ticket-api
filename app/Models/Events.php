<?php
    namespace Ticket\Models;

    use Illuminate\Database\Eloquent\Model;

    class Events extends Model
    {
        protected $fillable = [
            'title',
            'event_code',
            'category',
            'start_date',
            'end_date',
            'description',
            'website',
            'hashtags',
            'image',
            'mime_type',
            'venue',
            'address',
            'location',
            'city',
            'country',
            'is_private',
            'is_protected',
            'passcode',
            'organizer',
        ];
    }
    