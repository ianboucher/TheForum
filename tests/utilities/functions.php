<?php

function create($class, $attributes = [], $nItems = null)
{
    return factory($class, $nItems)->create($attributes);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
}
