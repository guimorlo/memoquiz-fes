<?php

namespace App\Infra;
use function pg_connect;
use PDO;

class Connection
{
    const DBNAME = 'memoquiz',
          DBHOST = '192.168.0.120',
//          DBHOST = '10.1.1.160',
          DBPORT = 5432,
          DBUSER = 'memoquiz',
          DBPASS = 'ripswap';

    public  mixed $connection;
    private bool  $singleTrans;

    public function __construct()
    {
        $connectionString = 'pgsql:'.
                            'host='    .self::DBHOST.
                           ';port='    .self::DBPORT.
                           ';dbname='  .self::DBNAME.';';
        $this->connection = new PDO($connectionString, self::DBUSER, self::DBPASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    /**
     * Retorna se a conexão é valida.
     * @return bool
     */
    public function isConnected()
    {
        return pg_connection_status($this->connection) == PGSQL_CONNECTION_OK;
    }

    /**
     * Retorna se está em uma transação.
     * @return bool
     */
    public function inTransaction()
    {
        return (bool) pg_exec($this->connection, 'SELECT now() = statement_timestamp();');
    }

    /**
     * Inicia uma transação.
     */
    public function begin()
    {
        $this->inTransaction() || pg_exec($this->connection, 'BEGIN;');
    }

    /**
     * Finaliza uma transação.
     */
    public function end()
    {
        $this->inTransaction() || pg_exec($this->connection, 'END;');
    }

    /**
     * Comita uma transação.
     */
    public function commit()
    {
        $this->inTransaction() || pg_exec($this->connection, 'COMMIT;');
    }

    /**
     * Realiza rollback na transação.
     */
    public function rollback()
    {
        $this->inTransaction() || pg_exec($this->connection, 'ROLLBACK;');
    }

}