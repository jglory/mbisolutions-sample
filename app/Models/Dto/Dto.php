<?php


namespace App\Models\Dto;


use Closure;
use JsonSerializable;

use App\Models\Util\HasAttributesTrait;
use App\Models\Util\HasAttributesInterface;



/**
 * DTO 베이스 클래스
 * Class Dto
 * @package App\Models\Dto
 */
abstract class Dto implements HasAttributesInterface, JsonSerializable
{
    use HasAttributesTrait;

    /**
     * Create a new Dto model instance.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        array_walk(
            $attributes,
            Closure::bind(
                function (&$value, $key) {
                    if (is_null($value)===false && array_key_exists($key, $this->attributes)) {
                        $this->attributes[$key] = $value;
                    }
                },
                $this
            )
        );
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    /**
     * 객체를 복제한다.
     */
    public function __clone()
    {
        foreach ($this->attributes as $key1 => &$val1) {
            if (is_array($val1)) {
                foreach ($val1 as $key2 => &$val2) {
                    if (is_object($val2)) {
                        $val1[$key2] = clone $val2;
                    }
                }
            } elseif (is_object($val1)) {
                $this->attributes[$key1] = clone $val1;
            }
        }
    }

    /**
     * @inheritDoc
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->getAttributes();
    }
}
