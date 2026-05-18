<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table = 'favorites';

    protected $allowedFields = [

        'user_id',
        'event_id'

    ];
}