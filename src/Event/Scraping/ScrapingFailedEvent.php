<?php

namespace App\Event\Scraping;

use App\Scraper\Exceptions\ScrapingFailedException;
use Symfony\Contracts\EventDispatcher\Event;

class ScrapingFailedEvent extends Event
{
    public function __construct(
        public readonly ScrapingFailedException $e
    ) {
    }
}
