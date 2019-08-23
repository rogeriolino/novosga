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

use Novosga\Entity\Usuario;
use Novosga\Event\ContextInterface;
use Novosga\Infrastructure\StorageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Context
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class Context implements ContextInterface
{
    /**
     * @var Usuario
     */
    private $user;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var StorageInterface
     */
    private $storage;
    
    /**
     * {@inheritdoc}
     */
    public function __construct(
        TokenStorageInterface $token,
        StorageInterface $storage,
        LoggerInterface $logger
    ) {
        $this->storage = $storage;
        $this->logger  = $logger;
        $this->user    = $token->getToken() ? $token->getToken()->getUser() : null;
    }
        
    /**
     * {@inheritdoc}
     */
    public function getStorage(): ?StorageInterface
    {
        return $this->storage;
    }
        
    /**
     * {@inheritdoc}
     */
    public function getUser(): ?Usuario
    {
        return $this->user;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }
}
