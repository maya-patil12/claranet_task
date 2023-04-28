<?php
namespace Album;
use Album\Controller\AlbumController;
use Album\Model\AlbumTable;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }
    public function getControllerConfig(){
        return [
            'factories'=>[
                AlbumController::class=>function($container){
                    return new AlbumController($container->get(AlbumTable::class));
                }
            ]
        ];
    }
    public function getServiceConfig(){
        return [
            'factories'=>[
                Model\AlbumTable::class=>function($container){
                    $tableGateway=$container->get(Model\AlbumTableGateway::class);
                    return new AlbumTable($tableGateway);
                },
            Model\AlbumTableGateway::class=>function($container){
                $dbAdapter=$container->get(AdapterInterface::class);
                $resultSetPrototype=new ResultSet();
                $resultSetPrototype->setArrayObjectPrototype(new Model\Album());
                return new TableGateway('albums',$dbAdapter,null,$resultSetPrototype);
            }
        ],
        ];  
    }
}