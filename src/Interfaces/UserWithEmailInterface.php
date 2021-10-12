<?php

namespace App\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

interface UserWithEmailInterface extends UserInterface
{
    public function getId();
    public function getEmail();
    public function setEmail(string $email);
    public function getIsVerified();
    public function setIsVerified(bool $isVerified);
}
