<?php

declare(strict_types=1);

namespace App\Bundle\Wordpress;

defined('ABSPATH') || exit;

use App;
use App\Bundle\Helper\HelperController;
use App\Bundle\TemplateRenderInterface;
use ReflectionClass;

class CustomTemplate
{
    private array $classes;

    public function __construct(array $classes)
    {
        $this->classes = $classes;
        add_filter('theme_page_templates', [$this, 'pageTemplates']);
        add_filter('template_include', [$this, 'templateInclude']);

        add_filter('wp_insert_post_data', [$this, 'register_project_templates']);
    }

    public function templateInclude($template): string
    {
        if (is_search() || is_404() || is_home()) {
            return $template;
        }

        global $post;

        if (!$post) {
            return $template;
        }

        $wpPage = get_post_meta($post->ID, '_wp_page_template', true);
        if (!$wpPage || $wpPage === 'default') {
            return $template;
        }

        $controller = HelperController::findNamespaceController($wpPage);

        $controller = App::getService($controller);

        if (method_exists($controller, 'view')) {
            echo $controller->view();
        } else {
            wp_die('Trzeba zaimplementować '.TemplateRenderInterface::class);
        }


        return '';
    }

    public function pageTemplates($posts_templates): array
    {
        $template = [];
        foreach ($this->classes as $class) {
            $class = (new ReflectionClass($class))->getFileName();

            $dirname = pathinfo($class);

            $template[$dirname['basename']] = $dirname['filename'];
        }

        return array_merge($posts_templates, $template);
    }

    public function register_project_templates(array $atts): array
    {
        $cache_key = 'page_templates-'.md5(get_theme_root().'/'.get_stylesheet());

        $templates = wp_get_theme()->get_page_templates();
        if (empty($templates)) {
            $templates = [];
        }

        wp_cache_delete($cache_key, 'themes');

        $templates = array_merge($templates, $this->classes);

        wp_cache_add($cache_key, $templates, 'themes', 1800);

        return $atts;
    }
}
