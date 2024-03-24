<?php

namespace App\Event\Scraping;

use App\Entity\Provider;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractScrapingEvent extends Event
{
    public function __construct(
        public readonly Provider $provider,
    ) {
    }
}
