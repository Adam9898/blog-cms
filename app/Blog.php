<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    /**
     * This method is used to tell Eloquent that the Blog model is in relation with a User
     */
    public function user() {
    }
}
