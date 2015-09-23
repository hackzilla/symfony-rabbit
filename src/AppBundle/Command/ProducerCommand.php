<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProducerCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:produce')
            ->setDescription('Produce messages')
            ->setHelp(
                <<<EOF
                The <info>app:produce</info> command creates random messages.
EOF
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $producer = $this->getContainer()->get('old_sound_rabbit_mq.random_producer');
        $id = 0;

        while (true) {
            $data = [
                'date' => date('Y-m-d'),
                'id' => ++$id,
            ];

            $producer->publish(json_encode($data), 'random');
            echo '.';

            sleep (1);
        }
    }
}
