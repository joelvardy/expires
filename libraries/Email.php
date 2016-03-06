<?php

namespace Joelvardy;

class Email extends Cache
{

    protected $ses;

    function __construct()
    {
        $this->ses = new \SimpleEmailService(Config::get('amazonSesAccessKey'), Config::get('amazonSesSecretKey'), \SimpleEmailService::AWS_EU_WEST1);
    }

    protected function buildHtml($template, $data = [])
    {

        extract($data, EXTR_SKIP|EXTR_REFS);

        ob_start();
        require('email/'.$template);
        return ob_get_clean();

    }

    public function send($subject, $template, $data = [])
    {

        $email = new \SimpleEmailServiceMessage();
        $email->addTo(Config::get('emailTo'));
        $email->setFrom(Config::get('emailFrom'));
        $email->setSubject($subject);
        $email->addAttachmentFromFile('header.jpg','email/assets/header.jpg','application/octet-stream', '<header.jpg>' , 'inline');
        $email->setMessageFromString(null, $this->buildHtml($template, $data));

        return $this->ses->sendEmail($email);

    }

}
