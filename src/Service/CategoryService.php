<?php

namespace App\Service;

use App\Repository\CategoryRepository;

class CategoryService
{

    private $repo;

    public function __construct(CategoryRepository $repository, ){

        $this->repo = $repository;

    }


    public function getAll(){

        return $this->repo->findAll();
    }
}