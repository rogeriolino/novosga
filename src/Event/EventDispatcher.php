<?php

/*
 * This file is part of the Novo SGA project.
 *
 * (c) Rogerio Lino <rogeriolino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Event;

use Novosga\Event\EventInterface;
use Novosga\Event\EventDispatcherInterface;
use Novosga\Infrastructure\StorageInterface;
use Novosga\Service\Configuration;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as WrappedDispatcher;

/**
 * EventDispatcher
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var Configuration
     */
    private $config;
    
    /**
     * @var Context
     */
    private $context;
    
    /**
     * @var WrappedDispatcher
     */
    private $wrapped;

    /**
     * @var array
     */
    private $hooksCache = [];
    
    public function __construct(
        WrappedDispatcher $wrapped,
        Configuration $config,
        Context $context
    ) {
        $this->wrapped = $wrapped;
        $this->context = $context;
        $this->config  = $config;
    }
    
    /**
     * {@inheritdoc}
     */
    public function dispatch(EventInterface $event)
    {
        $eventName = $event->getName();
        $hookKey   = "hooks.{$eventName}";
        $callback  = $this->hooksCache[$hookKey] ?? null;

        if ($callback === null) {
            $callback = $this->config->get($hookKey);
        }

        $event->setContext($this->context);
        
        if (is_callable($callback)) {
            $this->hooksCache[$hookKey] = $callback;
            $this->wrapped->addListener($eventName, $callback);
        }
        
        $this->wrapped->dispatch($eventName, $event);
    }
}
