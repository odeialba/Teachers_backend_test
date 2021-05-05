<?php

namespace App\Models;

class Teacher extends User
{
    private int $votes;

    public function getVotes(): int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }
}
