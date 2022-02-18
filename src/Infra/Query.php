<?php

namespace App\Infra;

class Query
{
    private Connection $Connection;
    private string     $sql;
    private mixed      $data;

    public function __construct()
    {
        conecta();
        global $oConnection;
        $this->Connection = $oConnection;
    }

    /**
     * @return \App\Infra\Connection
     */
    public function getConnection(): \App\Infra\Connection
    {
        return $this->Connection;
    }

    /**
     * @param \App\Infra\Connection $Connection
     */
    public function setConnection(\App\Infra\Connection $Connection): void
    {
        $this->Connection = $Connection;
    }

    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @param string $sql
     */
    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Executa a query no banco.
     * @return false|int
     */
    public function execute()
    {
        if (trim($this->sql) != '') {
            $xReturn = $this->Connection->connection->exec($this->sql);
            $this->data = $xReturn;
            return $xReturn;
        }
        return false;
    }

    public function fetch()
    {
        if (trim($this->sql) != '') {
            $xStatement = $this->Connection->connection->query($this->sql);
            $this->data = $xStatement->fetchObject();
        }
    }

    public function fetchAll()
    {
        if (trim($this->sql) != '') {
            $xStatement = $this->Connection->connection->query($this->sql);
            $this->data = $xStatement->fetchAll(\PDO::FETCH_OBJ);
        }
    }

}