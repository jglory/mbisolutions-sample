<?php


namespace App\Models\Repository;


use App\Models\Aggregate\Aggregate;
use App\Models\Entity\Entity;


/**
 * 쓰기 리포지토리 클래스
 * Class Writer
 * @package App\Models\Repositories
 */
abstract class Writer implements WriterInterface
{
    /**
     * 스키마 정보를 돌려준다.
     * @return array
     *
     * 스키마 정보
     * [
     *      Entity::class => EloquentClass,
     * ]
     */
    abstract public static function getSchema(): array;

    /**
     * 애그리거트를 저장한다.
     * @param Aggregate $agg
     * @return mixed
     */
    abstract protected function saveAggregate(Aggregate $agg);

    /**
     * 애그리거트를 삭제한다.
     * @param Aggregate $agg
     * @return mixed
     */
    abstract protected function deleteAggregate(Aggregate $agg);

    /**
     * 엔티티를 저장한다.
     * @param Entity $entity
     */
    protected function saveEntity(Entity $entity)
    {
        $schema = static::getSchema();

        $persistenceState = $entity->getPersistenceState();
        $eloquentClass = $schema[get_class($entity)];
        if ($persistenceState===true) {
            return;
        }

        if ($persistenceState===false) {
            $eloq = $eloquentClass::find($entity->getKey());
        } else {
            $eloq = new $eloquentClass();
        }
        $dto = $entity->getDto();
        foreach ($eloq->getAttributes() as $key => $val) {
            $eloq->$key = $dto->$key;
        }
        $eloq->save();
    }

    /**
     * 엔티티를 삭제한다.
     * @param Entity $entity
     */
    protected function deleteEntity(Entity $entity)
    {
        $schema = static::getSchema();

        $persistenceState = $entity->getPersistenceState();
        $eloquentClass = $schema[get_class($entity)];
        if (is_null($persistenceState)) {
            return;
        }

        $eloquentClass::destroy($entity->getKey());
    }


    /**
     * @inheritdoc
     * @param Aggregate|Aggregate[] $data
     */
    public function save($data)
    {
        if (is_object($data)) {
            $data = [$data];
        }
        foreach ($data as $agg) {
            $this->saveAggregate($agg);
        }
    }

    /**
     * @inheritDoc
     * @param Aggregate|Aggregate[] $data
     */
    public function delete($data)
    {
        if (is_object($data)) {
            $data = [$data];
        }
        foreach ($data as $agg) {
            $this->deleteAggregate($agg);
        }
    }
}
