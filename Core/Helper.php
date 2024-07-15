<?php

/*
* ------------------------------------------------------------------------
* Define all the constants
*/

define('__ROOT__', dirname(dirname(__FILE__)));

/**
 * ------------------------------------------------------------------------
 * Display errors
 */

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


/**
 * ------------------------------------------------------------------------
 * redirect Helper
 * Redirect the user to a given url
 */
if(! function_exists('redirect'))
{
    function redirect(string $url)
    {
        header('Location:'.$url);
    }
}

/**
 * ------------------------------------------------------------------------
 * dd Helper
 * Outputs the given variable(s) with formatting and location
 * @access    public
 * @param    mixed    - variables to be output
 */
if ( ! function_exists('dd'))
{
    function dd()
    {
        list($callee) = debug_backtrace();

        $args = func_get_args();

        $total_args = func_num_args();

        echo '<div><fieldset style="background: #fefefe !important; border:1px red solid; padding:15px">';
        echo '<legend style="background:blue; color:white; padding:5px;">'.$callee['file'].' @line: '.$callee['line'].'</legend><pre><code>';

        $i = 0;

        foreach ($args as $arg)
        {
            echo '<strong>Debug #' . ++$i . ' of ' . $total_args . '</strong>: ' . '<br>';

            var_dump($arg);
        }

        echo "</code></pre></fieldset><div><br>";
    }
} 

