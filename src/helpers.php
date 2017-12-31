<?php

if(!function_exists('radmin'))
{
    function radmin($name = null, $default = null)
    {
        if(empty($name) && empty($default))
        {
            return false;
        }

        return config("radmin.{$name}") ?: $default;
    }
}

