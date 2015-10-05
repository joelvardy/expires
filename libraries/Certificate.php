<?php

namespace Joelvardy;

class Certificate extends Cache
{

    function __construct($cacheDir)
    {
        $this->cacheInit($cacheDir, 'certificate');
    }

    protected function format($details)
    {

        $date = new \DateTime();
        $date->setTimestamp($details->domain->created);
        $details->domain->created = $date;

        $date = new \DateTime();
        $date->setTimestamp($details->domain->expires);
        $details->domain->expires = $date;

        return $details;

    }

    public function check($domain)
    {

        if ($details = $this->cacheGet($domain)) {
            return $this->format($details);
        }

        $certFilepath = $this->cacheDir . '/' . md5($domain) . '.crt';
        $response = `echo -n | openssl s_client -servername $domain -connect $domain:443 2>&1 | sed -ne '/-BEGIN CERTIFICATE-/,/-END CERTIFICATE-/p' > $certFilepath`; // Download certificate
        $data = openssl_x509_parse(file_get_contents($certFilepath));

        unlink($certFilepath); // Remove downloaded certificate

        if (!isset($data['validFrom_time_t']) || !isset($data['validTo_time_t'])) {
            // Could not load certificate
            return false;
        }

        $details = (object)[
            'checked' => time(),
            'domain' => (object)[
                'created' => $data['validFrom_time_t'],
                'expires' => $data['validTo_time_t']
            ]
        ];

        $this->cacheSet($domain, $details);

        return $this->format($details);

    }

}
