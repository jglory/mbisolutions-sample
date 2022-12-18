<?php


namespace App\Models\Repository;


use App\Models\Aggregate\Aggregate;



/**
 * 쓰기 리포지토리 인터페이스
 * Interface WriterInterface
 * @package App\Models\Repositories
 */
interface WriterInterface
{
    /**
     * 데이터를 저장한다.
     * @param Aggregate|Aggregate[] $data
     */
    public function save($data);

    /**
     * 데이터를 삭제한다.
     * @param Aggregate|Aggregate[] $data
     */
    public function delete($data);
}
