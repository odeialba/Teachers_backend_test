<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';

    private int $id;
    private string $name;
    private int $votes;
    /** @var User[] $students */
    private array $students;
    /** @var Teacher[] $teachers */
    private array $teachers;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $this->attributes['id'] = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $this->attributes['name'] = $name;

        return $this;
    }

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }

    public function getStudents(): array
    {
        return $this->students;
    }

    public function setStudents(array $students): self
    {
        $this->students = $students;

        return $this;
    }

    public function getTeachers(): array
    {
        return $this->teachers;
    }

    public function setTeachers(array $teachers): self
    {
        $this->teachers = $teachers;

        return $this;
    }

    public function fromArray(array $attributes): self
    {
        $this->setId($attributes['id']);
        $this->setName($attributes['name']);

        return $this;
    }

    public function fromObject(object $attributes): self
    {
        $this->setId($attributes->id);
        $this->setName($attributes->name);

        return $this;
    }
}
