<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model {
    protected $fillable = ['email'];
}
