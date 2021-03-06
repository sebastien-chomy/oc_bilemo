<?php
/**
 * This file is part of oc_bilemo project
 *
 * @author: Sébastien CHOMY <sebastien.chomy@gmail.com>
 * @since 2018/04
 */

namespace App\DataFixtures;

use App\Entity\User\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * Class UserFixtures
 *
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture implements ContainerAwareInterface, DependentFixtureInterface
{

    /** *******************************
     *  PROPERTIES
     */

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var UserPasswordEncoder
     */
    protected $encoder;

    /** *******************************
     *  METHODS
     */

    /**
     * @inheritDoc
     */
    function getDependencies()
    {
        return [
            CustomerFixtures::class
        ];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $dateTime = new \DateTime();
        for ($i=1; $i <=5; $i++ ) {
            $user = new User();
            $user->setRegisteredAt($dateTime)
                 ->setUpdateAt($dateTime)
                 ->setUsername("customer_$i")
                 ->setEmail("customer$i@mail.com")
                 ->setFirstname("firstname_$i")
                 ->setLastname("lastname_$i")
                 ->setRoles(['ROLE_API_USER']);

            $hashPassword = $this->encoder->encodePassword($user, '12345');
            $user->setPassword($hashPassword);

            /** @var \App\Entity\Customer $customer */
            $customer = $this->getReference("customer_$i");
            $user->setCustomer($customer);

            $manager->persist($user);
        }
        $manager->flush();
    }

    /**
     * @param ContainerInterface|null $container
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->encoder = $this->container->get('security.password_encoder');
    }
}
