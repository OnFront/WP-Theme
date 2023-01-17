<?php

declare(strict_types=1);

namespace App\Bundle\Wordpress;

defined('ABSPATH') || exit;

use App;
use App\Bundle\RenderComponentInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use Timber\Post;

class ElasticLayout
{
    private string $view = '';
    private Post $post;
    private string $prefix = 'el_';
    private string $className = 'section';
    private string $elasticLayout = 'layout';

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function createView(): void
    {
        $components = $this->autoLoadClassFromDirectory(App::srcPath() . '/Layout/');
        $layouts = $this->post->meta($this->elasticLayout) ?? [];

        if ($layouts) {
            $layouts = $this->loadOnlyTheComponentYouNeed($layouts, $components);

            foreach ($layouts as $layout) {
                $component = $this->createComponent(
                    $layout['component'],
                    [
                        'acf' => $layout['acf'],
                    ]
                );
                $this->view .= '<div class="' . $this->className . '">' . $component->createView() . '</div>';
            }
        }
    }

    public function __toString(): string
    {
        return $this->view;
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function setClassName(string $className): self
    {
        $this->className = $className;
        return $this;
    }

    public function setElasticLayout(string $elasticLayout): self
    {
        $this->elasticLayout = $elasticLayout;
        return $this;
    }

    private function createComponent(string $component, array $context = []): RenderComponentInterface
    {
        return new $component($this->post, $context);
    }

    private function autoLoadClassFromDirectory(string $path): array
    {
        $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $phpFiles = new RegexIterator($allFiles, '/\.php$/');
        $components = [];

        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);

            $namespace = '';
            for ($index = 0; isset($tokens[$index]); $index++) {
                if (!isset($tokens[$index][0])) {
                    continue;
                }
                if (T_NAMESPACE === $tokens[$index][0]) {
                    $index += 2;
                    while (isset($tokens[$index]) && is_array($tokens[$index])) {
                        $namespace .= $tokens[$index++][1];
                    }
                }
                if (T_CLASS === $tokens[$index][0] && T_WHITESPACE === $tokens[$index + 1][0] && T_STRING === $tokens[$index + 2][0]) {
                    $index += 2;
                    $components[] = $namespace . '\\' . $tokens[$index][1];

                    break;
                }
            }
        }

        return $components;
    }

    private function loadOnlyTheComponentYouNeed(array $layouts, array $components): array
    {
        $loadComponents = [];
        foreach ($layouts as $layout) {
            $name = $layout['acf_fc_layout'];

            foreach ($components as $component) {
                $twig = $this->twig($component);
                if ($name === $twig) {
                    $loadComponents[] = [
                        'component' => $component,
                        'acf' => $layout,
                    ];
                }
            }
        }

        return $loadComponents;
    }

    private function twig(string $component): string
    {
        $name = $component;
        $name = str_replace(['App\Layout\\', 'Component'], '', $name);
        return $this->prefix . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
    }
}
