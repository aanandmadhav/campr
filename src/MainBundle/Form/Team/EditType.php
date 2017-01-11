<?php

namespace MainBundle\Form\Team;

use AppBundle\Entity\Team;
use MainBundle\Validator\Constraints\TeamSlugUsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entity = $builder->getData();
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'validation.constraints.team.name.not_blank',
                    ]),
                ],
            ])
            ->add('slug', TextType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'validation.constraints.team.slug.not_blank',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-z0-9]*([a-z0-9-]+[a-z0-9])?$/iD',
                        'message' => 'validation.constraints.team.slug.invalid',
                    ]),
                    new TeamSlugUsable([
                        'team' => $entity,
                    ]),
                ],
            ])
            ->add('logoFile', VichImageType::class, [
                'required' => false,
                'download_link' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => ['image/jpg', 'image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'validation.constraints.team.logo.image',
                    ]),
                ],
            ])
            ->add('enabled', CheckboxType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}