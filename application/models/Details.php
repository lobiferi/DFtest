<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Application_Model_Details
 *
 * @ORM\Table(name="Details", indexes={@ORM\Index(name="fk_Details_Posts_idx", columns={"Posts_id"})})
 * @ORM\Entity
 */
class Application_Model_Details {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="sequence", type="integer", nullable=true)
     */
    private $sequence;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text", nullable=true)
     */
    private $text;

    /**
     * @var \Application_Model_Posts
     *
     * @ORM\ManyToOne(targetEntity="Application_Model_Posts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Posts_id", referencedColumnName="id")
     * })
     */
    private $posts;

    function setId($id) {
        $this->id = $id;
    }

    function setSequence($sequence) {
        $this->sequence = $sequence;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setPosts(\Application_Model_Posts $posts) {
        $this->posts = $posts;
    }
    function getId() {
        return $this->id;
    }

    function getSequence() {
        return $this->sequence;
    }

    function getText() {
        return $this->text;
    }

    function getPosts() {
        return $this->posts;
    }


}
