<?php

namespace Joelvardy;

use \Novutec\WhoisParser\Parser;

class Whois extends Cache
{

    protected $parser;

    function __construct($cacheDir)
    {
        $this->cacheInit($cacheDir, 'whois');
        $this->parser = new Parser();
    }

    protected function format($details)
    {

        $date = new \DateTime();
        $date->setTimestamp($details->domain->created);
        $details->domain->created = $date;

        $date = new \DateTime();
        $date->setTimestamp($details->domain->updated);
        $details->domain->updated = $date;

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

        $data = $this->parser->lookup($domain);

        if (!isset($data->created) || !isset($data->changed) || !isset($data->expires)) {
            // Could not load whos data
            return false;
        }

        $details = (object)[
            'checked' => time(),
            'domain' => (object)[
                'created' => strtotime($data->created),
                'updated' => strtotime($data->changed),
                'expires' => strtotime($data->expires)
            ]
        ];

        $this->cacheSet($domain, $details);

        return $this->format($details);

    }

}
