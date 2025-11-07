<?php

namespace App\Support\Util;

class SeoUrlHelper
{
    /**
     * Mapeamento de valores de filtros para URLs amigáveis
     */
    private static array $friendlyMappings = [
        'gender' => [
            'masculine' => 'masculino',
            'feminine' => 'feminino',
            'unisex' => 'unisex',
            'kids' => 'infantil',
        ],
        'sort' => [
            'most_sold' => 'mais-vendidos',
            'newest' => 'novidades',
            'promotions' => 'promocoes',
            'price_asc' => 'preco-menor',
            'price_desc' => 'preco-maior',
        ],
        'product_type' => [
            'uniforme' => 'uniforme',
            'casual' => 'casual',
            'acessorios' => 'acessorios',
        ],
        'category' => [
            'Retro' => 'retro',
            'torcedor' => 'torcedor',
            'jogador' => 'jogador',
            'treino' => 'treino',
        ],
        'national_international' => [
            'Sim' => 'nacional',
            'Não' => 'internacional',
        ],
    ];

    /**
     * Mapeamento reverso de URLs amigáveis para valores de filtros
     */
    private static array $reverseMappings = [
        'gender' => [
            'masculino' => 'masculine',
            'feminino' => 'feminine',
            'unisex' => 'unisex',
            'infantil' => 'kids',
        ],
        'sort' => [
            'mais-vendidos' => 'most_sold',
            'novidades' => 'newest',
            'promocoes' => 'promotions',
            'preco-menor' => 'price_asc',
            'preco-maior' => 'price_desc',
        ],
        'product_type' => [
            'uniforme' => 'uniforme',
            'casual' => 'casual',
            'acessorios' => 'acessorios',
        ],
        'category' => [
            'retro' => 'Retro',
            'torcedor' => 'torcedor',
            'jogador' => 'jogador',
            'treino' => 'treino',
        ],
        'national_international' => [
            'nacional' => 'Sim',
            'internacional' => 'Não',
        ],
    ];

    /**
     * Converte um array de filtros em uma URL amigável
     */
    public static function filtersToUrl(array $filters, ?string $baseUrl = '/camisas'): string
    {
        $segments = [];

        // Time (primeiro segmento se existir)
        if (!empty($filters['team'])) {
            $segments[] = $filters['team'];
        }

        // Gênero (múltiplos valores unidos por '-')
        if (!empty($filters['gender'])) {
            $genders = explode(',', $filters['gender']);
            $friendlyGenders = array_map(function($gender) {
                return self::$friendlyMappings['gender'][trim($gender)] ?? null;
            }, $genders);
            $friendlyGenders = array_filter($friendlyGenders);
            if (!empty($friendlyGenders)) {
                $segments[] = implode('-', $friendlyGenders);
            }
        }

        // Temporada (formato 23-24)
        if (!empty($filters['season'])) {
            $season = str_replace('/', '-', $filters['season']);
            $segments[] = $season;
        }

        // Categoria (múltiplos valores)
        if (!empty($filters['category'])) {
            $categories = explode(',', $filters['category']);
            $friendlyCategories = array_map(function($category) {
                $category = trim($category);
                return self::$friendlyMappings['category'][$category] ?? strtolower($category);
            }, $categories);
            $friendlyCategories = array_filter($friendlyCategories);
            if (!empty($friendlyCategories)) {
                $segments[] = implode('-', array_unique($friendlyCategories));
            }
        }

        // Tipo de produto
        if (!empty($filters['product_type'])) {
            $segments[] = self::$friendlyMappings['product_type'][$filters['product_type']] ?? strtolower($filters['product_type']);
        }

        // Nacional/Internacional
        if (!empty($filters['national_international'])) {
            $nationalInt = explode(',', $filters['national_international']);
            $friendlyNationalInt = array_map(function($ni) {
                $ni = trim($ni);
                return self::$reverseMappings['national_international'][strtolower($ni)] ?? null;
            }, $nationalInt);
            // Se houver apenas um valor, adiciona como segmento
            if (count($friendlyNationalInt) === 1) {
                $segments[] = self::$friendlyMappings['national_international'][$friendlyNationalInt[0]] ?? '';
            }
        }

        // Tamanho (múltiplos valores)
        if (!empty($filters['size'])) {
            $sizes = explode(',', $filters['size']);
            $segments[] = 'tamanho-' . implode('-', array_map('strtolower', $sizes));
        }

        // Preço máximo
        if (!empty($filters['price_max']) && $filters['price_max'] != '500') {
            $priceMax = intval($filters['price_max']);
            $segments[] = 'ate-' . $priceMax;
        }

        // Ordenação (último segmento, padrão: mais-vendidos)
        $sort = $filters['sort'] ?? 'most_sold';
        if ($sort !== 'most_sold') {
            $segments[] = self::$friendlyMappings['sort'][$sort] ?? 'mais-vendidos';
        }

        // Construir URL
        $url = $baseUrl;
        if (!empty($segments)) {
            $url .= '/' . implode('/', $segments);
        }

        // Adicionar página se for diferente de 1
        if (!empty($filters['page']) && $filters['page'] > 1) {
            $url .= '/pagina-' . $filters['page'];
        }

        return $url;
    }

