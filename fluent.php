<?php

class Collection
{
    protected $items;

    public function __construct(array $items)
    {
        $this->items = $items;
    }

    public function filter($callback): Collection
    {
        $result = array_filter($this->items, $callback);
        return new self($result);
    }

    public function map($callback): Collection
    {
        $result = array_map($callback, $this->items);
        return new self($result);
    }

    public function sort($callback): Collection
    {
        $items = $this->items;
        usort($items, $callback);
        return new self($items);
    }

    public function slice($offsetsCallback)
    {
        [$offset, $length] = $offsetsCallback($this->items);
        $items = array_slice($this->items, $offset, $length);
        return new self($items);
    }

    public function first()
    {
        return reset($this->items);
    }

    public function toArray()
    {
        return $this->items;
    }
}

$result = (new Collection(scandir('/srv/www')))
    ->filter(function ($fileName) {
        return strpos($fileName, '.') !== 0;
    })
    ->sort(function ($a, $b) {
        return $a <=> $b;
    })->slice(function ($fileNames) {
        $offset = 0;
        $middleIndex = (int) round(count($fileNames) / 2) + 1;
        $length = $middleIndex;

        return [$offset, $length];
    })->slice(function ($fileNames) {
        $last_from_the_end = -1;
        $length = null;
        return [$last_from_the_end, $length];
    })
    ->map(function ($fileName) {
        $uppercaseFileName = strtoupper($fileName);
        $endsWithS = strpos($uppercaseFileName, 'S') === 0;
        return $endsWithS ? $uppercaseFileName : "{$uppercaseFileName}S";
    })
    ->first();

echo $result . PHP_EOL;
