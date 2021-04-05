<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_string', 'title', 'section_id', 'url', 'published_at'
    ];

    protected $dates = ['created_at', 'updated_at', 'published_at'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
