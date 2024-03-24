<?php

namespace App\Event\Scraping;

use App\Entity\Provider;
use App\Scraper\Exceptions\ScrapingFailedException;

class ScrapingFailedEvent extends AbstractScrapingEvent
{
    public function __construct(
        public readonly ScrapingFailedException $e,
        Provider $provider,
    ) {
        parent::__construct($provider);
    }
}
