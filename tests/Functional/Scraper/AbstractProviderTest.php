<?php

namespace App\Tests\Functional\Scraper;

use App\Scraper\AbstractProviderScraper;
use PHPUnit\Framework\TestCase;

class AbstractProviderTest extends TestCase
{
    /**
     * @dataProvider stringToFloatProvider
     */
    public function test_string_to_float(float $expected, string $price): void
    {
        $convertedPrice = AbstractProviderScraper::StringToFloat($price);

        $this->assertSame($expected, $convertedPrice);
    }

    public static function stringToFloatProvider(): iterable
    {
        yield 'basic' => [1.0, '1.0'];
        yield 'with_spaces' => [12.7, ' 12.7  '];
        yield 'with_comma' => [42.0, '42,0'];
        yield 'with_euro' => [173.4, '173,4 €'];
    }
}
