<?php

declare(strict_types=1);

namespace Promopult\Dadata\Services;

use Promopult\Dadata\Service;

/**
 * Class Clean
 */
final class Clean extends Service
{
    /**
     * @param string $address
     * @return array|bool|float|int|string|null
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/address/
     */
    public function address(string $address)
    {
        $request = $this->requestFactory->createRequest('POST', 'https://cleaner.dadata.ru/api/v1/clean/address', [
            $address
        ]);

        $response = $this->httpClient->sendRequest($request);

        return \GuzzleHttp\json_decode($response->getBody()->getContents(), true);
    }
}
