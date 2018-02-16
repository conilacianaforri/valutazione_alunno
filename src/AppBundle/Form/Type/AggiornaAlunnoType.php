<?php

namespace AppBundle\Form\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Valutazione\Alunno\Command\AggiornaAlunnoCommand;

class AggiornaAlunnoType extends BaseAlunnoType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => AggiornaAlunnoCommand::class,
        ));
    }
}
