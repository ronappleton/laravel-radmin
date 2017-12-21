<?php

if(!function_exists('radmin'))
{
    function radmin($name)
    {
        return config("radmin.{$name}");

        function set(array $settings)
        {

        }
    }
}

