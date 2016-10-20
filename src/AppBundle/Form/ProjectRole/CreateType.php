<?php

namespace AppBundle\Form\ProjectRole;

use AppBundle\Entity\ProjectRole;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CreateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'validation.constraints.general_field.name.not_blank',
                    ]),
                ],
            ])
            ->add('sequence', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'validation.constraints.general_field.sequence.not_blank',
                    ]),
                    new Regex([
                        'pattern' => '/^([1-9]+\d*)$|^0$/',
                        'message' => 'validation.constraints.general_field.sequence.invalid',
                    ]),
                ],
            ])
            ->add('isLead', CheckboxType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectRole::class,
        ]);
    }
}
