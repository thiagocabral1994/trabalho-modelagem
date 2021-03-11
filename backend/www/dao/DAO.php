<?php

namespace Modelagem\DAO;

use Modelagem\Model\Model;

abstract class DAO
{
    private static \PDO $default_connection;
    private \PDO $pdo;
    private string $table;
    private string $class;
    private string $insertSql;
    private string $updateSql;

    protected abstract function bindParam(\PDOStatement $stmt, Model $obj);

    public static function createConnection(): \PDO
    {
        if (!isset($default_connection)) {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            $dsn = "mysql:host=$host;dbname=$name;port=$port;charset=utf8";

            $opts = [
                \PDO::ATTR_PERSISTENT => true,
                \PDO::ATTR_EMULATE_PREPARES   => false,
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ];
            self::$default_connection = new \PDO($dsn, $user, $pass, $opts);
        }
        return self::$default_connection;
    }

    private static function getClassFromTable(string $table): string
    {
        $table = str_replace('_', ' ', $table);
        $table = ucwords($table);
        return str_replace(' ', '', $table);
    }
    
    protected function __construct(string $table, string $insertSql, string $updateSql, \PDO $pdo = null)
    {
        $this->pdo = isset($pdo) ? $pdo : DAO::createConnection();
        $this->table = $table;
        $class = self::getClassFromTable($table);
        $this->class = '\\Modelagem\\Model\\' . $class;
        $this->insertSql = $insertSql;
        $this->updateSql = $updateSql;
    }

    public final function getPDO(): \PDO
    {
        return $this->pdo;
    }

    protected final function fetch(string $statement, callable $bind = null): array
    {
        $stmt = $this->pdo->prepare($statement);
        if (isset($bind)) {
            $bind($stmt);
        }
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public final function exists(int $id): bool
    {
        $stmt = $this->getPDO()->prepare(
            "SELECT COUNT(1) FROM {$this->table} WHERE id = :id;"
        );
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $quantidade = $stmt->fetchColumn();
        return ($quantidade !== 0);
    }


    public function list(): array
    {
        return $this->fetch(
            "SELECT * FROM {$this->table};"
        );
    }

    protected final function _getBy(string $statement, callable $bind = null): ?Model
    {
        $obj = $this->fetch($statement, $bind);
        if (empty($obj)) {
            return null;
        }
        $model = new $this->class();
        return $model->init($obj[0]);
    }

    public function get(int $id): ?Model
    {
        $statement = "SELECT * FROM {$this->table} WHERE id = :id";
        $bind = function (\PDOStatement $stmt) use ($id) {
            $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        };
        return $this->_getBy($statement, $bind);
    }

    public final function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM ' . $this->table . ' WHERE id = :id'
        );
        $stmt->bindParam('id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    protected final function insert(Model $obj): bool
    {
        $stmt = $this->pdo->prepare($this->insertSql);
        $this->bindParam($stmt, $obj);
        $result = $stmt->execute();
        if ($result) {
            $id = $this->pdo->lastInsertId();
            $obj->id = intval($id);
        }
        return $result;
    }

    protected final function update(Model $obj, string $updateSql = ""): bool
    {
        if (empty($updateSql)) {
            $updateSql = $this->updateSql;
        }
        $stmt = $this->pdo->prepare($updateSql);
        $this->bindParam($stmt, $obj);
        $stmt->bindParam('id', $obj->id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function save(Model $obj): bool
    {
        if ($obj->id == 0) {
            return $this->insert($obj);
        }
        return $this->update($obj);
    }

    protected static function listField(array $array, string $field): array
    {
        if (empty($array)) return array();
        $fields = array_fill(0, count($array)-1, 0);
        for ($i = 0; $i < count($array); ++$i) {
            $fields[$i] = $array[$i][$field];
        }
        return $fields;
    }
}
