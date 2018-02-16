<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Valutazione\Alunno\Command\ValutazioneItemCommand;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

use Ramsey\Uuid\Uuid;

class ValutazioneItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descrizione', TextareaType::class, [
                'label' => false
            ])
        ;
        if ($options["has_valutazione_field"]) {
            $builder->add('valutazione', IntegerType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 1, 'max' => 10])
                ],
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                ]
            ]);
        }
        if ($options["has_in_media_field"]) {
            $builder->add('isInMedia', CheckboxType::class, [
                'label' => false,
                'required' => false,
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            'data_class' => ValutazioneItemCommand::class,
            'has_valutazione_field' => false,
            'has_in_media_field' => false,
            'empty_data' => function (FormInterface $form) {
                return new ValutazioneItemCommand(
                    Uuid::uuid4()
                );
            }
        ));
    }
}
