<?php

namespace yh\blogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class usersType extends AbstractType {

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        //$builder->add('email')->add('dateCreation')        ;
        $builder->add('email', TextType::class, array(
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Email',
    )))->add("password", PasswordType::class, array(
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'Mot de passe',
        )));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'yh\blogBundle\Entity\users'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix() {
        return 'yh_blogbundle_users';
    }

}
