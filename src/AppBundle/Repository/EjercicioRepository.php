<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EjercicioRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EjercicioRepository extends EntityRepository
{
	public function search($tema = null, $estado = true, $dificultad_min = 0, $dificultad_max = 5)
	{
        //printf("<pre>");print_r($data); printf("</pre>");
	    // Create our query bundler
	    $qb = $this->createQueryBuilder('e');
    	if ($tema !== null) {
            $qb->join('e.tema', 't');
            $exprT = $qb->expr()->eq('t.id', ':tema_id');
        }
        else
        {
            $exprT = $qb->expr()->isNotNull('e.id');
        }
        
        $exprDificultad = $qb->expr()->between('e.dificultad', $dificultad_min, $dificultad_max);
       
        $exprEstado = $qb->expr()->eq('e.estado', "'".($estado)."'");

        //Se unen en AND las codiciones
        $condiciones = $qb->expr()->andX(
                    $exprT,
                    $exprDificultad,
                    $exprEstado
        );
        $qb->setParameter('tema_id', $tema)
        ->where($qb->expr()->andX($condiciones));
		$q = $qb->getQuery();
        $r = $q->getResult();
	    return $r;
	}

}
