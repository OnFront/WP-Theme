<?php

declare(strict_types=1);

namespace App\Form;

defined('ABSPATH') || exit;

use App;
use App\Bundle\RegisterHookInterface;
use WPCF7_ContactForm;
use WPCF7_FormTag;
use WPCF7_Validation;

class ContactForm implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_filter("wpcf7_validate", [$this, 'validate'], 10, 2);
    }

    /**
     * @param WPCF7_Validation $result
     * @param WPCF7_FormTag[] $tags
     * @return WPCF7_Validation
     */
    public function validate(WPCF7_Validation $result, array $tags): WPCF7_Validation
    {
        $message = $_POST['your-message'] ?? '';
        $subject = $_POST['subject'] ?? '';

        $id = $_POST['_wpcf7'] ?? '';

        if ($id === '5') {
            $invalidMessage = 'Wymagane jest wypełnienie tego pola.';
            $subjectText = 'zgłoszenie serwisowe';
        } else {
            $invalidMessage = 'This field is required to be completed.';
            $subjectText = 'service request';
        }

        if ($subject === $subjectText && !$message) {
            foreach ($tags as $tag) {
                if ($tag->name === 'your-message') {
                    $result->invalidate($tag, $invalidMessage);
                }
            }
        }

        if ($id === '5') {
            $invalidMessage = 'Zgoda na przetwarzanie danych w celach marketingowych i handlowych jest konieczna w przypadku wyboru jednej ze zgód na marketingowy i handlowy kontakt albo drogą telefoniczną albo drogą mailową/SMSową.';
        } else {
            $invalidMessage = 'Consent to the processing of data for marketing and commercial is necessary if one of the consents for marketing and commercial contact is selected or by phone or by e-mail / SMS.';
        }

        $acceptanceNr2 = $_POST['acceptance-nr-2'] ?? '';
        $acceptanceNr3 = $_POST['acceptance-nr-3'] ?? '';
        $acceptanceNr4 = $_POST['acceptance-nr-4'] ?? '';

        if (($acceptanceNr3 || $acceptanceNr4) && !$acceptanceNr2) {
            foreach ($tags as $tag) {
                if ($tag->name === 'acceptance-nr-2') {
                    $result->invalidate($tag, $invalidMessage);
                }
            }
        }

        return $result;
    }
}
