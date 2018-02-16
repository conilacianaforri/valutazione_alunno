<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Valutazione\Alunno\Command\AggiungiAlunnoCommand;

class AggiungiAlunnoType extends BaseAlunnoType
{
    /**
    * {@inheritdoc}
    */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('materia', EntityType::class, [
                'class' => 'Valutazione\Alunno\Entity\Materia',
                'placeholder' => '--'
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => AggiungiAlunnoCommand::class,
        ));
    }
}
