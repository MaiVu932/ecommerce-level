<?php

include 'BaseRepository.php';

class UserRepository extends BaseRepository
{
    public function test()
    {
        return $this->get_data("SELECT * FROM users");
    }
}