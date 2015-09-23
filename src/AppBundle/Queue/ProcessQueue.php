<?php

namespace AppBundle\Queue;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\DependencyInjection\ContainerAware;

class ProcessQueue extends ContainerAware implements ConsumerInterface
{
    /**
     * Handle RabbitMQ message
     *
     * @param AMQPMessage $msg
     *
     * @return bool
     */
    public function execute(AMQPMessage $msg)
    {
        $object = json_decode($msg->body);
        $random = mt_rand(0, 12);

        echo $object->date . ': ' . $object->id . PHP_EOL;

        switch (true) {
            case $random < 5:
                echo '  - ACK' . PHP_EOL;
                return ConsumerInterface::MSG_ACK;

//            case $random < 7:
//                echo "I'm a potato".PHP_EOL;
//                posix_kill(posix_getpid(), SIGTERM);
//                break;

            case $random < 9:
                echo '  - REJECT' . PHP_EOL;
                return ConsumerInterface::MSG_REJECT;

            default:
                echo '  - NACK_REQUEUE' . PHP_EOL;
                return ConsumerInterface::MSG_SINGLE_NACK_REQUEUE;
        }

        echo '  - ACK' . PHP_EOL;
        return ConsumerInterface::MSG_ACK;
    }
}
