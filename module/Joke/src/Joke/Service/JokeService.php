<?php

namespace Joke\Service;


interface JokeService {

    public function findAllJokes();

    public function findJoke($id);
} 