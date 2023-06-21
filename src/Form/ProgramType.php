<?php

namespace App\Form;

use App\Entity\Program;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;

class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il faut remplir le nom du program',
                    ]),
                    new Assert\Length([
                        'max' => 255,
                        'maxMessage' => 'Le nom saisi est trop long, il ne devrait pas dépasser {{ limit }} caractères',
                    ]),
                ], 
            ])
            ->add('synopsis', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il faut remplir la section synopsis',
                    ]),
                    new Regex([
                        'pattern' => "/plus\s+belle\s+la\s+vie/i",
                        'match' => false,
                        'message' => 'On parle de vraies séries ici',
                    ]),
                ], 
            ])
            ->add('poster', TextType::class)
            ->add('country', TextType::class)
            ->add('year', NumberType::class)
            ->add('category', null, ['choice_label' => 'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
