<?php

if(!function_exists('radmin'))
{
    function radmin($name = null, $default)
    {
        if(is_array($name))
        {
            $this->set($name);
        }

        return config("radmin.{$name}") ?: $default;

        function set(array $settings)
        {
            foreach($settings as $setting => $value)
            {
                if(!str_contains($setting, 'radmin'))
                {
                    $key = "radmin.{$setting}";
                    $settings[$key] = $value;
                    unset($settings[$setting]);
                }
            }

            return config($settings);
        }
    }
}

