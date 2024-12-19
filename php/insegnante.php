<?php

class insegnante
{
    private static int $register = 0; // appartiene alla classe ma non all'oggetto

    public function __construct(private string $name, private string $lastName)
    {
        self::$register++;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public static function getRegister(): int
    {
        return self::$register;
    }

}