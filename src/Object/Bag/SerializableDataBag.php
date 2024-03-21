<?php

namespace App\Object\Bag;

class SerializableDataBag extends DataBag implements \JsonSerializable
{
    /**
     * @return array<string, int|bool|string>
     */
    public function __serialize(): array
    {
        return $this->all();
    }

    /**
     * @param array<string, int|bool|string> $serialized
     */
    public function __unserialize(array $serialized): void
    {
        $this->data = $serialized;
    }

    /**
     * @return array<string, int|bool|string>
     */
    public function jsonSerialize(): array
    {
        return $this->all();
    }
}
