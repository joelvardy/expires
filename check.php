<?php

$domains = require(__DIR__ . '/config.php');

$whois = new Joelvardy\Whois(__DIR__ . '/cache');
$certificate = new Joelvardy\Certificate(__DIR__ . '/cache');

$table = new \cli\Table();
$table->setHeaders(['Domain', 'Domain Expiry', 'Certificate Expiry']);

$formatColour = function ($expires) {

    $oneMonth = new DateTime();
    $oneMonth->modify('+1 month');

    $oneWeek = new DateTime();
    $oneWeek->modify('+1 week');

    return ($expires < $oneWeek ? '%r' : ($expires < $oneMonth ? '%y' : '%g'));

};

print "Checking domains:\n";
Joelvardy\Progress::bar(1, count($domains));

foreach ($domains as $i => $domain) {

    if ($domainDetails = $whois->check($domain->domain)) {
        $domainExpiresText = $formatColour($domainDetails->domain->expires) . $domainDetails->domain->expires->format('jS F Y') . '%n';
    } else {
        $domainExpiresText = '%rUnable to load whois data%n';
    }

    if (isset($domain->certificate) && $domain->certificate) {
        if ($certificateDetails = $certificate->check($domain->domain)) {
            $certificateExpiresText = $formatColour($certificateDetails->domain->expires) . $certificateDetails->domain->expires->format('jS F Y') . '%n';
        } else {
            $certificateExpiresText = '%rUnable to load certificate data%n';
        }
    } else {
        $certificateExpiresText = 'N/A';
    }

    $table->addRow([$domain->domain, $domainExpiresText, $certificateExpiresText]);
    Joelvardy\Progress::bar(($i + 1), count($domains));

}

$table->display();
