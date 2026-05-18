<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';

    protected $allowedFields = [
        'title',
        'description',
        'date',
        'location',
        'category_id',
        'image',
        'quota'
    ];
}