<?php
class Libro
{

    private int $id;
    private string $titolo;
    private string $autore;
    private string $genere;
    private float $prezzo;
    private string $annoPubblicazione;

    public function __construct($titolo, $autore, $genere, $prezzo, $anno_pubblicazione, $id = null) {
        $this->id = $id;
        $this->titolo = $titolo;
        $this->autore = $autore;
        $this->genere = $genere;
        $this->prezzo = $prezzo;
        $this->anno_pubblicazione = $anno_pubblicazione;
    }

    // Setters

    public function setTitolo(string $titolo): void
    {
        $this->titolo = $titolo;
    }

    public function setAutore(string $autore): void
    {
        $this->autore = $autore;
    }

    public function setGenere(string $genere): void
    {
        $this->genere = $genere;
    }

    public function setPrezzo(float $prezzo): void
    {
        $this->prezzo = $prezzo;
    }

    public function setAnnoPubblicazione(string $annoPubblicazione): void
    {
        $this->annoPubblicazione = $annoPubblicazione;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getTitolo(): string
    {
        return $this->titolo;
    }

    public function getAutore(): string
    {
        return $this->autore;
    }

    public function getGenere(): string
    {
        return $this->genere;
    }

    public function getPrezzo(): float
    {
        return $this->prezzo;
    }

    public function getAnnoPubblicazione(): string
    {
        return $this->annoPubblicazione;
    }
}



