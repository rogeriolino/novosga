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
use Novosga\Event\ContextInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * AbstractEvent
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
abstract class AbstractEvent extends Event implements EventInterface
{
    /**
     * @var Context
     */
    protected $context;

    public function __construct(ContextInterface $context)
    {
        $this->context = $context;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getContext(): ?ContextInterface
    {
        return $this->context;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(ContextInterface $context)
    {
        $this->context = $context;

        return $this;
    }
}
