<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	protected $guarded =[];

    protected $with =['creator' , 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount' , function($builder)
        {
             $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
         
         $thread->replies()->each->delete();

        });

        static::created(function ($thread){
    });
    }

        protected function recordActivity($event){

        Activity::create([
        
        'user_id' =>auth()->id(),
        'type' => $this->getActivityType($event),
        'subject_id' => $thread->id,
        'subject_type' => get_class($this)

        ]);

        }
    
     protected function getActivityType($event)
     {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
     }

    public function path()
    {
    	return "/threads/{$this->channel->slug}/{$this->id}";
    }
    public function replies(){

    	return $this->hasMany(Reply::class)->withCount('favorites');
    }

    public function creator(){

    	return $this->belongsTo(User::class, 'user_id');
    }


    public function channel()
    {

        return $this->belongsTo(Channel::class);
    }
    public function addReply($reply)
    {
    	$this->replies()->create($reply);
    }
    public function scopeFilter($query, ThreadFilters $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
       $this->subscriptions()->create([
        
        'user_id' =>$userId ?: auth()->id()

       ]);
    }
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()->where('user_id' , $userId ? : auth()->id())->delete();
    }
     public function subscriptions($userId = null)
     {
         
        $this->hasMany(ThreadSubscription::class);
     }

    }


