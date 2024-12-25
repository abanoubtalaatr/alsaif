<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $guarded = [];

    public function paragraphs()
    {
        return $this->hasMany(Paragraph::class);
    }
}
