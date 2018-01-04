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

if (!function_exists('radminTextArea')) {
    function radminTextArea($name, $value = null, $placeholder = null, $title = null, $strap = null, $collapse = false, $remove = false)
    {
        if(!isset($model))
        {
            $model = null;
        }
        $editor =  '';
        $editor .= "<div class='box'>";
        $editor .= "<div class='box-header'>";
        $editor .= "<h3 class='box-title'>{$title} <small>{$strap}</small></h3>";
        $editor .= "<div class='pull-right box-tools'>";
        if($collapse)
        {
            $editor .= "<button class='btn btn-default btn-sm' data-widget='collapse' data-toggle='tooltip' title='Collapse'><i class='fa fa-minus'></i></button>";
        }
        if($remove)
        {
            $editor .= "<button class='btn btn-default btn-sm' data-widget='remove' data-toggle='tooltip' title='Remove'><i class='fa fa-times'></i></button>";
        }
        $editor .= "</div>";
        $editor .= "</div>";
        $editor .= "<div class='box-body pad'>";
        $editor .= "<textarea class='textarea' name='{$name}' placeholder='{$placeholder}' style='width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'>{$value}</textarea>";
        $editor .= "</div>";
        $editor .= "</div>";

        return $editor;
    }
}

