<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\ORM;

use FastD\Database\Drivers\DriverInterface;
use FastD\Database\ORM\Params\Bind;
use FastD\Database\Query\QueryBuilder;

abstract class Model
{
    use Bind;
    
    const FIELDS = [];
    const ALIAS = [];
    const TABLE = '';

    /**
     * @var DriverInterface
     */
    protected $driver;

    /**
     * @var QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @param DriverInterface $driverInterface
     */
    public function __construct(DriverInterface $driverInterface)
    {
        $this->setDriver($driverInterface);
    }

    /**
     * @return DriverInterface
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface|null $driverInterface
     * @return $this
     */
    public function setDriver(DriverInterface $driverInterface)
    {
        $this->driver = $driverInterface;

        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->driver->getQueryBuilder();
    }

    /**
     * Return mapping database table full name.
     *
     * @return string
     */
    public function getTable()
    {
        return static::TABLE;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return static::FIELDS;
    }

    /**
     * @return array
     */
    public function getAlias()
    {
        return static::ALIAS;
    }

    /**
     * Fetch one row.
     *
     * @param array $where
     * @param array $field
     * @return array The found object.
     */
    public function find(array $where = [], array $field = [])
    {
        return $this
            ->createQuery(
                $this->queryBuilder
                    ->where($where)
                    ->fields(array() === $field ? $this->getAlias() : $field)
                    ->select()
            )
            ->execute()
            ->getOne()
            ;
    }

    /**
     * Fetch all rows.
     *
     * @param array $where
     * @param array|string $field
     * @return array The found object.
     */
    public function findAll(array $where = [], array $field = [])
    {
        return $this
            ->createQuery(
                $this->queryBuilder
                    ->where($where)
                    ->fields(array() === $field ? $this->getAlias() : $field)
                    ->select()
            )
            ->execute()
            ->getAll()
            ;
    }

    /**
     * Save row into table.
     *
     * @param array $data
     * @param array $where
     * @param array $params
     * @return bool|int
     */
    public function save(array $data = [], array $where = [], array $params = [])
    {
        if (empty($where)) {
            return $this
                ->createQuery(
                    $this->queryBuilder
                        ->insert(array() === $data ? $this->data : $data)
                )
                ->setParameter([] === $params ? $this->params : $params)
                ->execute()
                ->getId();
        }

        return $this
            ->createQuery(
                $this
                    ->queryBuilder
                    ->update(array() === $data ? $this->data : $data, $where)
            )
            ->setParameter([] === $params ? $this->params : $params)
            ->execute()
            ->getAffected()
            ;
    }

    /**
     * @param array $where
     * @return int|bool
     */
    public function count(array $where = [])
    {
        return (int) $this->where($where)->find(['count(1)' => 'total'])['total'];
    }

    /**
     * @param array $orderBy
     * @return $this
     */
    public function orderBy(array $orderBy)
    {
        $this->queryBuilder->orderBy($orderBy);

        return $this;
    }

    /**
     * @param array $where
     * @return $this
     */
    public function where(array $where = [])
    {
        $this->queryBuilder->where($where);

        return $this;
    }

    /**
     * @param $table
     * @param null $alias
     * @return $this
     */
    public function from($table, $alias = null)
    {
        $this->queryBuilder->from($table, $alias);

        return $this;
    }

    /**
     * @param null $limit
     * @param null $offset
     * @return $this
     */
    public function limit($limit = null, $offset = null)
    {
        $this->queryBuilder->limit($limit, $offset);

        return $this;
    }

    /**
     * @param string $sql
     * @return DriverInterface
     */
    public function createQuery($sql)
    {
        return $this->driver->query($sql);
    }

    /**
     * Return query errors.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->driver->getErrors();
    }

    /**
     * @return array
     */
    public function getLogs()
    {
        return $this->driver->getLogs();
    }
}