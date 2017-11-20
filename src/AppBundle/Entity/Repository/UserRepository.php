<?php

namespace AppBundle\Repository;



/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
	
	/**
	 * Permet de trouver le candidat qui a le même nom et prénom ou le même email
	 * 
	 * @param \AppBundle\Entity\User $candidate
	 * @return mixed|NULL|\AppBundle\Entity\User
	 */
	public function findUser(\AppBundle\Entity\User $candidate)
	{
		$qb = $this->createQueryBuilder('u')
			->where('u.firstName = :firstName AND u.lastName = :lastName OR u.email = :email OR u.username = :username')
			->setParameter('firstName', $candidate->getFirstName())
			->setParameter('lastName', $candidate->getLastName())
			->setParameter('email', $candidate->getEmail())
			->setParameter('username', $candidate->getUsername());

		return	$qb->getQuery()->getOneOrNullResult();
	}
	
	public function findByRoles(array $roles)
	{
	    $qb = $this->createQueryBuilder('u')
	       ->where('u.roles LIKE :roles')
	       ->setParameter('roles', "%$roles%");
	    
	       return $qb->getQuery()->getResult();
	}
    
	/**
	 * Permet de récupérer le nombre de candidats ayant passé l'évaluation
	 * 
	 * @param int $evaluationId
	 * @return mixed|int
	 */
	public function getNbByEvaluationId ($evaluationId)
	{
	    $qb = $this->createQueryBuilder('u')
	    ->select('COUNT(u)')
	    ->innerJoin('u.evaluations', 'e', 'WITH', 'e.id = :evaluationId')
	    ->setParameter(':evaluationId', $evaluationId, \PDO::PARAM_INT);
	
	    return $qb->getQuery()->getSingleScalarResult();
	}
}