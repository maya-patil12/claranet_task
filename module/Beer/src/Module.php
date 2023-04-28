<?php
namespace Beer;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\BeerTable::class => function($container) {
                    $tableGateway = $container->get(Model\BeerTableGateway::class);
                    return new Model\BeerTable($tableGateway);
                },
                Model\BeerTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Beer());
                    return new TableGateway('beers', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\BeerController::class => function($container) {
                    return new Controller\BeerController(
                        $container->get(Model\BeerTable::class)
                    );
                },
            ],
        ];
    }
}