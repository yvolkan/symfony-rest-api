<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create 20 products! Bam!
        for ($i = 1; $i < 5; $i++) {
            $product = new Product();
            $product->setName('Product Name' . $i);
            $product->setShippingDate($i);
            $product->setCreateDate(new DateTime('now'));
            $manager->persist($product);

            $manager->flush();
        }
    }
}
