<?php
    namespace oTikets\Models;

    use Illuminate\Database\Eloquent\Model;
    use oTikets\Helpers\Helpers;

    class EventTickets extends Model
    {
        protected $table = 'event_tickets';

        protected $fillable = [
            'name',
            'description',
            'stock_quantity',
            'available_quantity',
            'price',
            'currency',
            'group_key',
            'event_id',
        ];

        public static function generate_group_key()
        {
            $key = Helpers::generate_string(7);
            $date = date('Ymd');

            $group_key = "group-{$key}-{$date}";

            return $group_key;
        }

        public function event()
        {
            return $this->belongsTo('oTikets\Models\Event');
        }
    }
    