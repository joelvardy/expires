<?php

namespace Joelvardy;

use GuzzleHttp\Client;

class SafeBrowsing extends Cache
{

    function __construct($cacheDir)
    {
        $this->cacheInit($cacheDir, 'safebrowsing');
    }

    public function check($domain)
    {

        if ($details = $this->cacheGet($domain)) {
            return $details;
        }

        $client = new Client(['base_uri' => 'https://sb-ssl.google.com/safebrowsing/api/']);
        $response = $client->request('GET', 'lookup', [
            'query' => [
                'client' => 'joelvardy',
                'key' => Config::get('googleSafeBrowsingKey'),
                'appver' => '1.5.2',
                'pver' => '3.1',
                'url' => rawurlencode($domain)
            ]
        ]);

        $matchingLists = explode(',', (string) $response->getBody());

        $details = (object)[
            'checked' => time(),
            'domain' => (object)[
                'issue' => ($response->getStatusCode() == 200),
                'malware' => in_array('malware', $matchingLists),
                'phishing' => in_array('phishing', $matchingLists),
                'unwanted' => in_array('unwanted', $matchingLists)
            ]
        ];

        $this->cacheSet($domain, $details);

        return $details;

    }

}
