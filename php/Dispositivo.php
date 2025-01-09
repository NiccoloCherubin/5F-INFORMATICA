<?php

abstract class Dispositivo
{
    abstract public function accendi();
    public function __construct(private string $marca)
    {
    }

    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }
}
