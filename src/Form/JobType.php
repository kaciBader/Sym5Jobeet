<?php

namespace App\Form;

use App\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('type', ChoiceType::class, [
                'choices' => Job::getTypes(), 
                'expanded' => true
            ]) */
            ->add('category')
            ->add('type')
            ->add('company')
            //->add('logo',null, array('label' => 'Company logo'))
            ->add('file', FileType::class, array('label' => 'Company logo', 'required' => false))
            ->add('url')
            ->add('position')
            ->add('location')
            ->add('description')
            ->add('how_to_apply',null, array('label' => 'How to apply?'))
           // ->add('token')
            ->add('is_public', null, array('label' => 'Public?'))
             
            ->add('email')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
