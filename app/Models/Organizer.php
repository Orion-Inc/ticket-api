<?php
    namespace oTikets\Models;

    use Illuminate\Database\Eloquent\Model;

    class Organizer extends Model
    {
        protected $fillable = [
            'name',
            'email',
            'phone',
            'address',
            'city',
            'country',
            'location',
            'website',
            'description',
            'image',
            'mime_type',
        ];
    }
    