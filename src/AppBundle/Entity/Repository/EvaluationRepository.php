<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EvaluationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvaluationRepository extends EntityRepository
{
	/**
	 * Retourne le dernier test d un candidate
	 * @param  integer $candisateId
	 * @return array              
	 */
	public function getCurrentEvaluation($candisateId)
	{
		$em =  $this->getEntityManager();//var_dump($em);die;
		$qb = $this->createQueryBuilder('e');
        $result = $qb->innerJoin('e.candidates', 'u')
                     ->where($qb->expr()->eq('u.id', $candisateId))
                     ->addOrderBy('e.id', 'DESC')
                     ->getQuery()
                     ->getResult();

        $result = !empty($result) ? current($result) : [];

        return $result;
	}
}
