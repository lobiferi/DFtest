<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Application_Model_Comments
 *
 * @ORM\Table(name="Comments", indexes={@ORM\Index(name="fk_Comments_Users1_idx", columns={"Users_id"}), @ORM\Index(name="fk_Comments_Posts1_idx", columns={"Posts_id"})})
 * @ORM\Entity
 */
class Application_Model_Comments {

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
     * @ORM\Column(name="text", type="text", length=16777215, nullable=false)
     */
    private $text;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false)
     */
    private $deleted = 0;

    /**
     * @var Application_Model_Users
     *
     * @ORM\ManyToOne(targetEntity="Application_Model_Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Users_id", referencedColumnName="id")
     * })
     */
    private $users;

    /**
     * @var Application_Model_Posts
     *
     * @ORM\ManyToOne(targetEntity="Application_Model_Posts", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Posts_id", referencedColumnName="id")
     * })
     */
    private $posts;

    function getId() {
        return $this->id;
    }

    function getText() {
        return $this->text;
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

    function getPosts() {
        return $this->posts;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setDate(DateTime $date) {
        $this->date = $date;
    }

    function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    function setUsers(Application_Model_Users $users) {
        $this->users = $users;
    }

    function setPosts(Application_Model_Posts $posts) {
        $this->posts = $posts;
    }

}
