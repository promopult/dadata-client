<?php

declare(strict_types=1);

namespace Promopult\Dadata\Services;

/**
 * Class Clean
 *
 * API стандартизации
 *
 * @see https://dadata.ru/api/clean/
 */
final class Clean extends \Promopult\Dadata\Service
{
    /**
     * @param string $address
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/address/
     */
    public function address(string $address): array
    {
        return $this->clean([$address], 'https://cleaner.dadata.ru/api/v1/clean/address');
    }

    /**
     * API стандартизации email
     *
     * @param string $email
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/email/
     */
    public function email(string $email): array
    {
        return $this->clean([$email], 'https://cleaner.dadata.ru/api/v1/clean/email');
    }

    /**
     * API стандартизации телефонов
     *
     * @param string $phone
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/phone/
     */
    public function phone(string $phone): array
    {
        return $this->clean([$phone], 'https://cleaner.dadata.ru/api/v1/clean/phone');
    }

    /**
     * API стандартизации ФИО
     *
     * @param string $name
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/name/
     */
    public function name(string $name): array
    {
        return $this->clean([$name], 'https://cleaner.dadata.ru/api/v1/clean/name');
    }

    /**
     * API стандартизации паспортов
     *
     * @param string $passport
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/passport/
     */
    public function passport(string $passport): array
    {
        return $this->clean([$passport], 'https://cleaner.dadata.ru/api/v1/clean/passport');
    }

    public function vehicle(string $vehicle): array
    {
        return $this->clean([$vehicle], 'https://cleaner.dadata.ru/api/v1/clean/vehicle');
    }

    public function custom(array $structure, array $data): array
    {
        return $this->clean([
            'structure' => $structure,
            'data' => $data
        ], 'https://cleaner.dadata.ru/api/v1/clean');
    }

    /**
     * API стандартизации дат рождения
     *
     * @param string $birthdate
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     * @see https://dadata.ru/api/clean/birthdate/
     */
    public function birthdate(string $birthdate): array
    {
        return $this->clean([$birthdate], 'https://cleaner.dadata.ru/api/v1/clean/birthdate');
    }

    /**
     * @param array $args
     * @param string $uri
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    private function clean(array $args, string $uri): array
    {
        $request = $this->createRequest('POST', $uri, $args);
        $response = $this->httpClient->sendRequest($request);
        return \json_decode($response->getBody()->getContents(), true);
    }
}
