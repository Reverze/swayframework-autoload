<?php

namespace Sway\Component\Autoloader\Exception;

class AutoloaderException extends \Exception
{
    /**
     * Throws an exception when autoloader's path is not defined
     * @return \Sway\Component\Autoloader\Exception\AutoloaderException
     */
    public static function autoloaderPathNotDefined() : AutoloaderException
    {
        return (new AutoloaderException("Autoloader's path is not defined"));
    }
    
    /**
     * Throws an exception when namespace's prefix is not defined
     * @return \Sway\Component\Autoloader\Exception\AutoloaderException
     */
    public static function namespacePrefixNotDefined() : AutoloaderException
    {
        return (new AutoloaderException("Namespace's prefix is not defined"));
    }
}


?>
