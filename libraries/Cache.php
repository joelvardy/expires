<?php

namespace Joelvardy;

class Cache
{

    protected $cacheDir;
    protected $prefix;

    protected function cacheInit($cacheDir, $prefix)
    {
        $this->cacheDir = $cacheDir;
        $this->prefix = $prefix;
    }

    protected function cacheKey($domain)
    {
        return $this->cacheDir . '/' . $this->prefix . '-' . md5($domain) . '.json';
    }

    protected function cacheGet($domain, $cacheValidityTime = 43200)
    {

        if (!file_exists($this->cacheKey($domain))) {
            // Not found in cache
            return false;
        }

        $details = json_decode(file_get_contents($this->cacheKey($domain)));

        if (($details->checked + $cacheValidityTime) < time()) {
            // Cache is out of date
            return false;
        }

        return $details;

    }

    protected function cacheSet($domain, $details)
    {
        return file_put_contents($this->cacheKey($domain), json_encode($details));
    }

}
