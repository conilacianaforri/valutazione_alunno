<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Valutazione\Alunno\Command\ValutazioneCommand;

class ValutazioneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('itemCommands', CollectionType::class, [
                'entry_type' => ValutazioneItemType::class,
                'allow_add' => true,
                'entry_options' => [
                    'label' => false,
                    'has_valutazione_field' => $options["data"]->hasValutazioneField(),
                    'has_in_media_field' => $options["data"]->hasInMediaField(),
                    ],
            ])
        ;
    }
    
    /**
    * {@inheritdoc}
    */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ValutazioneCommand::class,
        ]);
    }
}
