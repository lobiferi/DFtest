<?php

use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Description of Comment
 *
 * @author lobiferi
 */
class Application_Form_Comment {

    /**
     *
     * @NotNull
     * @NotBlank
     */
    private $post;

    /**
     * @NotNull
     * @NotBlank
     * @Email
     */
    private $user;

    /**
     * @NotNull
     * @NotBlank
     * @Length(min=50, max=5000)
     */
    private $text;

    function getPost() {
        return $this->post;
    }

    function getUser() {
        return $this->user;
    }

    function getText() {
        return $this->text;
    }

}
