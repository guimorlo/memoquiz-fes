<?php

namespace App\Model;
use App\Infra\Query;

abstract class Model
{
    protected Query $Query;

    /**
     * @return Query
     */
    protected function getQuery()
    {
        return new Query();
    }

    /**
     * Busca e persiste as informações no modelo.
     * @return mixed
     * @throws \Exception
     */
    public function refresh()
    {
        $oQuery = $this->getQuery();
        $oQuery->setSql(
                    "SELECT * 
                           FROM {$this->getSchema()}.{$this->getTable()}
                          {$this->getKeysConditions()}");
        $oQuery->fetch();
        $this->persistObjectFromData($oQuery->getData());
        return $oQuery->getData();
    }

    /**
     * Insere um novo registro.
     * @return mixed
     */
    public function create()
    {
        $oQuery = $this->getQuery();
        $oQuery->setSql("INSERT INTO {$this->getSchema()}.{$this->getTable()} (". implode(',', $this->getFillableColumns()) .") 
                                  VALUES ( '" . implode("', '", $this->getFillableValues()) . "' );");
        $oQuery->execute();
        $this->persistObjectFromData($oQuery->getData());
        return $oQuery->getData();
    }

    /**
     * Deleta o registro, caso o encontre.
     * @return false|int
     * @throws \Exception
     */
    public function delete()
    {
        $oQuery = $this->getQuery();
        $oQuery->setSql(
            "DELETE FROM {$this->getSchema()}.{$this->getTable()}
                          {$this->getKeysConditions()}");
        return $oQuery->execute();
    }

    public function update()
    {
        $oQuery = $this->getQuery();
        $oQuery->setSql("UPDATE {$this->getSchema()}.{$this->getTable()}
                                SET " . implode(',', $this->getColumnsValuesUpdate()) .
                            "{$this->getKeysConditions()};");
        return $oQuery->execute();
    }

    /**
     * Busca e persiste o primeiro registro encontrado a partir dos filtros.
     * @param array $aColumnCondition
     * @return mixed
     */
    public function firstEquals(array $aColumnCondition)
    {
        $aConditions = [];
        if (isset($aColumnCondition[0])) {
            foreach ($aColumnCondition as $sColumn) {
                $sMethod = "get".ucfirst($sColumn);
                if (method_exists($this, $sMethod)) {
                    $aConditions[] = "$sColumn = '{$this->$sMethod()}'";
                } else {
                    $aConditions[] = "$sColumn = '{$this->$sColumn}'";
                }
            }
        } else {
            foreach ($aColumnCondition as $sColumn => $xValue) {
                $aConditions[] = "$sColumn = '$xValue'";
            }
        }
        $oQuery = $this->getQuery();
        $oQuery->setSql( "SELECT * 
                                FROM {$this->getSchema()}.{$this->getTable()} 
                               WHERE " . implode('AND', $aConditions) . "
                               LIMIT 1;");
        $oQuery->fetch();
        $this->persistObjectFromData($oQuery->getData());
        return $oQuery->getData();
    }

    /**
     * Retorna os valores dos campos que podem ser preenchidos.
     * @return array
     */
    protected function getFillableValues()
    {
        $aValues = [];
        foreach ($this->getFillableColumns() as $sColumn) {
            $sMethod = "get".ucfirst($sColumn);
            if (method_exists($this, $sMethod)) {
                $aValues[] = $this->$sMethod();
            } else {
                $aValues[] = $this->$sColumn;
            }
        }
        return $aValues;
    }

    /**
     * Retorna os valores para o comando de update.
     * @return array
     */
    protected function getColumnsValuesUpdate()
    {
        $aColumns = array_diff($this->getFillableColumns(), $this->getPrimaryKeys());
        $aColumnsValues = [];
        foreach ($aColumns as $sColumn) {
            if (isset($this->$sColumn) && !isBlank($this->$sColumn)) {
                $aColumnsValues[] .= "$sColumn = '{$this->$sColumn}'";
            } else {
                $sMethod = "get".ucfirst($sColumn);
                if (method_exists($this, $sMethod) && !isBlank($this->$sMethod())) {
                    $aColumnsValues[] = "$sColumn = '{$this->$sMethod()}'";
                }
            }
        }
        return $aColumnsValues;
    }

    /**
     * Retorna as condições com as chaves do Modelo.
     * @return string
     * @throws \Exception
     */
    protected function getKeysConditions()
    {
        $aCondicoes = [];
        foreach ($this->getPrimaryKeys() as $sColumn) {
            if (isset($this->$sColumn) && !isBlank($this->$sColumn)) {
                $aCondicoes[] .= "$sColumn = '{$this->$sColumn}'";
                continue;
            } else {
                $sMethod = "get".ucfirst($sColumn);
                if (method_exists($this, $sMethod) && !isBlank($this->$sMethod())) {
                    $aCondicoes[] = "$sColumn = '{$this->$sMethod()}'";
                    continue;
                }
            }
            throw new \Exception('Chaves inválidas');
        }
        return " WHERE " . implode('AND', $aCondicoes);
    }

    /**
     * Retorna as chaves primárias.
     * @return array
     */
    abstract protected function getPrimaryKeys() : array;

    /**
     * Retorna as colunas que podem ser preenchidas.
     * @return array
     */
    abstract protected function getFillableColumns() : array;

    /**
     * Preenche o Modelo com a informação.
     * @param $oData
     */
    protected function persistObjectFromData($oData) {
        if ($oData instanceof \stdClass) {
            foreach ($oData as $sColumn => $xValue) {
                $sMethod = "set".ucfirst($sColumn);
                if (method_exists($this, $sMethod)) {
                    $this->$sMethod($xValue);
                } elseif (property_exists($this, $sColumn)) {
                    $this->$sColumn = $xValue;
                }
            }
        }
    }

    /**
     * @return $this[]
     */
    public function getAllModels()
    {
        $oQuery = $this->getQuery();
        $oQuery->setSql( "SELECT * 
                                FROM {$this->getSchema()}.{$this->getTable()};");
        $oQuery->fetchAll();
        $aReturn = [];
        if ($oQuery->getData() && is_iterable($oQuery->getData())) {
            $sInstance = static::class;
            $oInstance = new $sInstance();
            foreach ($oQuery->getData() as $oData) {
                $oFetchInstance = clone $oInstance;
                $oFetchInstance->persistObjectFromData($oData);
                $aReturn[] = $oFetchInstance;
            }
        }
        return $aReturn;
    }

    /**
     * Retorna o Schema da tabela do Modelo.
     * @return string
     */
    protected function getSchema()
    {
        return 'memoquiz';
    }

    /**
     * Retorna o nome da tabela do Modelo.
     * @return string
     */
    protected function getTable()
    {
        $aClass = explode("\\", get_class($this));
        return mb_strtolower(array_pop($aClass));
    }
}