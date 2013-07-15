<?php

namespace Totalcan\DocumancerBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function getUsersList()
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT d FROM TotalcanDocumancerBundle:User d ORDER BY d.id DESC'
            );

        try {
            return $query->getResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }

    public function loadUserByUsername($username)
    {
        $q = $this
            ->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active admin TotalcanDocumancerBundle:User object identified by "%s".',
                $username
            );
            throw new UsernameNotFoundException($message, 0, $e);
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }

//    public function getUsersWithRoles()
//    {
//        $query = $this->getEntityManager()
//                //JOIN TotalcanDocumancerBundle:Role r
//            ->createQuery('
//                SELECT u, ur
//                FROM TotalcanDocumancerBundle:User u
//
//                JOIN TotalcanDocumancerBundle:Role r
//                WHERE r.users = u.id
//
//                ORDER BY u.id DESC'
//            );
//
//        try {
//            return $query->getResult();
//        } catch (\Doctrine\ORM\NoResultException $e) {
//            return null;
//        }
//    }

}
