<?php

namespace RayRutjes\Tsr;

use RayRutjes\Tsr\Util\Arrayable;

final class Song implements Arrayable
{
    /**
     * @var int
     */
    private $songId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $duration;

    /**
     * @param int    $songId
     * @param string $title
     * @param int    $duration
     */
    public function __construct(int $songId, string $title, int $duration)
    {
        $this->songId = $songId;
        $this->title = $title;
        $this->duration = $duration;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'song_id'  => $this->songId,
            'title'    => $this->title,
            'duration' => $this->duration,
        ];
    }

    /**
     * @param array $data
     *
     * @return Song
     */
    public static function fromArray(array $data): Song
    {
        return new self($data['song_id'], $data['title'], $data['duration']);
    }
}
