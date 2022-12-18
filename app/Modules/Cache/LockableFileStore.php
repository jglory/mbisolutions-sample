<?php

namespace App\Modules\Cache;


use Illuminate\Cache\FileStore;
use Illuminate\Contracts\Cache\Lock as LockContract;
use App\Modules\Lock\File as FileLock;

/**
 * Class LockableFileStore
 * @package App\Modules\Cache
 */
class LockableFileStore extends FileStore
{
    /**
     * Get a lock instance.
     *
     * @param  string  $key
     * @param  int  $seconds
     * @return LockContract
     */
    public function lock(string $key, int $seconds = 0)
    {
        static $locks = [];
        if (isset($locks[$key])===false) {
            $locks[$key] = new FileLock($this->files, $this->path($key), $seconds);
        }
        return $locks[$key];
    }
}