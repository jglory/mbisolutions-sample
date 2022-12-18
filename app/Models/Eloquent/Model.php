<?php


namespace App\Models\Eloquent;


use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Database\Eloquent\Model as ModelBase;
use Illuminate\Support\Facades\Crypt;

use Closure;



/**
 * 엘로퀀트 모델 베이스 클래스
 * Class Model
 * @package App\Models\Eloquent
 */
abstract class Model extends ModelBase
{
    /**
     * 관련 테이블 이름을 돌려준다.
     * return string
     */
    public static function getTableName(): string
    {
        static $name;
        if (is_null($name)) {
            $name = (new static())->getTable();
        }
        return $name;
    }

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * 암호화 필드 리스트
     */
    public $encrypteds = [];

    /** @var Encrypter */
    protected $encrypter;

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->timestamps = false;
        $this->encrypter = Crypt::encrypter();
    }

    /**
     * 암호화 적용 필드 목록을 돌려준다.
     *
     * @return array
     */
    public function getEncrypteds()
    {
        return $this->encrypteds;
    }

    /**
     * 암호호된 필드 값을 복호화하여 돌려준다.
     *
     * @param  string $value
     * @return string
     */
    protected function asDecrypted(string $value)
    {
        return $this->encrypter->decrypt($value);
    }

    /**
     * 평문 값을 암호화하여 돌려준다.
     *
     * @param  string  $value
     * @return string
     */
    protected function asEncrypted(string $value)
    {
        return $this->encrypter->encrypt($value);
    }

    /**
     * Get an attribute from the $attributes array.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function getAttributeFromArray($key)
    {
        if (isset($this->attributes[$key])) {
            $value = $this->attributes[$key];

            if (in_array($key, $this->getEncrypteds()) &&
                ! is_null($value)) {
                return $this->asDecrypted($value);
            }

            return $value;
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        parent::setAttribute($key, $value);
        if (isset($this->attributes[$key]) && is_null($this->attributes[$key])===false && in_array($key, $this->getEncrypteds())) {
            $this->attributes[$key] = $this->asEncrypted($this->attributes[$key]);
        }
        return $this;
    }

    /**
     * Get an attribute array of all arrayable values.
     *
     * @param  array  $values
     * @return array
     */
    protected function getArrayableItems(array $values)
    {
        $values = parent::getArrayableItems($values);
        array_walk(
            $values,
            Closure::bind(
                function (&$value, $key) {
                    if (is_null($value)===false && in_array($key, $this->encrypteds)) {
                        $value = $this->encrypter->decrypt($value);
                    }
                },
                $this
            )
        );
        return $values;
    }

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributeNames(): array
    {
        return array_keys($this->attributes);
    }
}
