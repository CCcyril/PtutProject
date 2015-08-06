<?php
/**
 * Created by PhpStorm.
 * User: user01
 * Date: 03/04/15
 * Time: 02:55
 */

namespace CGG\ConferenceBundle\Repository;


use CGG\ConferenceBundle\Entity\ImageCompetition;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class ImageCompetitionRepository extends EntityRepository
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager){
        $this->entityManager = $entityManager;
    }
    public function findAllByIdConference($idConference){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:ImageCompetition')->createQueryBuilder('c')
            ->where('c.conference_id = ' . $idConference)
            ->getQuery();
        return $query->getResult();
    }
    public function findByIdImage($idImage){
        return $this->entityManager->find('CGGConferenceBundle:ImageCompetition', $idImage);
    }
    public function save(ImageCompetition $imageCompetition){
        $this->entityManager->persist($imageCompetition);
        $this->entityManager->flush();
    }
    public function findAll(){
        $query = $this->entityManager->getRepository('CGGConferenceBundle:ImageCompetition')->createQueryBuilder('c')->getQuery();
        return $query->getResult();
    }

    public function findALlByOrder($idConference, $order) {
        $query = $this->entityManager->getRepository('CGGConferenceBundle:ImageCompetition')->createQueryBuilder('c')
            ->where('c.conference_id = ' . $idConference)
            ->orderBy('c.' . $order, 'DESC')
            ->getQuery();
        return $query->getResult();
    }

    public function delete($imageCompetition){
        $this->entityManager->remove($imageCompetition);
        $this->entityManager->flush();
    }

}