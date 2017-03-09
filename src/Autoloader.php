<?php

namespace Sway\Component\Autoloader;

use Sway\Component\Dependency\DependencyInterface;

class Autoloader extends DependencyInterface
{
    /**
     * Directory's path
     * @var string
     */
    private $path = null;
    
    /**
     * Namespace's prefix
     * @var string
     */
    private $namespacePrefix = null;
    
    /**
     * Autoloader's listener
     * @var \Closure
     */
    private $listener = null;
    
    
    public function __construct()
    {
             
    }
    
    protected function dependencyController() 
    {
        $this->doSomeStuff();
    }
    
    protected function doSomeStuff()
    {
        $this->compileListener();
    }
    
    /**
     * Stores directory's path
     * @param string $directoryPath
     */
    private function setPath(string $directoryPath)
    {
        $this->path = realpath(sprintf("%s/%s",
                $this->getDependency('framework')->getApplicationWorkingDirectory(),
                $directoryPath));
        
    }
    
    /**
     * Stores namespace's prefix
     * @param string $namespacePrefix
     */
    private function setNamespacePrefix(string $namespacePrefix)
    {
        $this->namespacePrefix = (string) str_replace("/", "\\", $namespacePrefix);
    }
    
    /**
     * Creates an autoloader from autoloader's parameters array
     * @param array $autoloaderParameters
     * @throws \Sway\Component\Autoloader\Exception\AutoloaderException
     */
    public function createFrom(array $autoloaderParameters)
    {
        /**
         * Autoloader's path is required
         */
        if (array_key_exists('path', $autoloaderParameters)){
            $this->setPath($autoloaderParameters['path']);
        }
        else{
            throw Exception\AutoloaderException::autoloaderPathNotDefined();
        }
        
        /**
         * Namespace's prefix is required
         */
        if (array_key_exists('prefix', $autoloaderParameters)){
            $this->setNamespacePrefix($autoloaderParameters['prefix']);
        }
        else{
            throw Exception\AutoloaderException::namespacePrefixNotDefined();
        }     
    }
    
    /**
     * Gets autoloader directory's path
     * @return string
     */
    private function getPath() : string
    {
        return (string) $this->path;
    }
    
    /**
     * Gets namespace's prefix
     * @return string
     */
    private function getNamespacePrefix() : string
    {
        return (string) $this->namespacePrefix;
    }
    
    /**
     * Compiles autoloader's listener
     */
    protected function compileListener()
    {
        $this->listener = function(string $className){
            
            $classFilePath = sprintf("%s.php", $className);
            $classFilePath = str_replace($this->getNamespacePrefix(), '', $classFilePath);
            
           
            $classFilePath = str_replace('/', DIRECTORY_SEPARATOR, $classFilePath);
            $classFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $classFilePath);

            $classFilePath = $this->getPath() . DIRECTORY_SEPARATOR . $classFilePath;
            
            if (is_file($classFilePath)) {
                require_once ($classFilePath);
            } else {
                return false;
            }

            return true;
            
        };
        
        $this->listener->bindTo($this);
    }
    
    /**
     * Launchs autoloader
     */
    public function revive()
    {
        \spl_autoload_register($this->listener);
    }
    
    /**
     * Dispatchs autoloader
     */
    public function dispatch()
    {
        \spl_autoload_unregister($this->listener);
    }
    
}


?>

