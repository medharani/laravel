<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $guarded =[];

   protected $with = ['owner' ,'favorites'];
     protected $appends = ['favoritesCount' ,'isFavorited'];

     protected static function boot()
     {
      parent::boot();
      static::created(function ($reply){
      $reply->thread->increment('replies_count');

      });
      static::deleted(function ($reply){
     $reply->thread->decrement('replies_count');

      });
     }
	public function owner(){
   return $this->belongsTo(User::class, 'user_id');
}

   public function favorites()
   {

   	return $this->morphMany(Favorite::class, 'favorited');
   }
   public function favorite()
   {
      $attributes = ['user_id' => auth()->id()];


     if(! $this->favorites()->where($attributes)->exists())  {
         $this->favorites()->create($attributes);
     }
   }
    public function isFavorited()
    {
      return !! $this->favorites->where('user_id' , auth()->id())->count();
    }

    public function thread()
    {
      return $this->belongsTo(Thread::class);
    }

    public function path()
    {
      return $this->thread->path();
    }
}
