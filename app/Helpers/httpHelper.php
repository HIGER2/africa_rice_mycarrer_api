<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class httpHelper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function fetchApi(string $method, string $url, array $options = [])
    {
        $client = new Client([
            'verify' => false, // Désactive la vérification SSL
        ]);
        try {
            // Effectuer la requête à l'API avec Guzzle
            $response = $client->request($method, $url, $options);
            // Récupérer les données de la réponse et les décoder
            // $data = json_decode($response->getBody(), true);
            $data = json_decode($response->getBody()->getContents());

            return (object)[
                "data" => $data,
                "error" => false
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $body = $response ? $response->getBody()->getContents() : 'No response body';
            return (object)[
                "data" => null,
                "error" => true,
                "message" => $e->getMessage(),
                "response_body" => $body
            ];
        } catch (RequestException $e) {
            // Capturer les exceptions Guzzle
            return (object)[
                "data" => false,
                "error" => $e->getMessage()
            ];
            // throw new \Exception("Erreur lors de la requête à l'API : " . $e->getMessage());
        }
    }

    public static  function generateRecruitmentCode($lastNumber = 0, $prefix = 'REC', $year = null)
        {
            $year = $year ?? date('Y');
            $nextNumber = $lastNumber + 1;
            $paddedNumber = str_pad($nextNumber, 3, '0', STR_PAD_LEFT); // Format 005
            return "{$prefix}-{$year}-{$paddedNumber}";
        }

}
