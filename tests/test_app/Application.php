<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.3.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App;

use Robotusers\Tactician\Locator\ConventionsLocator;
use League\Tactician\Handler\MethodNameInflector\HandleClassNameInflector;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;
use Robotusers\Commander\CommandBusInterface;
use Robotusers\Tactician\Core\BusApplicationInterface;
use Robotusers\Tactician\Core\BusMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 */
class Application extends BaseApplication implements BusApplicationInterface
{

    /**
     * @var CommandBusInterface
     */
    private static $commandBus;

    /**
     * @inheritdoc
     */
    public function bootstrap(): void
    {
        parent::bootstrap();
    }

    /**
     * Setup the middleware your application will use.
     *
     * @param MiddlewareQueue $middleware The middleware queue to setup.
     * @return MiddlewareQueue The updated middleware.
     */
    public function middleware($middleware): MiddlewareQueue
    {
        $middleware
            ->add(new BusMiddleware($this))
            // Catch any exceptions in the lower layers,
            // and make an error page/response
            ->add(ErrorHandlerMiddleware::class)
            // Handle plugin/theme assets like CakePHP normally does.
            ->add(AssetMiddleware::class)
            // Apply routing
            ->add(new RoutingMiddleware($this));

        return $middleware;
    }

    /**
     * Command bus application hook.
     *
     * @return CommandBus|CommandBusInterface
     */
    public function commandBus(): CommandBus
    {
        $locator = new ConventionsLocator();
        $extractor = new ClassNameExtractor();
        $inflector = new HandleClassNameInflector();

        return new CommandBus([new CommandHandlerMiddleware($extractor, $locator, $inflector)]);
    }
}