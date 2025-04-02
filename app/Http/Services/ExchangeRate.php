<?php

namespace App\Http\Services;


use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;

class ExchangeRate
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://www.sunat.gob.pe/',
            'timeout'  => 15,
        ]);
    }

    private function search($month, $year)
    {
        try {
            $response = $this->client->request('GET', 'a/txt/tipoCambio.txt');

            $body = $response->getBody()->getContents();

            if ($body) {
                $explode = explode('|', $body);

                $values[] = [
                    (int)substr($body, 0, 2),
                    $explode[1],
                    $explode[2]
                ];

                return collect($values)->toArray();
            }

        } catch (RequestException $e) {
            Log::info("Error en la consulta de T/C: " . $e->getMessage());
            return false;
        } catch (ClientException $e) {
            Log::info("Error en la consulta de T/C: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            Log::info("Error en la consulta de T/C: " . $e->getMessage());
            return false;
        }

        return false;
    }

    public function searchDate($date)
    {
        $date = Carbon::parse($date);

        for ($i = 0; $i < 4; $i++) {
            $res = $this->searchByDay($date);
            if ($res) {
                return $res;
            }
            $date = $date->subDay();
        }

        return false;
    }

    private function searchByDay($date)
    {
        $day = $date->day;
        $year = $date->year;
        $month = $date->month;

        $exchange_rates = $this->search($month, $year);

        if ($exchange_rates) {
            foreach ($exchange_rates as $row) {
                $new_row = array_values($row);

                if ($new_row[0] == (int)$day) {
                    return [
                        'date_data' => $date->format('Y-m-d'),
                        'data' => [
                            'purchase' => $new_row[1],
                            'sale' => $new_row[2]
                        ]
                    ];
                }
            }
        }

        return false;
    }
}
