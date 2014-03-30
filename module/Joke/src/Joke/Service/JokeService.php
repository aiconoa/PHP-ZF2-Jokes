<?php

namespace Joke\Service;
use Joke\Entity\Joke;

interface JokeService  {

    public function findAllJokes($offset, $limit, $order);

    public function findJoke($id);

    public function createOrUpdateJoke(Joke $joke);

    public function deleteJoke($id);
}