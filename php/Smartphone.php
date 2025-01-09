<?php

class Smartphone extends Dispositivo
{

    public function __construct(private string $cpu, $marca)
    {
        parent::__construct($marca);
    }

    public function setCpu(string $cpu): void
    {
        $this->cpu = $cpu;
    }
    public function getCpu(): string
    {
        return $this->cpu;
    }

    public function accendi() : string
    {
        return "sono acceso";
    }

    public function spegni() : string
    {
        return "Smartphone spento\n";
    }
}
