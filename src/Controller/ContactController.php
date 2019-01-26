<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use App\Entity\Contact;
use App\Entity\Secteur;
use App\Entity\User;
use App\Repository\ContactRepository;
use App\Repository\SecteurRepository;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/ethan", name="contact")
     */
    public function index(Contact $contact = null, Request $request, ObjectManager $manager)
    {
        if(!$contact){
            $contact = new Contact();
            
        }
        $messages = [];
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        
           
            if($form->isSubmitted() && $form->isValid()){
                if(!$contact->getId()){
                    $contact->setCreatedAt(new \DateTime());
                }
                dump($contact);
                $manager->persist($contact);
                $manager->flush();
                // on récupaire les utilisateurs de la section choissie pour leur transmettre le mail 
                $repo = $this->getDoctrine()->getRepository(User::class);
                // $users = $repo->findBy([
                //     'secteur' => $contact->getSecteur(),
                //     'lastname' => 'ASC',
                //     'firstname' => 'ASC' 
                // ]);

                $users = $repo->findBy(
                    array('secteur' => $contact->getSecteur()), // Critere
                    array('email' => 'desc'),        // Tri
                    5,                              // Limite
                    0                               // Offset
                  );
               
                
                // $users = $repo->findAll();
                dump($users);
                
                foreach($users as $user)
                {
                    
                    $messages[] = $user->getEmail();
                    dump($user->getEmail());
                  
                }
                dump($messages);
                // return $this->redirectToRoute('contact', ['id' => $contact->getId()]);
            }
            
            
          

       return $this->render('contact/index.html.twig', [
           'formContact' => $form->createView(),
           'editMode' =>$contact->getId() !== null,
           'messages' => $messages
       ]);
    }

    
}
