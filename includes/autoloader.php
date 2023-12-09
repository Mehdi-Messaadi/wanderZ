<?php

spl_autoload_register('myAutoLoader');


function myAutoLoader($className)
{
    $classPath = "classes/";
    $extension = ".php";

    $classFilePath = $classPath . $className . $extension;

    if (file_exists($classFilePath)) {
        include_once $classFilePath;
    }
}
