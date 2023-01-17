<?php


namespace App\Bundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Timber\Post;


class CreateElasticComponentCommand extends Command
{
    protected static $defaultName = 'app:create-elastic-component';
    private string $prefix = 'el_';

    protected function configure(): void
    {
        $this
            ->setDescription('Create a elastic component.')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the component.'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $filesystem = new Filesystem();
        $name = $input->getArgument('name');

        $controller = $name . 'Component';
        $template = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));

        $filesystem->dumpFile(
            'src/Layout/' . $controller . '.php',
            '<?php

declare(strict_types=1);       
        
namespace App\Layout;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use App\Bundle\RenderComponentInterface;
use Timber\Post;

class ' . $controller . ' extends AbstractController implements RenderComponentInterface
{
    private array $context;
    private Post $post;
    
    public function __construct(Post $post, array $context = [])
    {
        $this->context = $context;
        $this->post = $post;
    }
    
    public function createView(): string
    {
        $context = $this->context;
        $context[\'post\'] = $this->post;
    
        return $this->render(\'elastic_layout/el_' . $template . '.twig\', $context);
    }
}'
        );

        $className = str_replace('_', '-', $this->prefix . $template);

        $filesystem->dumpFile(
            'templates/elastic_layout/' . $this->prefix . $template . '.twig',
            '<div class="' . $className . '" data-module="'.$className.'">
    {{ dump(acf) }}
</div>
'
        );

        $output->writeln('Created component: ' . $controller);

        return Command::SUCCESS;
    }
}
