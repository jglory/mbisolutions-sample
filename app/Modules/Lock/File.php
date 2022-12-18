<?php


namespace App\Modules\Lock;


use Illuminate\Cache\Lock;
use Illuminate\Contracts\Cache\Lock as LockContract;
use Illuminate\Filesystem\Filesystem;



/**
 * Class File
 * @package App\Modules\Lock
 */
class File extends Lock implements LockContract
{
    /**
     * Filesystem 인스턴스
     *
     * @var Filesystem
     */
    protected $files;
    /**
     * 파일 캐시 경
     *
     * @var string
     */
    protected $path;
    /**
     * lock 파일 핸들
     *
     * @var resource
     */
    protected $handle;

    /**
     * @inheritdoc
     */
    public function forceRelease()
    {
        $this->release();
    }

    /**
     * 새로운 록 인스턴스를 생성한다.
     *
     * @param  Filesystem  $files
     * @param  string  $path
     * @param  int  $seconds
     * @return void
     */
    public function __construct(Filesystem $files, string $path, int $seconds)
    {
        $this->path = $path.'.lock';
        parent::__construct($this->path, $seconds);
        $this->files = $files;

        $this->ensureCacheDirectoryExists();
        $this->handle = fopen($this->path, 'w');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSeconds(): int
    {
        return $this->seconds;
    }

    /**
     * 필요하다면 파일 캐시 디렉토리를 생성한다.
     *
     * @return void
     */
    protected function ensureCacheDirectoryExists()
    {
        if (! $this->files->exists($this->path)) {
            $this->files->makeDirectory(dirname($this->path), 0777, true, true);
        }
    }

    /**
     * 록 설정을 시도한다.
     *
     * @return bool
     */
    public function acquire()
    {
        return flock($this->handle, LOCK_EX | LOCK_NB);
    }

    /**
     * 록 설정을 해제한다.
     *
     * @return void
     * @throws \RuntimeException
     */
    public function release()
    {
        if (empty($this->handle)) {
            return;
        }
        flock($this->handle, LOCK_UN);
    }
}
