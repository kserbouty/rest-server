<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Exception;

class AppFixtures extends Fixture
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->setName('Product n°' . $i);
            $product->setDescription('Description n°' . $i);
            $product->setQuantity(random_int(50, 100));
            $product->setPrice(random_int(10, 30));
            $product->setCreatedAt(new \DateTime());
            $manager->persist($product);
        }
        $manager->flush();
    }
}
