<?php


namespace App\DataPersister;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserDataPersister implements \ApiPlatform\Core\DataPersister\DataPersisterInterface
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /**
     * @inheritDoc
     */
    public function persist($data)
    {
        if ($data->getPlainPassword()) {
            $data->setPassword(
//                $this->userPasswordHasher->hashPassword(
//                    $data, $data->getPlainPassword()
//                )
                $data->getPlainPassword()
            );
            $data->eraseCredentials();
        }
        $data->setRoles(["ROLE_USER"]);
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}