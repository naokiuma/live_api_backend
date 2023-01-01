<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment_image extends Model
{
    use HasFactory;
    protected $fillable = ['comment_id','image_file_name'];//保存できるカラム

}
