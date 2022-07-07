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
        $request = $this->createRequest(
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
        $request = $this->createRequest(
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
     * API подсказок по адресам
     *
     * @param string $query
     * @param int|null $count
     * @param string|null $language
     * @param array|null $locations
     * @param array|null $locationsBoost
     * @param string|null $fromBound
     * @param string|null $toBound
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/address/
     */
    public function addressSuggest(
        string $query,
        ?int $count = null,
        ?string $language = null,
        ?array $locations = null,
        ?array $locationsBoost = null,
        ?string $fromBound = null,
        ?string $toBound = null
    ): array {

        $fromBound = $fromBound ?: ['value' => $fromBound];
        $toBound = $toBound ?: ['value' => $toBound];

        return $this->suggest(
            array_filter([
                'query' => $query,
                'count' => $count,
                'language' => $language,
                'locations' => $locations,
                'locations_boost' => $locationsBoost,
                'from_bound' => $fromBound,
                'to_bound' => $toBound
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/address'
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
     * API подсказок по ФИАС
     *
     * @param string $query
     * @param int|null $count
     * @param array|null $locations
     * @param array|null $locationsBoost
     * @param string|null $fromBound
     * @param string|null $toBound
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/fias/
     */
    public function fiasSuggest(
        string $query,
        ?int $count = null,
        ?array $locations = null,
        ?array $locationsBoost = null,
        ?string $fromBound = null,
        ?string $toBound = null
    ): array {
        $fromBound = $fromBound ?: ['value' => $fromBound];
        $toBound = $toBound ?: ['value' => $toBound];

        return $this->suggest(
            array_filter([
                'query' => $query,
                'count' => $count,
                'locations' => $locations,
                'locations_boost' => $locationsBoost,
                'from_bound' => $fromBound,
                'to_bound' => $toBound
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fias'
        );
    }

    /**
     * API справочников: кем выдан паспорт
     *
     * @param string $query
     * @param array|null $filters
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/fms_unit/
     */
    public function fmsUnitSuggest(
        string $query,
        ?array $filters = []
    ): array {
        return $this->suggest(
            array_filter([
                'query' => $query,
                'filters' => $filters
            ]),
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fms_unit'
        );
    }

    /**
     * API справочников: марки автомобилей
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/car_brand/
     */
    public function carBrandSuggest(
        string $query
    ): array {
        return $this->suggest(
            [
                'query' => $query
            ],
            'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/car_brand'
        );
    }

    /**
     * API справочников: марки автомобилей
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/car_brand/
     */
    public function carBrandFindById(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/car_brand');
    }

    /**
     * API справочников: страны
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/country/
     */
    public function countrySuggest(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/country');
    }

    /**
     * API справочников: страны
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/country/
     */
    public function countryFindById(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/country');
    }

    /**
     * API справочников: валюты
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/currency/
     */
    public function currencySuggest(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/currency');
    }

    /**
     * API справочников: валюты
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/currency/
     */
    public function currencyFindById(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/currency');
    }

    /**
     * API справочников: виды деятельности (ОКВЭД 2)
     *
     * @param string $query
     * @param array|null $filters   [["razdel" => "C" ], ...]
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/okved2/
     */
    public function okved2Suggest(string $query, ?array $filters = null): array
    {
        return $this->suggest([
            'query' => $query,
            'filters' => $filters
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/okved2');
    }

    /**
     * API справочников: виды деятельности (ОКВЭД 2)
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/okved2/
     */
    public function okved2FindById(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/okved2');
    }

    /**
     * API справочников: виды продукции (ОКПД 2)
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/okpd2/
     */
    public function okpd2Suggest(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/okpd2');
    }

    /**
     * API справочников: виды продукции (ОКПД 2)
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/okpd2/
     */
    public function okpd2FindById(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/okpd2');
    }

    /**
     * API справочников: налоговые инспекции
     *
     * @param string $query
     * @param array|null $filter
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/fns_unit/
     */
    public function fnsUnitSuggest(string $query, ?array $filter = null): array
    {
        return $this->suggest([
            'query' => $query,
            'filter' => $filter
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fns_unit');
    }

    /**
     * API справочников: налоговые инспекции
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/fns_unit/
     */
    public function fnsUnitFindById(string $query): array
    {
        return $this->suggest([
            'query' => $query
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/fns_unit');
    }

    /**
     * API справочников: мировые суды
     *
     * @param string $query
     * @param array|null $filters
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/region_court/
     */
    public function regionCourtSuggest(string $query, ?array $filters = null): array
    {
        return $this->suggest([
            'query' => $query,
            'filters' => $filters
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/region_court');
    }

    /**
     * API справочников: мировые суды
     *
     * @param string $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/region_court/
     */
    public function regionCourtFindById(string $query): array
    {
        return $this->suggest([
            'query' => $query,
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/region_court');
    }


    /**
     * API справочников: станции метро
     *
     * @param string $query
     * @param array|null $filters   [['city_kladr_id' => '7800000000000'], ...]
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/suggest/metro/
     */
    public function metroSuggest(string $query, ?array $filters = null): array
    {
        return $this->suggest([
            'query' => $query,
            'filters' => $filters
        ], 'https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/metro');
    }

    /* Private */

    /**
     * @param array $args
     * @param string $uri
     * @return mixed
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function suggest(array $args, string $uri)
    {
        $request = $this->createRequest('POST', $uri, $args);

        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }
}
