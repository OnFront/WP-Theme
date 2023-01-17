<?php

namespace App\Service\Email;

use Timber\Timber;

class EmailService
{
    private const EMAILS = [
        'sprzedaz@payeye.com',
        'kontakt@payeye.com',
    ];

    public function autoResponse(string $email): bool
    {
        $headers = array('Content-Type: text/html; charset=UTF-8');

        return wp_mail($email, 'Potwierdzenie wysłania zapytania.', Timber::compile('email/autoresponder.twig'), $headers);
    }

    public function eyePOSOrdered(string $url): bool
    {
        return wp_mail(self::EMAILS, 'Zamówienie eyePOS - strona WWW', 'W systemie LiveSpace pojawiło się nowe zgłoszenie: '.$url);
    }
}
