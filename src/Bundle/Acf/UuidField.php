<?php

declare(strict_types=1);

namespace App\Bundle\Acf;

use acf_field;

defined('ABSPATH') || exit;

final class UuidField extends acf_field
{
    public function __construct()
    {
        $this->name = 'unique_id';
        $this->label = 'Unique ID';

        /*
        *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
        */
        $this->category = 'layout';


        /*
        *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
        *  var message = acf._e('unique_id', 'error');
        */

        $this->l10n = array();

        parent::__construct();
    }

    public function render_field($field): void
    {
        ?>
        <input type="text" readonly="readonly" name="<?php
        echo esc_attr($field['name']) ?>" value="<?php
        echo esc_attr($field['value']) ?>"/>
        <?php
    }

    public function update_value($value, $post_id, $field)
    {
        if (!$value) {
            $value = wp_generate_uuid4();
        }
        return $value;
    }

    public function validate_value($valid, $value, $field, $input): bool
    {
        if (!$value) {
            return true;
        }

        return wp_is_uuid($value);
    }
}
