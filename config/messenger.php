<?php

use Messenger\OrderBackHasBeenCreatedMessage;
use Messenger\OrderFrontHasBeenCreatedMessage;
use App\Handler\OrderBackHasBeenCreatedMessageHandler;
use App\Handler\OrderFrontHasBeenCreatedMessageHandler;
use BBLDN\Laravel\Messenger\Serializers\TransportJsonSerializer;
use Symfony\Component\Messenger\Bridge\Redis\Transport\Connection;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisSender;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;
use Symfony\Component\Messenger\Bridge\Redis\Transport\RedisReceiver;

return [
    'serializer' => TransportJsonSerializer::class,
    'sender' => fn(string $queue, Serializer $serializer) => new RedisSender(Connection::fromDsn($queue), $serializer),
    'receiver' => fn(string $queue, Serializer $serializer) => new RedisReceiver(Connection::fromDsn($queue), $serializer),

    'handlers' => [
        OrderBackHasBeenCreatedMessage::class => [OrderBackHasBeenCreatedMessageHandler::class],
        OrderFrontHasBeenCreatedMessage::class => [OrderFrontHasBeenCreatedMessageHandler::class],
    ],
    'queues' => [
        'failed' => env('FAILED_MESSENGER_TRANSPORT_DSN'),
        'synchronizer_ua' => env('SYNCHRONIZER_UA_MESSENGER_TRANSPORT_DSN'),
    ],
];