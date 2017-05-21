<?php

namespace Pilote\UserBundle\Controller;

use Pilote\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Pilote\UserBundle\Form\UserContactType;
use Pilote\UserBundle\Form\UserInfosType;
use Pilote\UserBundle\Form\UserTeamType;

class AccountsController extends Controller
{
    public function creationAction(Request $request) {
        $user = new User();
        
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);
        $roles = $this->get('pilote_user.roles')->getRoles();
        //var_dump($roles);
        //var_dump($roles[2]);
        
        $formbuilder
            ->add('username', TextType::class)
            ->add('password', TextType::class)
            //->add('infos', UserInfosType::class)
            //->add('contact', UserContactType::class)
            //->add('team', UserTeamType::class)
            ->add('roles', ChoiceType::class, array('multiple' => true , 'choices' => $roles))
            ->add('bip', SubmitType::class);
        
        $form = $formbuilder->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return $this->redirect($this->generateUrl('pilote_core_homepage'));
    }
        
        return $this->render('PiloteUserBundle:Accounts:creation.html.twig', array('form' => $form->createView()));
    }
}
