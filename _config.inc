<?php
// ##############################################################################
//
// Copyright (C) 2024 Eliot BARRABES. All rights reserved.
//
// This document and the information it contains are the exclusive property
// of Eliot BARRABES. They can only be disclosed to the person(s) who have
// a need to know for the purpose expressly agreed upon with Eliot BARRABES
// and shall not be disclosed to other persons nor reproduced without the
// prior express consent of Eliot BARRABES.
//
// All information contained in this document remains the sole and exclusive
// property of Eliot BARRABES.
//
// ##############################################################################

#################################################################################
# Functions
#################################################################################

#################################################################################
# String Management
#################################################################################
function startsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
}

function endsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}

#################################################################################
# Autoload include Management
#################################################################################
function autoload( $path )
{
    $items = glob( $path . DIRECTORY_SEPARATOR . "*" );

    foreach( $items as $item )
	{
        //$isPhp = pathinfo( $item )["extension"] === "php";
		$isPhp = endsWith($item, '.php');

        if ( is_file( $item ) && $isPhp )
		{
            require_once ($item);
        }
		elseif ( is_dir( $item ) )
		{
            autoload( $item );
        }
    }
}

###############################################################################
# Session Management
###############################################################################
session_start();

###############################################################################
# Debug purpose
###############################################################################
ini_set('display_errors', 'off');
ini_set('display_startup_errors', 'off');
error_reporting(E_ALL);
// echo dirname(__FILE__) . '/logs/php/error.log';
ini_set('log_errors', 'on');
ini_set('error_log', dirname(__FILE__) . '/logs/php-scripts.log');

###############################################################################
# User Defined Constants
#################################################################################
define('ROOT', __DIR__);

$root = $_SERVER['SCRIPT_FILENAME'];
define('SCRIPT_FILENAME', $root);
define('BASE_FOLDER', basename(pathinfo($root)['dirname']));
define('SCRIPT_BASE_FOLDER', pathinfo($root)['dirname']);
define('SITE_ROOT', realpath(dirname(__FILE__)));
// define('CONTEXT_PREFIX', $_SERVER['CONTEXT_PREFIX']);
define('CONTEXT_PREFIX', 'actionPortal.Final');
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/' . BASE_FOLDER);
// define('SITE_URL', (startsWith($_SERVER['SERVER_PROTOCOL'], 'HTTP/') ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] == '80' ? '' : ':' . _SERVER['SERVER_PORT']) . '/' . CONTEXT_PREFIX);
define('SITE_URL', (startsWith($_SERVER['SERVER_PROTOCOL'], 'HTTP/') ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . '/' . CONTEXT_PREFIX);

//echo '_SCRIPT_FILENAME : ' . SCRIPT_FILENAME . '<br>';
//echo '_BASE_FOLDER : ' . BASE_FOLDER . '<br>';
//echo '_SCRIPT_BASE_FOLDER : ' . BASE_FOLDER . '<br>';// define('SITE_URL', (startsWith($_SERVER['SERVER_PROTOCOL'], 'HTTP/') ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . ($_SERVER['SERVER_PORT'] == '80' ? '' : ':' . _SERVER['SERVER_PORT']) . '/' . CONTEXT_PREFIX);

//echo '_SITE_ROOT : ' . SITE_ROOT . '<br>';
// echo '_SITE_URL : ' . SITE_URL . '<br>';


define ('_PHP_VERSION', phpversion());

#################################################################################
# Database Informations
#################################################################################
# Database Host
define ('DB_HOST' , 'localhost');
# Database Name
define ('DB_NAME' , 'bd_actionportal');
# Database User
define ('DB_USER' , 'root');
# Database Password
define ('DB_PWD' , '');
#################################################################################
#################################################################################

#################################################################################
# Export Informations
#################################################################################
# Delete Temporary File
define ('_DELETE_TEMPORARY_FILE' , true);
#################################################################################
#################################################################################

#################################################################################
# Set include path
#################################################################################
// set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . DIRECTORY_SEPARATOR . '..');
// set_include_path(str_replace(';C:\php\pear', '', get_include_path() . PATH_SEPARATOR . __DIR__ . PATH_SEPARATOR . SCRIPT_BASE_FOLDER ));
set_include_path(str_replace(';C:\php\pear', '', get_include_path() . PATH_SEPARATOR . __DIR__ ));

#################################################################################
# Includes
#################################################################################
//require_once ("Services/logs.inc");

// ##############################################################################
//
// Copyright (C) 2024 Eliot BARRABES. All rights reserved.
//
// This document and the information it contains are the exclusive property
// of Eliot BARRABES. They can only be disclosed to the person(s) who have
// a need to know for the purpose expressly agreed upon with Eliot BARRABES
// and shall not be disclosed to other persons nor reproduced without the
// prior express consent of Eliot BARRABES.
//
// All information contained in this document remains the sole and exclusive
// property of Eliot BARRABES.
//
// ##############################################################################
?>