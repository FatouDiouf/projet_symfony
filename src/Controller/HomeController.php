<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Employer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Service;
use App\Entity\User;
use App\Form\AuthentificationType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ObjectManager $mananger, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(AuthentificationType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hach = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hach);
            $mananger->persist($user);
            $mananger->flush();
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     *@Route("/accueil",name="accueil")
     */
    public function accueil(){
        return $this->render('home/accueil.html.twig');
    }

    /**
     * @Route("/home/ajout",name="ajout")
     * @Route("/home/{id}/ajout",name="modif")
     */
    public function ajoutmodif(Employer $employe = null, Request $request,ObjectManager $mananger){
        
        if (!$employe) {
            $employe = new Employer();
        }
        $service = new Service();
        $form = $this->createFormBuilder($employe)
                    ->add('matricule',TextType::class)   
                     ->add('nom',TextType::class)   
                     ->add('datenaiss',DateType::class,[
                         'widget'=>'single_text',
                         'format'=>'yyyy-MM-dd'
                         ]) 
                     ->add('salaire',MoneyType::class)
                     ->add('services',EntityType::class,[
                         'class' => Service::class,
                         'choice_label' => 'libelle'
                     ])
                    //  ->add('save',SubmitType::class,[
                    //      'label' => 'Enregistrer'
                    //       ])  
                     ->getForm(); 
        $form->handleRequest($request); 
                        
        
        if($form->isSubmitted() && $form->isValid()){
            $mananger->persist($employe);
            $mananger->flush();

            return $this->redirectToRoute('ajout',['id'=>$employe->getId()]);
        }
        return $this->render('home/ajout.html.twig',[
                'form' => $form->createView(), 
                'editMode' => $employe->getId() != null,
        ]);
    }
    /**
     * @Route("/home/liste",name="lister")
     */
    public function liste(){
        $liste = $this->getDoctrine()->getRepository(Employer::class);
        $employes = $liste->findAll(); 
        return $this->render('home/liste.html.twig', [
            'employe' => $employes 
        ]);
    }

    /**
     * @Route("/home/{id}/delete",name="delete")
     */
    public function delete(Employer $employe=null, ObjectManager $mananger){
        $mananger->remove($employe);
        $mananger->flush();
        return $this->redirectToRoute('lister');
    }
}
