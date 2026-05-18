<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';

    protected $allowedFields = [

        'user_id',
        'event_id',
        'comment'

    ];
}