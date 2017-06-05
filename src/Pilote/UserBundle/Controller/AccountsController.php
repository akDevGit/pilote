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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class AccountsController extends Controller
{
    public function creationAction(Request $request) {
        $user = new User();
        
        $formbuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);
        $registredRoles = $this->get('pilote_user.roles')->getRoles();
        $roles = [];
        foreach ($registredRoles as $thisRole) {
            $roles[$thisRole]= $thisRole;
        }
        
        if (!$this->get('security.context')->isGranted('ROLE_PO')) {
            var_dump('lalala');
        }
        
        $formbuilder
            ->add('username', TextType::class)
            ->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array('type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'), 'options' => array('translation_domain' => 'FOSUserBundle'), 'first_options' => array('label' => 'form.password'), 'second_options' => array('label' => 'form.password_confirmation'), 'invalid_message' => 'fos_user.password.mismatch',))
            ->add('email', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'), array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('infos', UserInfosType::class)
            ->add('contact', UserContactType::class)
            ->add('team', UserTeamType::class)
            ->add('roles', ChoiceType::class, array('multiple' => true , 'choices' => $roles))
            ->add('enabled', CheckboxType::class, array('required' => false, 'data' => true))
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
        if ($this->get('security.context')->isGranted('ROLE_SWITCHBOARD')) {
            var_dump('you gat it');
        }
        
        $repository = $this->getDoctrine()->getManager()->getRepository('PiloteUserBundle:User');
        $usersList = $repository->findAll();
        
        return $this->render('PiloteUserBundle:Accounts:userList.html.twig', array('usersList' => $usersList));
    }
    
    public function recordAction ($id) {
        $repository = $this->getDoctrine()->getManager()->getRepository('PiloteUserBundle:User');
        $userRecord = $repository->find($id);
        
        return $this->render('PiloteUserBundle:Accounts:record.html.twig', array('userRecord' => $userRecord));
    }
}
