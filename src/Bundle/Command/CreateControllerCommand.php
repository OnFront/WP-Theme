<?php


namespace App\Bundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Timber\Post;


class CreateControllerCommand extends Command
{
    protected static $defaultName = 'app:create-controller';

    protected function configure(): void
    {
        $this
            ->setDescription('Create a controller.')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'The name of the controller.'
            );
    }

    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ): int {
        $filesystem = new Filesystem();
        $name = $input->getArgument('name');

        $controller = $name . 'Controller';
        $template = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $name));
        $controllerFileName = 'src/Controller/' . $controller . '.php';

        $filesystem->dumpFile(
            $controllerFileName,
            '<?php

declare(strict_types=1);
        
namespace App\Controller;

defined("ABSPATH") || exit;

use App\Bundle\Framework\AbstractController;
use Timber\Post;

class ' . $controller . ' extends AbstractController
{
    public function view(): string
    {
        $post = new Post();
    
        $context = $this->context();
        $context[\'post\'] = $post;

        return $this->render(\'pages/' . $template . '/' . $template . '.twig\', $context);
    }
}'
        );
        $templateFileName = 'templates/pages/' . $template . '/' . $template . '.twig';
        $filesystem->dumpFile(
            $templateFileName,
            '{% extends "base.twig" %}

{% block container %}
    <div class="container">
        This is a ' . $controller . '
    </div>
{% endblock %}'
        );

        $output->writeln('Created controller: ' . $controller);
        $output->writeln($controllerFileName);
        $output->writeln($templateFileName);

        return Command::SUCCESS;
    }
}
