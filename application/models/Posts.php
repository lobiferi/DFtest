<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Application_Model_Posts
 *
 * @ORM\Table(name="Posts", indexes={@ORM\Index(name="fk_Posts_Users1_idx", columns={"Users_id"})})
 * @ORM\Entity
 */
class Application_Model_Posts {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=45, nullable=false)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, columnDefinition="TIMESTAMP DEFAULT CURRENT_TIMESTAMP")
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false, options={"default" : 0})
     */
    private $deleted = 0;

    /**
     * @var \Application_Model_Users
     *
     * @ORM\ManyToOne(targetEntity="Application_Model_Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Users_id", referencedColumnName="id")
     * })
     */
    private $users;

    /**
     * @var \Application_Model_Comments
     *
     * @ORM\OneToMany(targetEntity="Application_Model_Comments", mappedBy="posts")
     */
    private $comments;

    function setId($id) {
        $this->id = $id;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDate(\DateTime $date) {
        $this->date = $date;
    }

    function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    function setUsers(\Application_Model_Users $users) {
        $this->users = $users;
    }

    function getId() {
        return $this->id;
    }

    function getTitle() {
        return $this->title;
    }

    function getDate() {
        return $this->date;
    }

    function getDeleted() {
        return $this->deleted;
    }

    function getUsers() {
        return $this->users;
    }

    function getComments() {
        return $this->comments;
    }

}
