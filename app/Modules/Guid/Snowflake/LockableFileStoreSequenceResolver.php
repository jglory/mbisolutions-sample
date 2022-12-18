<?php


namespace App\Modules\Guid\Snowflake;


use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

use Godruoyi\Snowflake\SequenceResolver;

use App\Modules\Cache\LockableFileStore;
use App\Modules\Lock\File as FileLock;



/**
 * Class LockableFileStoreSequenceResolver
 * @package App\Modules\Guid\Snowflake
 */
class LockableFileStoreSequenceResolver implements SequenceResolver
{
    /**
     * The laravel cache instance.
     *
     * @var LockableFileStore
     */
    protected $cache;

    /**
     * 캐시 이름
     *
     * @var string
     */
    protected $key;

    /**
     * 록 타임아웃 초
     * @var int
     */
    protected $seconds;

    /**
     * Init resolve instance, must connectioned.
     *
     * @param CacheRepository $cache
     * @param string $key
     */
    public function __construct(CacheRepository $cache, string $key)
    {
        if ($cache->getStore() instanceof LockableFileStore==false) {
            throw new \UnexpectedValueException('비정상적인 입력. 지원하지 않는 cache 타입입니다.');
        }
        $this->cache = $cache;
        $this->key = $key;
        $this->seconds = config('guid.lock.seconds');
    }

    /**
     *  {@inheritdoc}
     */
    public function sequence(int $currentTime)
    {
        $cache = $this->cache;
        $key = $this->key;
        $seconds = $this->seconds;

        return $cache->lock($key, $seconds)
            ->block(
                $seconds,
                function () use ($cache, $key, $currentTime) {
                    $data = $cache->get($key);
                    if (is_null($data)) {
                        $cache->forever($key, [$currentTime, 0]);
                        return 0;
                    }
                    if ($data[0]>$currentTime) {
                        // 스레드 간 경쟁에서 더 최근 시각을 가진 애가 먼저 진입 했을 때 발생할 수 있다?
                        // ($data[0], $currentTime) => (1636108369367, 1636101659191) 이런 경우도 있었음
                        // 차이가 너무 많이 난다. 캐시를 지우고 새롭게 값을 세팅하도록 방어코드
                        // 현재 시각을 기준으로 하는 guid 발급에서 캐시에 저장되어 있는 값이 비정상적인 값이고 현재 일시보다 클 경우 시각을 맞추기 위해 시간 차이만큼 무한 반복하는 오류
                        $cache->forget($key);
                        return 4096;
                    }
                    $newSequence = $data[0]==$currentTime ? $data[1]+1 : 0;
                    $cache->forever($key, [$currentTime, $newSequence]);
                    return $newSequence;
                }
            );
    }
}