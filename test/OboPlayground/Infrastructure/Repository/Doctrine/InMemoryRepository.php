<?php

namespace OboPlayground\Infrastructure\Repository\Doctrine;

use Doctrine\Common\Persistence\ObjectRepository;

class InMemoryRepository implements ObjectRepository
{
    public static $data = [];

    public static function reset(): void
    {
        self::$data = [];
    }

    public function find($id)
    {
        return self::$data[(string) $id] ?? null;
    }

    public function findAll()
    {
        return self::$data;
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return self::$data[0] ?? null;
    }

    public function findOneBy(array $criteria)
    {
        return self::$data[0] ?? null;
    }

    public function getClassName()
    {
        return 'ClassName';
    }

}