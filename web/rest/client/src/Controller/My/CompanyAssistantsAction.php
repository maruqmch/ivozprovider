<?php

namespace Controller\My;

use ApiPlatform\Core\Exception\ResourceClassNotFoundException;
use Ivoz\Provider\Domain\Model\Company\CompanyInterface;
use Ivoz\Provider\Domain\Model\User\UserRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CompanyAssistantsAction
{
    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(
        TokenStorageInterface $tokenStorage,
        UserRepository $userRepository
    ) {
        $this->tokenStorage = $tokenStorage;
        $this->userRepository = $userRepository;
    }

    public function __invoke()
    {
        $token =  $this->tokenStorage->getToken();

        if (!$token || !$token->getUser()) {
            throw new ResourceClassNotFoundException('User not found');
        }

        /** @var CompanyInterface $company */
        $user = $token->getUser();

        return $this
            ->userRepository
            ->getUserAssistantCandidates($user);
    }
}
