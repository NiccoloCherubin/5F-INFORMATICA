<?php

class utente
{
    public function __construct(private string $email,private int $eta,private string $password,private string $sesso,private array $colori)
    {
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSesso(): string
    {
        return $this->sesso;
    }

    /**
     * @param string $sesso
     */
    public function setSesso(string $sesso): void
    {
        $this->sesso = $sesso;
    }

    /**
     * @return array
     */
    public function getColori(): array
    {
        return $this->colori;
    }

    /**
     * @param array $colori
     */
    public function setColori(array $colori): void
    {
        $this->colori = $colori;
    }
    public function coloriPreferiti() :string
    {
        return implode(",",$this->colori); // Restituisce la stringa con i colori separati da ","
    }
    public function saluta()
    {
        echo "ciao sono {$this->email} ho {$this->eta} anni, sono di genere {$this->sesso} ed i miei colori preferiti sono {$this->coloriPreferiti()}";
    }


}