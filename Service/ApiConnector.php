<?php

class ApiConnector
{
    const API_URL = 'https://randomuser.me/api/';
    const BACKUP_API_URL = 'https://randomuser.me/api/';

    public function receive(string $method = 'GET', string $path = '')
    {
        $options = [
            'http' => [
                'method' => $method,
            ],
        ];

        $context = stream_context_create($options);

        return  file_get_contents(self::BACKUP_API_URL . $path, false, $context);
    }

    public function receiveByCurl(string $method = 'GET', string $path = '')
    {
        $cURLConnection = curl_init(self::API_URL . $path);
        curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($cURLConnection);
        curl_close($cURLConnection);

        return $apiResponse;
    }


    public function emulateReceive(string $filePath)
    {
        if (empty($filePath)) {
            throw new \Exception('File path is empty');
        }

        if (!file_exists($filePath)) {
            throw new \Exception('Specified file does not exists');
        }

        return  file_get_contents($filePath);
    }
}