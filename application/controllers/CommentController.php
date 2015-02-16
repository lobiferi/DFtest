<?php

use Doctrine\ORM\EntityManager;
use PhSpring\Annotations\Autowired;
use PhSpring\Annotations\Controller;
use PhSpring\Annotations\ModelAttribute;
use PhSpring\Annotations\RequestMapping;
use PhSpring\Annotations\RequestMethod;
use PhSpring\Annotations\ResponseBody;
use PhSpring\Annotations\SessionAttributes;
use PhSpring\Annotations\Valid;
use PhSpring\Engine\BindingResult;
use PhSpring\Engine\DefaultSessionAttributeStore;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CommentController
 *
 * @author lobiferi
 * @Controller
 * @RequestMapping(value="/comment")
 * @SessionAttributes(value="comment", type=Application_Form_Comment::class)
 */
class CommentController {

    /**
     * @var EntityManager
     * @Autowired
     */
    private $em;

    /**
     * @Autowired
     * @var Zend_Controller_Action_Helper_Redirector
     */
    private $redirect;

    /**
     * @RequestMapping(value="/new", method=RequestMethod::POST)
     * @ModelAttribute("comment")
     * @ResponseBody
     * @Valid
     */
    public function newComment(Application_Form_Comment $comment, BindingResult $result, DefaultSessionAttributeStore $sessionStore) {
        if ($result->count() > 0) {
            $sessionStore->storeAttribute(Application_Form_Comment::class . '-result', $result);
        } else {
            $this->em->getRepository(Application_Model_Comments::class);
            $model = new \Application_Model_Comments();
            $model->setText($comment->getText());
            $model->setPosts($this->em->getRepository(Application_Model_Posts::class)->find($comment->getPost()));
            $user = $this->em->getRepository(\Application_Model_Users::class)->findOneByEmail($comment->getUser());
            if (!$user) {
                $user = new Application_Model_Users();
                $user->setName('Anonymous');
                $user->setEmail($comment->getUser());
                $this->em->persist($user);
                $this->em->flush($user);
            }
            $model->setUsers($user);
            $this->em->persist($model);
            $this->em->flush($model);
            $sessionStore->cleanupAttribute(Application_Form_Comment::class . '-result');
            $sessionStore->cleanupAttribute('comment');
        }
        $this->redirect->gotoUrl('/article/' . $comment->getPost());
    }

}
