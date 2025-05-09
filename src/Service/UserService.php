<?php

namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserService
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHarsher,
        private UserRepository $userRepository,
        private ParameterBagInterface $parameter,
    )
    {}

    public function generateHashByUser(User $user): void
    {
        $hash = $this->passwordHarsher->hashPassword(
            $user,
            $user->getPassword()
        );

        $this->userRepository->upgradePassword($user, $hash);
    }

    public function firstUser(): void
    {
        $user = new User();
        $user
            ->setEmail($this->parameter->get('FIRST_USER_EMAIL'))
            ->setPassword($this->parameter->get('FIRST_USER_PASSWORD'));

        $this->generateHashByUser($user);
    }
}