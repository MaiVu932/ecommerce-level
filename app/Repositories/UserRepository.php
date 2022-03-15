<?php

include 'BaseRepository.php';

class UserRepository extends BaseRepository
{

    /**
     * test
     * 
     * @param int $id
     *
     * @return mix
     */
    public function test()
    {
        return $this->get_data("SELECT * FROM users");
    }
}