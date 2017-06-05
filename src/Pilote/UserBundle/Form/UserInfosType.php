<?php

namespace Pilote\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Pilote\UserBundle\Form\UserGenderType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class UserInfosType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('required' => false))->add('firstname', TextType::class, array('required' => false))->add('gender', UserGenderType::class, array('placeholder' => 'Choose a gender',))->add('birthdate', TextType::class, array('required' => false))->add('avatar', CheckboxType::class, array('required' => false))->add('avatarURL', TextType::class, array('required' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pilote\UserBundle\Entity\UserInfos'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pilote_userbundle_userinfos';
    }


}
