<?php

namespace App;
use Mailgun\Mailgun;
use App\Config;

class Mail
{
    public static function send($to, $subject, $text, $html)
    {
        $mgClient = Mailgun::create(Config::MAILGUN_API_KEY);
        $domain = Config::MAILGUN_DOMAIN;
        # Make the call to the client.
        $result = $mgClient->messages()->send($domain, array(
            'from'	=> 'your-sender@example.com',
            'to'	=> $to,
            'subject' => $subject,
            'text'	=> $text,
            'html' => $html
        ));
    }
}

