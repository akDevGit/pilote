<?php

namespace Pilote\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adress', TextType::class, array('required' => false))->add('secundaryAddress', TextType::class, array('required' => false))->add('zipcode', TextType::class, array('required' => false))->add('email', TextType::class, array('required' => false))->add('phone', TextType::class, array('required' => false))->add('cellphone', TextType::class, array('required' => false))->add('skype', TextType::class, array('required' => false));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pilote\UserBundle\Entity\UserContact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pilote_userbundle_usercontact';
    }


}
