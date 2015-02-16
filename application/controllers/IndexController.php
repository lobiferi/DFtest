<?php

use DF\EntityManager;
use PhSpring\Annotations\Autowired;
use PhSpring\Annotations\Controller;

/**
 * @Controller
 */
class IndexController {

    /**
     * @var EntityManager
     * @Autowired
     */
    private $em;

    public function init() {
        /* Initialize action controller here */
    }

    public function index() {
        $ret = array();

        $ret['posts'] = $this->em->getRepository(Application_Model_Details::class)->createQueryBuilder('p')
                        ->leftJoin('p.posts', 'c')
                        ->where('c.deleted = :deleted')
                        ->setParameter('deleted', false)
                        ->getQuery()->getResult();

        return $ret;
    }

}