    /**
     * Converte uma URL amigável em um array de filtros
     */
    public static function urlToFilters(string $url): array
    {
        $filters = [];
        $segments = array_filter(explode('/', trim($url, '/')));
        
        // Detecta se é uma URL de time (/time/{team}/...)
        $isTeamUrl = false;
        $teamUrl = null;
        if (isset($segments[0]) && $segments[0] === 'time' && isset($segments[1])) {
            $teamUrl = $segments[1];
            $isTeamUrl = true;
            // Remove 'time' e o teamUrl dos segmentos
            array_shift($segments); // Remove 'time'
            array_shift($segments); // Remove teamUrl
        }
        
        // Remove 'camisas' se for o primeiro segmento
        if (isset($segments[0]) && $segments[0] === 'camisas') {
            array_shift($segments);
        }
        
        // Se veio de uma URL de time, adiciona o team aos filtros
        if ($isTeamUrl && $teamUrl) {
            $filters['team'] = $teamUrl;
        }

        foreach ($segments as $segment) {
            // Página
            if (preg_match('/^pagina-(\d+)$/', $segment, $matches)) {
                $filters['page'] = (int) $matches[1];
                continue;
            }

            // Preço máximo
            if (preg_match('/^ate-(\d+)$/', $segment, $matches)) {
                $filters['price_max'] = $matches[1];
                continue;
            }

            // Tamanho
            if (preg_match('/^tamanho-(.+)$/', $segment, $matches)) {
                $sizes = explode('-', $matches[1]);
                $filters['size'] = implode(',', array_map('strtoupper', $sizes));
                continue;
            }

            // Temporada (formato 23-24)
            if (preg_match('/^\d{2}-\d{2}$/', $segment)) {
                $filters['season'] = str_replace('-', '/', $segment);
                continue;
            }

            // Gênero (pode conter múltiplos valores separados por '-')
            $genderFound = false;
            foreach (self::$reverseMappings['gender'] as $friendly => $value) {
                if (strpos($segment, $friendly) !== false) {
                    $genderParts = explode('-', $segment);
                    $genderValues = [];
                    foreach ($genderParts as $part) {
                        if (isset(self::$reverseMappings['gender'][$part])) {
                            $genderValues[] = self::$reverseMappings['gender'][$part];
                        }
                    }
                    if (!empty($genderValues)) {
                        $filters['gender'] = implode(',', array_unique($genderValues));
                        $genderFound = true;
                        break;
                    }
                }
            }
            if ($genderFound) {
                continue;
            }

            // Categoria
            $categoryFound = false;
            foreach (self::$reverseMappings['category'] as $friendly => $value) {
                if ($segment === $friendly || strpos($segment, $friendly) !== false) {
                    $categoryParts = explode('-', $segment);
                    $categoryValues = [];
                    foreach ($categoryParts as $part) {
                        if (isset(self::$reverseMappings['category'][$part])) {
                            $categoryValues[] = self::$reverseMappings['category'][$part];
                        }
                    }
                    if (!empty($categoryValues)) {
                        $existingCategory = $filters['category'] ?? '';
                        $filters['category'] = !empty($existingCategory) 
                            ? $existingCategory . ',' . implode(',', array_unique($categoryValues))
                            : implode(',', array_unique($categoryValues));
                        $categoryFound = true;
                        break;
                    }
                }
            }
            if ($categoryFound) {
                continue;
            }

            // Tipo de produto
            if (isset(self::$reverseMappings['product_type'][$segment])) {
                $filters['product_type'] = self::$reverseMappings['product_type'][$segment];
                continue;
            }

            // Nacional/Internacional
            if (isset(self::$reverseMappings['national_international'][$segment])) {
                $filters['national_international'] = self::$reverseMappings['national_international'][$segment];
                continue;
            }

            // Ordenação
            if (isset(self::$reverseMappings['sort'][$segment])) {
                $filters['sort'] = self::$reverseMappings['sort'][$segment];
                continue;
            }

            // Time (se não for reconhecido como nenhum dos acima, assume-se que é o time)
            // O time geralmente é o primeiro segmento (apenas para URLs /camisas, não /time/{team})
            if (empty($filters['team']) && !$isTeamUrl) {
                // Verificar se não é nenhum dos valores conhecidos
                $isKnownValue = false;
                foreach (self::$reverseMappings as $mappings) {
                    if (isset($mappings[$segment])) {
                        $isKnownValue = true;
                        break;
                    }
                }
                // Verificar se não é um padrão conhecido
                $isKnownPattern = preg_match('/^(pagina|ate|tamanho)-\d+$/', $segment) || 
                                  preg_match('/^\d{2}-\d{2}$/', $segment) ||
                                  preg_match('/^masculino|feminino|unisex|infantil/', $segment) ||
                                  preg_match('/^mais-vendidos|novidades|promocoes|preco-menor|preco-maior$/', $segment);
                
                if (!$isKnownValue && !$isKnownPattern) {
                    // Se for o primeiro segmento não identificado, provavelmente é o time
                    $segmentIndex = array_search($segment, array_values($segments));
                    if ($segmentIndex === 0) {
                        $filters['team'] = $segment;
                    }
                }
            }
        }

        // Valores padrão
        if (empty($filters['sort'])) {
            $filters['sort'] = 'most_sold';
        }
        if (empty($filters['page'])) {
            $filters['page'] = 1;
        }

        return $filters;
    }

    /**
     * Gera uma URL amigável a partir de parâmetros de query string
     */
    public static function queryStringToUrl(string $path, array $queryParams): string
    {
        $filters = [];
        
        // Mapear query params para filtros
        if (isset($queryParams['team'])) $filters['team'] = $queryParams['team'];
        if (isset($queryParams['gender'])) $filters['gender'] = $queryParams['gender'];
        if (isset($queryParams['season'])) $filters['season'] = $queryParams['season'];
        if (isset($queryParams['category'])) $filters['category'] = $queryParams['category'];
        if (isset($queryParams['product_type'])) $filters['product_type'] = $queryParams['product_type'];
        if (isset($queryParams['national_international'])) $filters['national_international'] = $queryParams['national_international'];
        if (isset($queryParams['size'])) $filters['size'] = $queryParams['size'];
        if (isset($queryParams['price_max'])) $filters['price_max'] = $queryParams['price_max'];
        if (isset($queryParams['sort'])) $filters['sort'] = $queryParams['sort'];
        if (isset($queryParams['page'])) $filters['page'] = (int) $queryParams['page'];

        return self::filtersToUrl($filters, $path);
    }
}

