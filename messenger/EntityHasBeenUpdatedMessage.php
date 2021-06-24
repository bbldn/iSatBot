<?php

namespace Messenger;

abstract class EntityHasBeenUpdatedMessage
{
    private ?int $id = null;

    /**
     * EntityHasBeenUpdatedMessage constructor.
     * @param int|null $id
     */
    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return EntityHasBeenUpdatedMessage
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}