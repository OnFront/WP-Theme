<?php


namespace App\Bundle\CF7;


use App;
use App\Bundle\RegisterHookInterface;

final class NipFieldCF7 implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_filter('wpcf7_validate_text', [$this, 'validation_nip'], 999, 2);
        add_filter('wpcf7_validate_text*', [$this, 'validation_nip'], 999, 2);

        add_filter('wpcf7_messages', [$this, 'message']);
    }

    public function validation_nip($result, $tag)
    {
        $type = $tag['type'];
        $name = $tag['name'];

        if ($name === 'your-nip') {
            $nip = $_POST[$name];

            if (!$this->validateNip($nip)) {
                $result['valid'] = false;
                $result->invalidate($tag, wpcf7_get_message('invalid_nip'));
            }
        }

        return $result;
    }

    public function message($messages): array
    {
        return array_merge(
            $messages,
            array(
                'invalid_nip' => [
                    'description' => 'NIP jest niepoprawny',
                    'default' => 'NIP nieprawidłowy. Wpisz polski numer NIP bez spacji i myślników.',
                ]
            )
        );
    }

    private function validateNip($nip): bool
    {
        $reg = '/^\d{10}$/';

        if (!preg_match($reg, $nip)) {
            return false;
        }

        $digits = str_split($nip);
        $checksum = (6 * (int)$digits[0] + 5 * (int)$digits[1] + 7 * (int)$digits[2] + 2 * (int)$digits[3] + 3 * (int)$digits[4] + 4 * (int)$digits[5] + 5 * (int)$digits[6] + 6 * (int)$digits[7] + 7 * (int)$digits[8]) % 11;

        return (int)$digits[9] === $checksum;
    }
}
