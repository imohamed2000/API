<?php

namespace App\Beak;

class UserFilters extends QueryFilter {


    public function first_name($first_name)
    {
        return $this->builder->where('first_name','LIKE','%'.$first_name.'%');
    }

    public function last_name($last_name)
    {
        return $this->builder->where('last_name','LIKE','%'.$last_name.'%');
    }

    public function email($email)
    {
        return $this->builder->where('email','LIKE','%'.$email.'%');
    }


}