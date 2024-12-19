<?php

class Persona
{
    const FAVOURITE_COLOR = "green";

    public function __construct(protected $name,protected $email,protected $age) //da php 8.0 non bisogna dichiarare attributi o fare this (come C#)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function getAge(): int
    {
        return $this->age;
    }
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function introduce() :string
    {
        return "Mi chiamo {$this->name}, ho {$this->age} anni e la mia mail è {$this->email} e mi piace il ".self::FAVOURITE_COLOR;
    }


}