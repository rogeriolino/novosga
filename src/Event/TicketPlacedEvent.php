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

use Novosga\Entity\Atendimento;
use Novosga\Event\TicketPlacedEventInterface;

/**
 * TicketPlacedEvent
 *
 * @author Rogerio Lino <rogeriolino@gmail.com>
 */
class TicketPlacedEvent extends AbstractEvent implements TicketPlacedEventInterface
{
    /**
     * @var Atendimento
     */
    protected $atendimento;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return TicketPlacedEventInterface::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getAtendimento(): Atendimento
    {
        return $this->atendimento;
    }

    /**
     * {@inheritdoc}
     */
    public function setAtendimento(Atendimento $atendimento): TicketPlacedEventInterface
    {
        $this->atendimento = $atendimento;

        return $this;
    }
}