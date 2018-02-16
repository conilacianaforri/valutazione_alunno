<?php

namespace Valutazione\Alunno\Repository;

use Valutazione\Alunno\Entity\Alunno;

interface AlunnoRepository
{
    public function findAll();
    
    /**
     * @param string $id
     * @return Alunno|null
     */
    public function findById(string $id): ?Alunno;
    
    /** 
     * @param Alunno $alunno
     */
    public function save(Alunno $alunno): void;
}
