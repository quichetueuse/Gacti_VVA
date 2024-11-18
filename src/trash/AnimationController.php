<?php

namespace trash;
require_once('../autoloader.php');

use Controllers\BaseController;
use Models\Animation;

class AnimationController extends BaseController
{
    private Animation $animation;


    public function __construct(){
        $this->animation = new Animation();
//        $this->user->verify_credentials('', '');
//        $this->sanitize($_POST['input-email']);
//        $this->redirect();
    }


    public function getAllAnimations(): array {
        return $this->animation->getAllAnimations();
    }

    public function getCountAnimations(): int {
        return $this->animation->getCountAnimations();
    }

    public function getAnimationById(int $id) {

    }

    public function updateAnimation(array $updated_animation) {

    }

    public function delAnimationById(int $id) {

    }

}