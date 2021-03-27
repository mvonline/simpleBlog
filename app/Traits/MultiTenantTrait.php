<?php

namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;

trait MultiTenantTrait {
    public static function bootMultiTenantTrait(){
        if(auth()->check()){
            static::creating(function ($model){
                $model->created_by = auth()->id();
            });
            static::addGlobalScope('created_by',function (Builder $builder){
                if(auth()->check()){
                    if(!(auth()->user()->hasAnyRole(['manager','admin'])) ) {
                        return $builder->where('created_by', auth()->id());
                    }
                }
            });
        }
    }
}
