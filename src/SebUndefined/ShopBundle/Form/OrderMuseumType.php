<?php

namespace SebUndefined\ShopBundle\Form;

use SebUndefined\ShopBundle\Enum\TicketTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderMuseumType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('visitDate', TextType::class, array(
            'attr' => array(
                'class' => 'datepicker date',
                'pattern' => '(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}',
                'title' => "Date au format JJ-MM-AAAA",
            ),
        ));
        $builder->add('number', IntegerType::class, array(
            'attr' => array('min' => 1, 'max' => 50)
        ));

        $builder->add('type', ChoiceType::class, array(
            'choices' => TicketTypeEnum::getAvailableTypes(),
            'choice_label' => function($choice) {
                return TicketTypeEnum::getTypeName($choice);
            }
        ));
        $builder->add('submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'SebUndefined\ShopBundle\Entity\OrderMuseum'
//        ));
//    }

    /**
     * {@inheritdoc}
     */
//    public function getBlockPrefix()
//    {
//        return 'sebundefined_shopbundle_ordermuseum';
//    }


}
