<?php

class azienda
{
    public function __construct(private $nome, private $citta, private $indirizzo, private $telefono)
    {
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getCitta()
    {
        return $this->citta;
    }

    /**
     * @return mixed
     */
    public function getIndirizzo()
    {
        return $this->indirizzo;
    }

    /**
     * @return mixed
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * @return mixed
     */
    public function getEstere()
    {
        return $this->estere;
    }

    /**
     * @return mixed
     */
    public function getNFrancia()
    {
        return $this->NFrancia;
    }

    /**
     * @return mixed
     */
    public function getNSpagna()
    {
        return $this->NSpagna;
    }

    /**
     * @return mixed
     */
    public function getNGermania()
    {
        return $this->NGermania;
    }

    /**
     * @return mixed
     */
    public function getNInghilterra()
    {
        return $this->NInghilterra;
    }

    /**
     * @return mixed
     */
    public function getNUsa()
    {
        return $this->NUsa;
    }

    /**
     * @param mixed $estere
     */
    public function setEstere($estere): void
    {
        $this->estere = $estere;
    }

    /**
     * @param mixed $NFrancia
     */
    public function setNFrancia($NFrancia): void
    {
        $this->NFrancia = $NFrancia;
    }

    /**
     * @param mixed $NSpagna
     */
    public function setNSpagna($NSpagna): void
    {
        $this->NSpagna = $NSpagna;
    }

    /**
     * @param mixed $NGermania
     */
    public function setNGermania($NGermania): void
    {
        $this->NGermania = $NGermania;
    }

    /**
     * @param mixed $NInghilterra
     */
    public function setNInghilterra($NInghilterra): void
    {
        $this->NInghilterra = $NInghilterra;
    }

    /**
     * @param mixed $NUsa
     */
    public function setNUsa($NUsa): void
    {
        $this->NUsa = $NUsa;
    }


}