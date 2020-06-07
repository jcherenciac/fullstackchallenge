<?php
/**
 * Created by PhpStorm.
 * User: chica
 * Date: 06/06/2020
 * Time: 18:21
 */

namespace App\DataFixtures;

use App\Entity\Allocation;
use App\Entity\Portfolio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $portfolio = new Portfolio();
        $manager->persist($portfolio);

        for ($i = 0; $i < 2; $i++) {
            $allocation = new Allocation();
            $allocation->setId($i+1);
            $allocation->setPortfolio($portfolio);
            $allocation->setShare($i+3);
            $manager->persist($allocation);

        }

        $manager->flush();
    }
}