<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface as ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();                                         // L'objet USER est relié aux champs du formulaire
        $form = $this->createForm(RegistrationType::class, $user);  //Pour instancier le formulaire qui est relié a RegistrationType 
                                                                    // créé avec la cli make:form
        $form->handleRequest($request); // Analyse la requet
        // Si le formulaire est soumi et que tous les champs sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            // Remplie USER de donnée du formulaire
            $manager->persist($user);

            // Enregistre dans la base de donnée
            $manager->flush();

            // Une fois enregistré, dirige l'utilisateur vers la page de connexion
            return $this->redirectToRoute('security_login');
            }
        //Affiche le rendu avec le fichier registration.html.twig tant que le formulaire n'est pas valide
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="security_login")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */

     public function logout() {
         
     }
}
