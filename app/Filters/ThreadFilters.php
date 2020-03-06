<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;


class ThreadFilters 
{

	protected $filters = ['by' , 'popular']; 

	protected function by($username)
	{
       $user = User::where('name', $username)->firstorFail();

       return $this->builder->where('user_id' , $user->id);


	}

	protected function popular()
	{
		$this->builder->getQuery()->orders =[];
		return $this->builder->orderBy('replies_count', 'desc');
	}

/*	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply($builder)

	{
       if($username = $this->request->by) return $builder;
        
        $user =User::where('name' , $username)->firstorFail();

        return $builder->where('user_id' , $user->id);



       } */
       protected function unanswered()
       {
       	return $this->builder->where('replies_count' ,0);
       }
	
}