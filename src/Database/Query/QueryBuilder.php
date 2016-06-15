<?php
/**
 *
 * @author    jan huang <bboyjanhuang@gmail.com>
 * @copyright 2016
 *
 * @link      https://www.github.com/janhuang
 * @link      http://www.fast-d.cn/
 */

namespace FastD\Database\Query;

/**
 * Class QueryBuilder
 *
 * @package FastD\Database\Query
 */
abstract class QueryBuilder
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $where;

    /**
     * @var string
     */
    protected $fields = '*';

    /**
     * @var string
     */
    protected $limit;

    /**
     * @var string
     */
    protected $join;

    /**
     * @var string
     */
    protected $group;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var string
     */
    protected $like;

    /**
     * @var string
     */
    protected $not_like;

    /**
     * @var string
     */
    protected $having;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $keys;

    /**
     * @var string
     */
    protected $sql;

    /**
     * @var array
     */
    protected $logs = [];

    /**
     * @const int
     */
    const BUILDER_INSERT = 1;

    /**
     * @const int
     */
    const BUILDER_UPDATE = 2;

    /**
     * @const int
     */
    const BUILDER_DELETE = 3;

    /**
     * @var QueryBuilder
     */
    protected static $instance;

    /**
     * @return QueryBuilder
     */
    public static function singleton()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Query select where condition.
     *
     * @param array $where
     * @return $this
     */
    abstract public function where(array $where);

    /**
     * Query fields.
     *
     * @param array $field
     * @return $this
     */
    abstract public function fields(array $field);

    /**
     * Select join.
     *
     * @param        $table
     * @param        $on
     * @param string $type
     * @return $this
     */
    abstract public function join($table, $on, $type = 'LEFT');

    /**
     * Select to table name.
     *
     * @param $table
     * @param $alias
     * @return $this
     */
    abstract public function from($table, $alias = null);

    /**
     * @param $limit
     * @param $offset
     * @return $this
     */
    abstract public function limit($limit, $offset = 0);

    /**
     * @param array $groupBy
     * @return $this
     */
    abstract public function groupBy(array $groupBy);

    /**
     * @param array $orderBy
     * @return $this
     */
    abstract public function orderBy(array $orderBy);

    /**
     * @param array $having
     * @return $this
     */
    abstract public function having(array $having);

    /**
     * @param array $like
     * @return $this
     */
    abstract public function like(array $like);

    /**
     * @param array $like
     * @return $this
     */
    abstract public function notLike(array $like);

    /**
     * @param array $fields
     * @return $this
     */
    abstract public function select(array $fields = []);

    /**
     * @param array $data
     * @param array $where
     * @return $this
     */
    abstract public function update(array $data, array $where = []);

    /**
     * @param array $data
     * @return $this
     */
    abstract public function insert(array $data);

    /**
     * @return string
     */
    abstract public function getSql();

    /**
     * @return array
     */
    abstract public function getLogs();
}