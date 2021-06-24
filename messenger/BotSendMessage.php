<?php

namespace Messenger;

class BotSendMessage
{
    private ?string $login = null;

    private ?string $message = null;

    /**
     * BotSendMessage constructor.
     * @param string|null $login
     * @param string|null $message
     */
    public function __construct(?string $login, ?string $message)
    {
        $this->login = $login;
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string|null $login
     * @return BotSendMessage
     */
    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return BotSendMessage
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }
}