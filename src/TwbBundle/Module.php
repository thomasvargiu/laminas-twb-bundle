<?php
namespace TwbBundle;
class Module implements \Laminas\ModuleManager\Feature\ConfigProviderInterface
{
    /**
     * @return array
     */
    public function getConfig(){
        return include __DIR__.DIRECTORY_SEPARATOR.'/../../config/module.config.php';
    }
}