<?php

namespace App\Model;

class Session extends Model
{
    private User $Host;
    private User $Player;

    protected string $name   = '';
    protected string $pass   = '';
    protected string $connid = '';

    /** @return User */
    public function getHost(): User
    {
        if (!isset($this->Host)) {
            $this->Host = new User();
        }
        return $this->Host;
    }

    /** @param User $Host */
    public function setHost(User $Host): void
    {
        $this->Host = $Host;
    }

    /** @return User */
    public function getPlayer(): User
    {
        if (!isset($this->Player)) {
            $this->Player = new User();
        }
        return $this->Player;
    }

    /** @param User $Player */
    public function setPlayer(User $Player): void
    {
        $this->Player = $Player;
    }

    /** @return string */
    public function getName(): string
    {
        return $this->name;
    }

    /** @return string */
    public function getPass(): string
    {
        return $this->pass;
    }

    /** @param string $name */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /** @param string $pass */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /** @return string */
    public function getHostname()
    {
        return $this->getHost()->getName();
    }

    /** @return string */
    public function getPlayername()
    {
        return $this->getPlayer()->getName();
    }

    /** @param string $sName */
    public function setHostname(string $sName)
    {
        $this->getHost()->setName($sName);
    }

    /** @param string $sName */
    public function setPlayername(string $sName)
    {
        $this->getPlayer()->setName($sName);
    }

    /** @return string */
    public function getConnid(): string
    {
        return $this->connid;
    }

    /** @param string $connid */
    public function setConnid(string $connid): void
    {
        $this->connid = $connid;
    }

    /** @inheritDoc */
    protected function getPrimaryKeys(): array
    {
        return [ 'hostname' ];
    }

    /** @inheritDoc */
    protected function getFillableColumns(): array
    {
        return [ 'hostname', 'playername', 'name', 'pass', 'connid' ];
    }
}