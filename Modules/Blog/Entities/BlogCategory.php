<?php

namespace Modules\Blog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $appends = ['name','total_blog'];

    protected $hidden = ['front_translate', 'blogs'];


    public function translate(){
        return $this->belongsTo(BlogCategoryTranslation::class, 'id', 'blog_category_id')->where('lang_code', admin_lang());
    }

    public function front_translate(){
        return $this->belongsTo(BlogCategoryTranslation::class, 'id', 'blog_category_id')->where('lang_code', front_lang());
    }

    public function getNameAttribute()
    {
        return $this->front_translate->name;
    }

    public function blogs(){
        return $this->hasMany(Blog::class)->where('status', 1);
    }

    public function getTotalBlogAttribute()
    {
        return $this->blogs->count();
    }
}
