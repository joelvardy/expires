<?php

require(__DIR__ . '/vendor/autoload.php');

date_default_timezone_set('Europe/London');

// Array of domains to check
return [
    (object) [
        'domain' => 'shouldwatch.co.uk'
    ],
    (object) [
        'domain' => 'request.mx'
    ],
    (object) [
        'domain' => 'joelvardy.co.uk'
    ],
    (object) [
        'domain' => 'highland-webcams.com',
        'certificate' => true
    ],
    (object) [
        'domain' => 'notes.mx',
        'certificate' => true
    ],
    (object) [
        'domain' => 'trail.sx',
        'certificate' => true
    ],
    (object) [
        'domain' => 'vardy.co'
    ],
    (object) [
        'domain' => 'joelvardy.uk'
    ],
    (object) [
        'domain' => 'joelvardy.com',
        'certificate' => true
    ],
    (object) [
        'domain' => 'demo.joelvardy.com',
        'certificate' => true
    ],
    (object) [
        'domain' => 'photos.joelvardy.com',
        'certificate' => true
    ],
    (object) [
        'domain' => 'joelgonewild.com',
        'certificate' => true
    ]
];
