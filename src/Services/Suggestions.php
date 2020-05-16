<?php

declare(strict_types=1);

namespace Promopult\Dadata\Services;

/**
 * Class Suggestions
 *
 * https://dadata.ru/api/#suggest
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
     * @param string $query     ИНН или ОГРН
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/party/
     */
    public function partySuggest(string $query): array
    {
        return $this->suggest(
            ['query' => $query],
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/party'
        );
    }

    /**
     * API подсказок по банкам
     *
     * @param string $query
     * @param int|null $count               Количество результатов (максимум — 20)
     * @param array|null $locationsBoost    Приоритет города при ранжировании ([..["kladr_id":"6100000100000"], ...])
     * @param array|null $locations         Ограничение по региону или городу ([..["kladr_id":"6100000100000"], ...])
     * @param string|null $status           Ограничение по статусу банка (ACTIVE | LIQUIDATING | LIQUIDATED)
     * @param string|null $type             Ограничение по типу банка (BANK | NKO | BANK_BRANCH | NKO_BRANCH | RKC | OTHER)
     * @return array
     *
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/bank/
     */
    public function bankSuggest(
        string $query,
        ?int $count = null,
        ?array $locationsBoost = null,
        ?array $locations = null,
        ?string $status = null,
        ?string $type = null
    ): array {
        return $this->suggest(
            array_filter([
                'query' => $query,
                'count' => $count,
                'status' => $status,
                'type' => $type,
                'locations' => $locations,
                'locations_boost' => $locationsBoost,
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank'
        );
    }

    /**
     * Банк по БИК, SWIFT, ИНН или регистрационному номеру
     *
     * @param string $query
     * @param string|null $kpp
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/find-bank/
     */
    public function bankFindById(string $query, string $kpp = null): array
    {
        return $this->suggest(array_filter([
            'query' => $query,
            'kpp' => $kpp
        ]), 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/bank');
    }

    /**
     * Обратное геокодирование (адрес по координатам)
     *
     * @param string $lat
     * @param string $lon
     * @param int|null $count
     * @param int|null $radiusMeters
     * @param string|null $language
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/geolocate/
     */
    public function addressGeolocate(
        string $lat,
        string $lon,
        ?int $count = null,
        ?int $radiusMeters = null,
        ?string $language = null
    ): array {
        return $this->suggest(
            array_filter([
                'lat' => $lat,
                'lon' => $lon,
                'count' => $count,
                'radius_meters' => $radiusMeters,
                'language' => $language
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/address'
        );
    }

    /**
     * Адрес по коду КЛАДР или ФИАС
     *
     * @param string $query
     * @param int|null $count
     * @param string|null $language
     * @param array|null $filters
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/find-address/
     */
    public function addressFindById(
        string $query,
        ?int $count = null,
        ?string $language = null,
        ?array $filters = null
    ): array {
        return $this->suggest(
            array_filter([
                'query' => $query,
                'count' => $count,
                'language' => $language,
                'filters' => $filters,
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/address'
        );
    }

    /**
     * Отделения Почты России по геолокации
     *
     * @param string $lat
     * @param string $lon
     * @param int|null $count
     * @param int|null $radiusMeters
     * @param array|null $filters
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/postal_unit/
     */
    public function postalUnitGeolocate(
        string $lat,
        string $lon,
        ?int $count = null,
        ?int $radiusMeters = null,
        ?array $filters = null
    ): array {
        return $this->suggest(
            array_filter([
                'lat' => $lat,
                'lon' => $lon,
                'count' => $count,
                'radius_meters' => $radiusMeters,
                'filters' => $filters,
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/geolocate/postal_unit'
        );
    }

    /**
     * Отделения Почты России по адресу и индексу
     *
     * @param string $query
     * @param int|null $count
     * @param array|null $filters
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/postal_unit/
     */
    public function postalUnitSuggest(
        string $query,
        ?int $count = null,
        ?array $filters = null
    ): array {
        return $this->suggest(
            array_filter([
                'query' => $query,
                'count' => $count,
                'filters' => $filters
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/postal_unit'
        );
    }

    /**
     * Город по IP-адресу
     *
     * @param string $query
     * @param int|null $count
     * @param string|null $language
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/iplocate/
     */
    public function cityIplocate(
        string $query,
        ?int $count = null,
        ?string $language = null
    ): array {
        return $this->suggest(
            array_filter([
                'query' => $query,
                'count' => $count,
                'language' => $language
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/iplocate/address'
        );
    }

    /**
     * Идентификатор города в СДЭК, Boxberry и DPD
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/delivery/
     */
    public function deliveryFindById(
        string $query
    ): array {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/delivery');
    }

    /**
     * @param array $args
     * @param string $uri
     * @return mixed
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function suggest(array $args, string $uri)
    {
        $request = $this->requestFactory->createRequest('POST', $uri, $args);

        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }
}
