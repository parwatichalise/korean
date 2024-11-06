<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'heading',
        'sub_heading',
        'price',
        'photo',
        'time_duration',
        'active',
        'created_by',

    ];
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'quiz_tag', 'quiz_id', 'tag_id');
    }
    public function package()
{
    return $this->belongsTo(Package::class);
}
}
