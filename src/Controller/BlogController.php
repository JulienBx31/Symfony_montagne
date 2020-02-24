<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Custumer;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface as ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, ObjectManager $manager) {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repo->findAll();

        $custumer = new Custumer();
        $form = $this->createForm(ContactType::class, $custumer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($custumer);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('blog/home.html.twig', [
            'articles' => $articles,
            'formContact' => $form->createView()
        ]);
    }
    
    /**
     * @Route("/blog/new", name="blog_create")
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager) {
        if (!$article) {
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // Si le formulaire à était soumit et si le form est valide
            if (!$article->getId()) // Si l'article n'as pas d'identifiant, on met une date de création
                $article->setCreateAt(new \DateTime());

            $manager->persist($article); // Enregistre dans la base de donnée
            $manager->flush();
            
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }

        return $this->render('blog/create.html.twig', [
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article, Request $request, ObjectManager $manager) {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreatedAt(new \DateTime())
                    ->setArticle($article);
            $manager->persist($comment);
            $manager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/profil", name="profil_s")
     */
    public function profil_show() {
        return $this->render('profil/profil_show.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, ObjectManager $manager) {
        $custumer = new Custumer();
        $form = $this->createForm(ContactType::class, $custumer);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($custumer);
            $manager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/contact.html.twig', [
            'formContact' => $form->createView()
        ]);
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function mail() {
        $repo = $this->getDoctrine()->getRepository(Custumer::class);
        $mail = $repo->findAll();
        return $this->render('contact/mail.html.twig', [
            'controller_name' => 'BlogController',
            'mails' => $mail
        ]);
    }
}
