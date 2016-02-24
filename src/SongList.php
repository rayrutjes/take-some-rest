<?php

namespace RayRutjes\Tsr;

use RayRutjes\Tsr\Util\Arrayable;
use RayRutjes\Tsr\Util\InternalIterator;

final class SongList extends InternalIterator implements Arrayable
{
    /**
     * @param array $songs
     *
     * @return SongList
     */
    public static function fromArray(array $songs = []): SongList
    {
        foreach ($songs as $song) {
            if (!$song instanceof Song) {
                throw new \InvalidArgumentException(sprintf('Song expected, Got: %s', get_class($song)));
            }
        }

        return new self(new \ArrayIterator($songs));
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this as $song) {
            $result[] = $song->toArray();
        }

        return $result;
    }
}
