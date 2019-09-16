<?php

namespace ExtractData;

use GuzzleHttp\Client;

class Extract
{
    /**
     * @param $baseUrl
     * @param null $uri
     * @return array
     */
    public function extract($baseUrl, $uri = null): array
    {
        $data = [];

        $client = new Client([
            'base_uri' => $baseUrl,
            'timeout' => 2.0,
        ]);

        $response = $client->get($uri);
        $content = $response->getBody()->getContents();

        //A página lida contém erros de HTML. A linha abaixo bloqueia a exibição dos Warnings.
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($content);

        $content = $dom->getElementById('content');
        $table = $content->getElementsByTagName('table')->item(0);
        foreach ($table->getElementsByTagName('tr') as $k => $tr) {
            if ($k > 0) {
                $tds = $tr->getElementsByTagName('td');
                $data[$k]['vigencia'] = trim($tds->item(0)->nodeValue);
                $data[$k]['valor_mensal'] = trim($tds->item(1)->nodeValue);
                $data[$k]['valor_diario'] = trim($tds->item(2)->nodeValue);
                $data[$k]['valor_hora'] = trim($tds->item(3)->nodeValue);
                $data[$k]['norma_legal'] = trim($tds->item(4)->nodeValue);
                $data[$k]['dou'] = trim($tds->item(5)->nodeValue);
            }
        }

        return $data;
    }
}