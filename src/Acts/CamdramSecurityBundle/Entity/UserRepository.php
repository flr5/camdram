<?php

namespace Acts\CamdramSecurityBundle\Entity;

use Acts\CamdramBundle\Entity\Show;
use Doctrine\ORM\EntityRepository;
use Acts\CamdramBundle\Entity\Organisation;
use Acts\CamdramSecurityBundle\Security\OwnableInterface;

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

    public function findOneByEmail($email)
    {
        if (preg_match('/^(.*)@cam.ac.uk$/i', $email, $matches)) {
            $crsid = $matches[1];

            return $this->createQueryBuilder('u')
                ->where('u.email = :email')
                ->orWhere('u.email = :crsid')
                ->setParameter('email', $email)
                ->setParameter('crsid', $crsid)
                ->getQuery()->setMaxResults(1)->getOneOrNullResult();
        } else {
            return parent::findOneByEmail($email);
        }
    }
    
    public function findOneByFullEmail($email)
    {
        return parent::findOneByEmail($email);
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
            ->andWhere('e.entityId >= :level')
            ->andWhere('e.revokedBy IS NULL')
            ->setParameter('level', $min_level)
            ->setParameter('type', 'security')
            ->getQuery();

        return $query->getResult();
    }
    
    public function findOrganisationAdmins()
    {
        $qb = $this->createQueryBuilder('u');
        $query = $qb->innerJoin('u.aces', 'e')
            ->where('e.type IN (:types)')
            ->andWhere('e.revokedBy IS NULL')
            ->setParameter('types', ['society', 'venue', 'security'])
            ->getQuery();
        
        return $query->getResult();
    }
    
    public function findActiveUsersForMailOut()
    {
        $loginThreshold = new \DateTime('-2 years');
        
        $qb = $this->createQueryBuilder('u');
        $query = $qb->where('u.is_email_verified = true')
        ->andWhere('u.last_login_at >= :loginThreshold')
        ->setParameter('loginThreshold', $loginThreshold)
        ->getQuery();
        
        return $query->getResult();
    }

    public function getEntityOwners(OwnableInterface $entity)
    {
        $query = $this->createQueryBuilder('u')
            ->innerJoin('u.aces', 'e')
            ->where('e.type = :type')
            ->andWhere('e.entityId = :id')
            ->andWhere('e.revokedBy IS NULL')
            ->setParameter('id', $entity->getId())
            ->setParameter('type', $entity->getAceType())
            ->getQuery();

        return $query->getResult();
    }
    
    public function getContactableEntityOwners(OwnableInterface $entity)
    {
        $query = $this->createQueryBuilder('u')
        ->innerJoin('u.aces', 'e')
        ->where('e.type = :type')
        ->andWhere('e.entityId = :id')
        ->andWhere('e.revokedBy IS NULL')
        ->andWhere('u.is_email_verified = true')
        ->setParameter('id', $entity->getId())
        ->setParameter('type', $entity->getAceType())
        ->getQuery();
        
        return $query->getResult();
    }

    /**
     * Get the list of users that have requested admin access to a show.
     */
    public function getRequestedShowAdmins(Show $show)
    {
        $query = $this->createQueryBuilder('u')
            ->innerJoin('u.aces', 'e')
            ->where("e.type = 'request-show'")
            ->andWhere('e.entityId = :id')
            ->andWhere('e.grantedBy IS NULL')
            ->andWhere('e.revokedBy IS NULL')
            ->setParameter('id', $show->getId())
            ->getQuery();

        return $query->getResult();
    }
}
