<?php
    namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType {
    public function buildForm( FormBuilderInterface $builder, array $options) {
        $builder
        ->add('first_name', TextType::class, [
            'attr' => [
                'placeholder' => 'Your First name'
            ]
        ])
        ->add('last_name', TextType::class, [
            'attr' => [
                'placeholder' => 'Your Last name'
            ]
        ])
        ->add('email', EmailType::class, [
            'attr' => [
                'placeholder' => 'exemple@exemple.com'
            ]
        ])
        ->add('password', PasswordType::class, [
            'attr' => [
                'placeholder' => 'Your password'
            ]
        ])
        ->add('age', NumberType::class, [
            'attr' => [
                'placeholder' => 'Your age exp: 18'
            ]
        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'fluid'
            ]
        ])
        ->getForm();
    }
}


?>