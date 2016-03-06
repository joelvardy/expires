<?php

require(__DIR__ . '/vendor/autoload.php');

date_default_timezone_set('Europe/London');

$whois = new Joelvardy\Whois(__DIR__ . '/cache');
$certificate = new Joelvardy\Certificate(__DIR__ . '/cache');
$safeBrowsing = new Joelvardy\SafeBrowsing(__DIR__ . '/cache');
$email = new Joelvardy\Email();

$testResults = [];
foreach (\Joelvardy\Config::get('tests') as $test) {

    $testResults[$test->fqdn] = (object) [];

    // Whois expiry
    if (isset($test->expires) && $test->expires) {
        try {
            $whoisDetails = $whois->check($test->fqdn);
            $testResults[$test->fqdn]->domainExpiry = $whoisDetails->domain->expires;
        } catch (\Exception $e) {
            $testResults[$test->fqdn]->domainExpiry = 'Unable to test';
        }
    } else {
        $testResults[$test->fqdn]->domainExpiry = 'N/A';
    }

    // Certificate expiry
    if (isset($test->certificate) && $test->certificate) {
        try {
            $certificateDetails = $certificate->check($test->fqdn);
            $testResults[$test->fqdn]->certificateExpiry = $certificateDetails->domain->expires;
        } catch (\Exception $e) {
            $testResults[$test->fqdn]->certificateExpiry = 'Unable to test';
        }
    } else {
        $testResults[$test->fqdn]->certificateExpiry = 'N/A';
    }

    // Safe browsing lookup
    if (isset($test->safeBrowsing) && $test->safeBrowsing) {
        try {
            $safeBrowsingDetails = $safeBrowsing->check($test->fqdn);
            $testResults[$test->fqdn]->safeBrowsingResult = $safeBrowsingDetails->domain;
        } catch (\Exception $e) {
            $testResults[$test->fqdn]->safeBrowsingResult = 'Unable to test';
        }
    } else {
        $testResults[$test->fqdn]->safeBrowsingResult = 'N/A';
    }

}

$email->send('Domain Status', 'status.php', ['results' => $testResults]);
