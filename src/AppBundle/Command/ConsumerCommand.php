<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:consume')
            ->setDescription('Consume ')
            ->setHelp(
                <<<EOF
                The <info>app:consume</info> command attempts to process messages.
EOF
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('rabbitmq:consumer');

        $arguments = array(
            'command' => 'rabbitmq:consumer',
            'name' => 'random',
            '--route' => 'random',
//            '--messages' => '50',
        );

        $input = new ArrayInput($arguments);

        $output = $command->run($input, $output);

        return $output;
    }
}
