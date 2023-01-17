<?php


namespace App\Service;


use App;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\CacheItem;

class CacheService
{
    private FilesystemAdapter $filesystemAdapter;

    public function __construct()
    {
        $this->filesystemAdapter = new FilesystemAdapter('twig', 0, App::cachePath());
    }

    public function getFilesystemAdapter(): FilesystemAdapter
    {
        return $this->filesystemAdapter;
    }

    public function getItem(string $key): CacheItem
    {
        return $this->filesystemAdapter->getItem($key.App::getCacheVersion());
    }
}
