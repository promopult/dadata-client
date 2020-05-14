<?php

declare(strict_types=1);

namespace Promopult\Dadata\Services;

/**
 * Class Suggestions
 */
final class Suggestions extends \Promopult\Dadata\Service
{
    /**
     * Организация по ИНН или ОГРН
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/find-party/
     */
    public function partyFindById(string $query): array
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party',
            ['query' => $query]
        );

        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }

    /**
     * Поиск аффилированных компаний
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/find-affiliated/
     */
    public function partyFindAffiliated(string $query): array
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findAffiliated/party',
            ['query' => $query]
        );

        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }

    /**
     * API подсказок по организациям
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/party/
     */
    public function partySuggest(string $query): array
    {
        $request = $this->requestFactory->createRequest(
            'POST',
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party',
            ['query' => $query]
        );

        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $query
     * @param int|null $count               Количество результатов (максимум — 20)
     * @param array|null $locationsBoost    Приоритет города при ранжировании ([..["kladr_id":"6100000100000"], ...])
     * @param array|null $locations         Ограничение по региону или городу ([..["kladr_id":"6100000100000"], ...])
     * @param string|null $status           Ограничение по статусу банка (ACTIVE | LIQUIDATING | LIQUIDATED)
     * @param string|null $type             Ограничение по типу банка (BANK | NKO | BANK_BRANCH | NKO_BRANCH | RKC | OTHER)
     * @return array
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function bankSuggest(
        string $query,
        ?int $count = null,
        ?array $locationsBoost = null,
        ?array $locations = null,
        ?string $status = null,
        ?string $type = null
    ): array {

        $request = $this->requestFactory->createRequest(
            'POST',
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank',
            array_filter([
                'query' => $query,
                'count' => $count,
                'status' => $status,
                'type' => $type,
                'locations' => $locations,
                'locations_boost' => $locationsBoost,
            ])
        );

        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }
}
