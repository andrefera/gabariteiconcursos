<?php

namespace Tests\Unit\Support\Util;

use App\Support\Util\SeoUrlHelper;
use PHPUnit\Framework\TestCase;

class SeoUrlHelperTest extends TestCase
{
    public function testFiltersToUrlGeneratesFriendlyPath(): void
    {
        $filters = [
            'team' => 'corinthians',
            'gender' => 'masculine,feminine',
            'season' => '23/24',
            'category' => 'torcedor,Retro',
            'product_type' => 'casual',
            'national_international' => 'Sim',
            'size' => 'P,M',
            'price_max' => '350',
            'sort' => 'price_desc',
            'page' => 2,
        ];

        $url = SeoUrlHelper::filtersToUrl($filters);

        $this->assertSame(
            '/camisas/corinthians/masculino-feminino/23-24/torcedor-retro/casual/nacional/tamanho-p-m/ate-350/preco-maior/pagina-2',
            $url
        );
    }

    public function testUrlToFiltersRestoresOriginalFilters(): void
    {
        $url = '/camisas/corinthians/masculino-feminino/23-24/torcedor-retro/casual/nacional/tamanho-p-m/ate-350/preco-maior/pagina-2';

        $filters = SeoUrlHelper::urlToFilters($url);

        $this->assertEquals([
            'team' => 'corinthians',
            'gender' => 'masculine,feminine',
            'season' => '23/24',
            'category' => 'torcedor,Retro',
            'product_type' => 'casual',
            'national_international' => 'Sim',
            'size' => 'P,M',
            'price_max' => '350',
            'sort' => 'price_desc',
            'page' => 2,
        ], $filters);
    }

    public function testQueryStringToUrlBuildsFriendlyUrl(): void
    {
        $url = SeoUrlHelper::queryStringToUrl('/camisas', [
            'gender' => 'unisex',
            'price_max' => '200',
        ]);

        $this->assertSame('/camisas/unisex/ate-200', $url);
    }

    public function testFiltersToUrlSkipsNationalSegmentWhenMultipleValues(): void
    {
        $url = SeoUrlHelper::filtersToUrl([
            'national_international' => 'Sim,Não',
        ]);

        $this->assertSame('/camisas', $url);
    }
}

