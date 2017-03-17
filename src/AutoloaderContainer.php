<?php

namespace Sway\Component\Autoloader;

use Sway\Component\Dependency\DependencyInterface;


class AutoloaderContainer extends DependencyInterface
{
    /**
     * Array which contains autoloaders
     * @var array
     */
    private $autoloaders = null;
    
    
    public function __construct()
    {
        if (empty($this->autoloaders)){
            $this->autoloaders = array();
        }
    }
    
    /**
     * Creates empty autoloader container
     * @return \Sway\Component\Autoloader\AutoloaderContainer
     */
    public static function create()
    {
        $autoloaderContainer = new AutoloaderContainer();
        return $autoloaderContainer;
    }
    
    protected function dependencyController() 
    {
        
    }
    
    /**
     * Creates autoloader from given arrray
     * @param array $autoloaders
     */
    public function appendFrom(array $autoloaders)
    {
        foreach ($autoloaders as $autoloaderParameters){
            $autoloader = new Autoloader();
            $this->getDependency('injector')->inject($autoloader);
            $autoloader->createFrom($autoloaderParameters);
            $autoloader->revive();
            
            array_push($this->autoloaders, $autoloader);
        }
    }
    
    
}


?>