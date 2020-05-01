<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['content'];

    public function blog() {
        return $this->belongsTo('App\Blog');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }
}
