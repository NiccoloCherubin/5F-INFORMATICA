<?php

class Student extends Persona implements Volunteer
{
    public function __construct($name, $email, $age, private string $school)
    {
        parent::__construct($name, $email, $age);
    }

    public function getSchool(): string
    {
        return $this->school;
    }

    public function setSchool(string $school): void
    {
        $this->school = $school;
    }

    public function introduce() : string
    {
        return parent::introduce()."e frequnto {$this->school}";
    }
    public function ToDO(): string
    {
        return "prova interfaccia";
    }

}