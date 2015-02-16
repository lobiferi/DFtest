<?php

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application_Form_Article
 *
 * @author lobiferi
 */
class Application_Form_Article implements Serializable {

    /**
     * @NotBlank
     * @NotNull
     */
    private $id = "new";

    /**
     * @NotBlank
     * @NotNull
     * @Length(min=4, max=50)
     */
    private $title;

    /**
     * @NotBlank
     * @NotNull
     * @Length(min=10, max=500000)
     */
    private $content;

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function getId() {
        return $this->id;
    }

    public function serialize() {
        $obj = new ReflectionObject($this);
        $ret = array();
        foreach ($obj->getProperties() as $property) {
            $property->setAccessible(true);
            $ret[$property->getName()] = $property->getValue($this);
        }
        return serialize($ret);
    }

    public function unserialize($serialized) {
        $obj = new ReflectionObject($this);
        $ret = unserialize($serialized);
        foreach ($obj->getProperties() as $property) {
            if (array_key_exists($property->getName(), $ret)) {
                $property->setAccessible(true);
                $property->setValue($this, $ret[$property->getName()]);
            }
        }
    }

}
