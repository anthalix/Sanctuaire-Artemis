<?php

namespace App\Form;

use App\Entity\Breeds;
use App\Entity\Animals;
use App\Entity\Species;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnimalTypeForm extends AbstractType
{
    public function __construct(private FormListenerFactory $factory) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'] ?? false;

        if ($isEdit) {
            // Formulaire pour modification — uniquement les champs modifiables
            $builder
                ->add('age', IntegerType::class, [
                    'label' => 'Âge',
                    'required' => true,
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description',
                    'required' => false,
                ])
                ->add('status', ChoiceType::class, [
                    'label' => 'Statut',
                    'choices' => [
                        'Disponible' => 'disponible',
                        'Adopté' => 'adopté',
                        'Urgent' => 'urgent',
                    ],
                    'placeholder' => 'Sélectionner un statut',
                    'required' => true,
                ])
                ->add('thumbnailFile', FileType::class, [
                    'label' => 'Photo',
                    'required' => false,
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Modifier l\'Animal',
                    'attr' => ['class' => 'btn btn-primary'],
                ]);
        } else {
            // Formulaire de création — tous les champs
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Nom',
                ])
                ->add('age', IntegerType::class, [
                    'label' => 'Âge',
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Description',
                    'required' => false,
                ])
                ->add('sex', ChoiceType::class, [
                    'label' => 'Sexe',
                    'choices' => [
                        'Mâle' => 'mâle',
                        'Femelle' => 'femelle',
                    ],
                    'placeholder' => 'Sélectionnez le sexe',
                ])
                ->add('status', ChoiceType::class, [
                    'label' => 'Statut',
                    'choices' => [
                        'Disponible' => 'disponible',
                        'Adopté' => 'adopté',
                        'Urgent' => 'urgent',
                    ],
                    'placeholder' => 'Sélectionner un statut',
                ])
                ->add('taille', ChoiceType::class, [
                    'label' => 'Taille',
                    'choices' => [
                        'Petit' => 'petit',
                        'Moyen' => 'moyen',
                        'Grand' => 'grand',
                    ],
                    'placeholder' => 'Sélectionner une taille',
                ])
                ->add('child', CheckboxType::class, [
                    'label' => 'Enfant',
                    'required' => false,
                ])
                ->add('cat', CheckboxType::class, [
                    'label' => 'Chat',
                    'required' => false,
                ])
                ->add('dog', CheckboxType::class, [
                    'label' => 'Chien',
                    'required' => false,
                ])
                ->add('specie', EntityType::class, [
                    'class' => Species::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Choisir une espèce',
                    'label' => 'Espèce',
                ])
                ->add('thumbnailFile', FileType::class)
                ->add('status', ChoiceType::class, [
                    'label' => 'Statut',
                    'choices' => [
                        'Disponible' => 'disponible',
                        'Adopté' => 'adopté',
                        'Urgent' => 'urgent',
                    ],
                    'placeholder' => 'Sélectionner un statut',
                    'required' => true,
                ])
                ->add('breeds', EntityType::class, [
                    'label' => 'Races',
                    'class' => Breeds::class,
                    'choice_label' => 'name',
                    'multiple' => true,
                    'expanded' => false,
                    'required'=> false,
                ])
                ->add('newBreed', TextType::class, [
                    'label' => 'Ajouter une nouvelle race',
                    'mapped' => false,
                    'required' => false,
                ])
                ->add('save', SubmitType::class, [
                    'label' => 'Enregistrer l\'Animal',
                    'attr' => ['class' => 'btn btn-primary'],
                ]);
        }

        $builder->addEventListener(FormEvents::POST_SUBMIT, $this->factory->autoDate());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animals::class,
            'is_edit' => false,
        ]);
    }
}
