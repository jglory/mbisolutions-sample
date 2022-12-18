<?php

namespace App\Providers;

use App\Modules\Guid\Snowflake\LockableFileStoreSequenceResolver;
use App\Modules\Lock\File as FileLock;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // 서비스 별 GUID 환경변수 자동설정
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        if (App::environment('local')===false) {
            if (is_null(env('GUID_MACHINE_ID'))) {
                $toks = explode('-', str_replace("\n", "", shell_exec('hostname')));
                $path = '/var/www/html/.env';

                $fs = app()->make(Filesystem::class);
                $fl = new FileLock($fs, $path, 3);

                $fl->block(3);
                try {
                    if (strpos($fs->get($path), 'GUID_MACHINE_ID=')===false) {
                        $fs->append($path, PHP_EOL);
                        switch ($toks[0]) {
                            case 'web':
                                $fs->append($path, 'GUID_DATA_CENTER_ID=0'.PHP_EOL);
                                break;
                            case 'scheduler':
                                $fs->append($path, 'GUID_DATA_CENTER_ID=1'.PHP_EOL);
                                break;
                            case 'worker':
                                $fs->append($path, 'GUID_DATA_CENTER_ID=2'.PHP_EOL);
                                break;
                        }
                        $fs->append($path, 'GUID_MACHINE_ID='.$toks[1].PHP_EOL.PHP_EOL);
                    }
                } finally {
                    $fl->release();
                }
            }
        }

        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // ID 발급기
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        $this->app->singleton(
            'snowflake',
            function ($app) {
                return new Snowflake(config('guid.seeds.data-center'), config('guid.seeds.machine'));
            }
        );

        $this->app->singleton(
            'guid',
            function ($app, $params) {
                return $app->make('snowflake')
                    ->setSequenceResolver(new LockableFileStoreSequenceResolver(Cache::store('lockable-file'), 'guid-'.(empty($params) ? '0' : $params[0])));
            }
        );


        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        // 맵퍼
        // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        $this->app->singleton('mapper.dto', function ($app) {
            return new \App\Models\Mapper\Dto();
        });

        $this->app->singleton('mapper.eloquent', function ($app) {
            return new \App\Models\Mapper\Eloquent();
        });

    }
}
