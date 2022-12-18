<?php


namespace App\Modules\Guid\Snowflake;


use Godruoyi\Snowflake\Snowflake as SnowflakeBase;



/**
 * Class Snowflake
 * @package App\Modules\Guid\Snowflake
 */
class Snowflake extends SnowflakeBase
{
    /**
     * @inheritdoc
     * @return int
     */
    public function id()
    {
        return (int)parent::id();
    }
}