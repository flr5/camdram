<?php
namespace Acts\CamdramBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function findUsersWithSimilarName($name)
    {
        preg_match('/.* ([a-z\'\-]+)$/i', trim($name), $matches);
        if (count($matches) < 2) {
            throw new \InvalidArgumentException(sprintf('An empty name has been provided'));
        }
        $surname = $matches[1];

        $query = $this->createQueryBuilder('u')
            ->where('u.name LIKE :name')
            ->orderBy('u.login', 'DESC')
            ->setParameter('name', '%'.$surname)
            ->getQuery();
        return $query->getResult();
    }

    public function findByEmailAndPassword($email, $password)
    {
        $query = $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->andWhere('u.password = :password')
            ->setParameter('email', $email)
            ->setParameter('password', md5($password))
            ->getQuery();
        return $query->getOneOrNullResult();
    }


    public function findAdmins($min_level)
    {
        $query = $this->createQueryBuilder('u')
            ->innerJoin('u.aces', 'e')
            ->where('e.type = :type')
            ->andWhere('e.entity_id >= :level')
            ->andWhere('e.granted_by IS NOT NULL')
            ->andWhere('e.revoked_by IS NULL')
            ->setParameter('level', $min_level)
            ->setParameter('type', 'security')
            ->getQuery();
        return $query->getResult();
}

    public function findOrganisationAdmins(Organisation $org)
    {
        $query = $this->createQueryBuilder('u')
            ->innerJoin('u.aces', 'e')
            ->where('e.type = :type')
            ->andWhere('e.entity_id = :id')
            ->andWhere('e.granted_by IS NOT NULL')
            ->andWhere('e.revoked_by IS NULL')
            ->setParameter('id', $org->getId())
            ->setParameter('type', 'society')
            ->getQuery();
        return $query->getResult();
    }

    public function getEntityOwners($entity)
    {
        $query = $this->createQueryBuilder('u')
            ->innerJoin('u.aces', 'e')
            ->where('e.type = :type')
            ->andWhere('e.entity_id = :id')
            ->andWhere('e.granted_by IS NOT NULL')
            ->andWhere('e.revoked_by IS NULL')
            ->setParameter('id', $entity->getId())
            ->setParameter('type', 'show')
            ->getQuery();
        return $query->getResult();
    }

}
