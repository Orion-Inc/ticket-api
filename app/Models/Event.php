<?php
    namespace oTikets\Models;

    use Illuminate\Database\Eloquent\Model;
    use oTikets\Helpers\Helpers;

    class Event extends Model
    {
        protected $fillable = [
            'event_code',
            'url_key',
            'title',
            'category',
            'start_date_time',
            'end_date_time',
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

        public static function generate_code()
        {
            $code = Helpers::generate_string(7);
            $date = date('Ymd');

            $event_code = "evn-{$code}-{$date}";

            return $event_code;
        }

        public static function generate_url_key()
        {
            $url_key = Helpers::generate_string(20);

            return $url_key;
        }
    }
    