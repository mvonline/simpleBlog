<?php

function create($class, $attributes = [], $times = null)
{
    return $class::factory($class, $times)->create($attributes);
}
function make($class, $attributes = [], $times = null)
{
    return $class::factory($class, $times)->make($attributes);
}
function raw($class, $attributes = [], $times = null)
{
    return $class::factory($class, $times)->raw($attributes);
}
