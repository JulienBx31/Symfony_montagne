<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        //créer 3 catégories fakées
        for ($i = 1; $i <= 3; $i++) {
             $category = new Category();
             $category->setTitle($faker->sentence())
                      ->setDescription($faker->paragraph());
            $manager->persist($category);
            // //créer entre 4 et 6 articles 
            // for($j = 1; $j < 4; $j++) {
            //     $article = new Article();
            //     $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
            //     $article->setTitle($faker->sentence())
            //             ->setContent($content)
            //             ->setImage($faker->imageUrl())
            //             ->setCreateAt($faker->dateTimeBetween('-6 months'))
            //             ->setCategory($category);
            //     $manager->persist($article);
            //     //on donne des commentaire à l'article
            //     for($k = 1; $k <= mt_rand(4, 6); $k++) {
            //         $comment = new Comment();
            //         $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';
            //         $now = new \DateTime();
            //         $days = $now->diff($article->getCreateAt())->days;
            //         $minimum = '-' . $days . ' days';
            //         $comment->setAuthor($faker->name)
            //                 ->setContent($content)
            //                 ->setCreatedAt($faker->dateTimeBetween($minimum))
            //                 ->setArticle($article);
            //         $manager->persist($comment);
            //     }
            // }
        }

        $manager->flush();
    }
}
