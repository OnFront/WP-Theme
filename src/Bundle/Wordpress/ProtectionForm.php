<?php

namespace App\Bundle\Wordpress;

use App\Bundle\RegisterHookInterface;
use Timber\Timber;

class ProtectionForm implements RegisterHookInterface
{
    public function registerHook(): void
    {
        add_filter('the_password_form', [$this, 'form']);
    }

    public function form(): string
    {
        global $post;

        return Timber::fetch('components/password-form/password-form.twig', [
            'action' => esc_url(site_url('wp-login.php?action=postpass', 'login_post')),
            'id' => $post->ID,
        ]);
    }
}
