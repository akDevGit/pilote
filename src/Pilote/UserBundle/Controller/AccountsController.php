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
use FOS\UserBundle\Util\LegacyFormHelper;

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
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array('type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), 'options' => array('translation_domain' => 'FOSUserBundle'), 'first_options' => array('label' => 'form.password'), 'second_options' => array('label' => 'form.password_confirmation'), 'invalid_message' => 'fos_user.password.mismatch',))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('infos', UserInfosType::class)
            ->add('contact', UserContactType::class)
            ->add('team', UserTeamType::class)
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
    
    public function usersListAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('PiloteUserBundle:User');
        $usersList = $repository->findAll();
        
        return $this->render('PiloteUserBundle:Accounts:userList.html.twig', array('userList' => $usersList));
    }
}
