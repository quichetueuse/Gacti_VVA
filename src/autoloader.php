<?php
///**
// * Simple autoloader
// *
// * @param $class_name - String name for the class that is trying to be loaded.
// */
//function my_custom_autoloader( $class_name ){
//    $file = __DIR__.'/includes/'.$class_name.'.php';
//
//    if ( file_exists($file) ) {
//        require_once $file;
//    }
//}
//
//// add a new autoloader by passing a callable into spl_autoload_register()
//spl_autoload_register( 'my_custom_autoloader' );
//
////$my_example = new User(); // this works!
spl_autoload_register('AutoLoader');

function AutoLoader($className)
{
    // What it does?
    // imports files based on the namespace as folder and class as filename.

    $file = str_replace('\\',DIRECTORY_SEPARATOR, $className);
    require_once $file . '.php';


//    $file = str_replace('\\',DIRECTORY_SEPARATOR,$className);
//    echo $file;
//    require_once 'classes' . DIRECTORY_SEPARATOR . $file . '.php';
//    //Make your own path, Might need to use Magics like ___DIR___
}
