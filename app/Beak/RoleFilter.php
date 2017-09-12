<?php
namespace App\Beak;

class RoleFilter extends QueryFilter
{
    public function role($name)
    {
        return $this->builder->where('slug','LIKE','%'.$name.'%');
    }

}