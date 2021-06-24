<?php

use Messenger\BotSendMessage;
use App\Handler\BotSendMessageHandler;
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
        BotSendMessage::class => [
            BotSendMessageHandler::class,
        ],
    ],
    'queues' => [
        'parser' => env('BOT_MESSENGER_TRANSPORT_DSN'),
    ],
];