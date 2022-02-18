<?php

namespace App\Model;

class Question extends Model
{
    private int|string $codigo   = '';
    private string     $pergunta = '';
    private string     $correta  = '';
    private string     $alta     = '';
    private string     $altb     = '';
    private string     $altc     = '';
    private string     $altd     = '';

    /** @return int|string */
    public function getCodigo(): int|string
    {
        return $this->codigo;
    }

    /** @param int|string $codigo */
    public function setCodigo(int|string $codigo): void
    {
        $this->codigo = $codigo;
    }

    /** @return string */
    public function getPergunta(): string
    {
        return $this->pergunta;
    }

    /** @param string $pergunta */
    public function setPergunta(string $pergunta): void
    {
        $this->pergunta = $pergunta;
    }

    /** @return string */
    public function getAlta(): string
    {
        return $this->alta;
    }

    /** @param string $alta */
    public function setAlta(string $alta): void
    {
        $this->alta = $alta;
    }

    /** @return string */
    public function getAltb(): string
    {
        return $this->altb;
    }

    /** @param string $altb */
    public function setAltb(string $altb): void
    {
        $this->altb = $altb;
    }

    /** @return string */
    public function getAltc(): string
    {
        return $this->altc;
    }

    /** @param string $altc */
    public function setAltc(string $altc): void
    {
        $this->altc = $altc;
    }

    /** @return string */
    public function getAltd(): string
    {
        return $this->altd;
    }

    /** @param string $altd */
    public function setAltd(string $altd): void
    {
        $this->altd = $altd;
    }

    /** @return string */
    public function getCorreta(): string
    {
        return $this->correta;
    }

    /** @param string $correta */
    public function setCorreta(string $correta): void
    {
        $this->correta = $correta;
    }

    /** @inheritDoc */
    protected function getPrimaryKeys(): array
    {
        return [ 'codigo' ];
    }

    /** @inheritDoc */
    protected function getFillableColumns(): array
    {
        return [ 'pergunta', 'correta', 'altA', 'altB', 'altC', 'altD' ];
    }
}