<?php

namespace Joke\Service;

use Joke\Entity\Joke;

interface JokeService {

    public function findAllJokes();

    public function findJoke($id);

    public function createJoke(Joke $joke);
}