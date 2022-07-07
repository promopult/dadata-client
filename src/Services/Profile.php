<?php

declare(strict_types=1);

namespace Promopult\Dadata\Services;

/**
 * Class Profile
 */
final class Profile extends \Promopult\Dadata\Service
{
    /**
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function balance(): array
    {
        $request = $this->createRequest('GET', 'https://dadata.ru/api/v2/profile/balance');
        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param string $date  Дата в формате YYYY-mm-dd
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function dailyStat(string $date): array
    {
        $request = $this->createRequest('GET', 'https://dadata.ru/api/v2/stat/daily?date=' . $date);
        $response = $this->httpClient->sendRequest($request);

        return \json_decode($response->getBody()->getContents(), true);
    }
}
