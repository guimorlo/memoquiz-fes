<?php

namespace App\Model;

class User extends Model
{
    const ADMINS = [ 'morlo', 'parro' ];

    protected string $name;
    protected string $session;
    protected string $expire;
    protected bool   $conectado = false;

    /**
     * @param string $name
     * @param string $session
     */
    public function __construct(string $name = '', string $session = '')
    {
        $this->name    = $name;
        $this->session = $session;
    }

    /** @return bool */
    public function isConectado(): bool
    {
        return $this->conectado;
    }

    /** @param bool $conectado */
    public function setConectado(bool $conectado): void
    {
        $this->conectado = $conectado;
    }

    /** @return string */
    public function getExpire(): string
    {
        return $this->expire;
    }

    /** @param string $expire */
    public function setExpire(string $expire): void
    {
        $this->expire = $expire;
    }

    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }

    /** @param string $name */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @return string */
    public function getSession(): string
    {
        return $this->session;
    }

    /** @param string $session */
    public function setSession(string $session): void
    {
        $this->session = $session;
    }

    /** @inheritDoc */
    protected function getPrimaryKeys(): array
    {
        return ['name'];
    }

    /** @inheritDoc */
    protected function getFillableColumns(): array
    {
        return [ 'name', 'session', 'expire' ];
    }

    /** @return bool */
    public function isAdmin()
    {
        return in_array($this->getName(), self::ADMINS);
    }
}