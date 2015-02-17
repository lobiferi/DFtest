<?php

use Doctrine\ORM\EntityManager;
use PhSpring\Annotations\Autowired;
use PhSpring\Annotations\Controller;
use PhSpring\Annotations\ModelAttribute;
use PhSpring\Annotations\RequestMapping;
use PhSpring\Annotations\RequestMethod;
use PhSpring\Annotations\RequestParam;
use PhSpring\Annotations\SessionAttributes;
use PhSpring\Annotations\Valid;
use PhSpring\Engine\BindingResult;
use PhSpring\Engine\DefaultSessionAttributeStore;

/**
 * @Controller
 * @RequestMapping("/article")
 * @SessionAttributes(value="article",type=Application_Form_Article::class)
 * @SessionAttributes(value="comment", type=Application_Form_Comment::class)
 */
class ArticleController {

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
     * @RequestMapping(value="/new", method=RequestMethod::GET)
     * @ModelAttribute("article")
     */
    public function newArticle(Application_Form_Article $article, DefaultSessionAttributeStore $sessionStore) {
        $result = $sessionStore->retrieveAttribute(Application_Form_Article::class . '-result');
        $sessionStore->cleanupAttribute(Application_Form_Article::class . '-result');
        $ret = array("form" => $article);
        if ($result && $result->count() > 0) {
            $ret['errors'] = $result->toArray();
        }
        return $ret;
    }

    /**
     * @RequestMapping(value="/(new|\d)", method=RequestMethod::POST)
     * @ModelAttribute("article")
     * @Valid
     */
    public function saveArticle(Application_Form_Article $article, BindingResult $result, DefaultSessionAttributeStore $sessionStore) {
        if ($result->count() > 0) {
            $sessionStore->storeAttribute(Application_Form_Article::class . '-result', $result);
            $this->redirect->gotoUrl('/article/' . $article->getId());
        }
        $sessionStore->cleanupAttribute('article');
        $sessionStore->cleanupAttribute(Application_Form_Article::class . '-result');

        $user = $this->em->find(Application_Model_Users::class, 1);

        $articleEntity = new Application_Model_Posts();
        $articleEntity->setTitle($article->getTitle());
        $articleEntity->setUsers($user);

        $detailsEntity = new Application_Model_Details();
        $detailsEntity->setText($article->getContent());
        $detailsEntity->setSequence(strlen($article->getContent()));
        $detailsEntity->setPosts($articleEntity);

        $this->em->persist($articleEntity);
        $this->em->flush($articleEntity);

        $this->em->persist($detailsEntity);
        $this->em->flush($detailsEntity);

        $this->redirect->gotoUrl('');
    }

    /**
     * @RequestMapping(value="/(?P<id>\d+)", method=RequestMethod::GET)
     * @RequestParam("id")
     * @ModelAttribute("comment")
     */
    public function viewArticle($id, Application_Form_Comment $comment, DefaultSessionAttributeStore $sessionStore) {
        $ret = array('article' => $this->em->getRepository(Application_Model_Details::class)->findOneByPosts($id));
        if (!$ret['article']) {
            $this->redirect->gotoUrl('/');
        }
        $result = $sessionStore->retrieveAttribute(Application_Form_Comment::class . '-result');
        $sessionStore->cleanupAttribute(Application_Form_Comment::class . '-result');
        if ($result && $result->count() > 0) {
            $ret['errors'] = $result->toArray();
        }
        $ret['comment'] = $comment;
        return $ret;
    }

}
