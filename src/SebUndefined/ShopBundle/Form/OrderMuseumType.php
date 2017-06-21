<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 18/06/17
 * Time: 10:01
 */

namespace SebUndefined\ShopBundle\Form;


use SebUndefined\ShopBundle\Entity\OrderMuseum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderMuseumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tickets', CollectionType::class, array(
            'entry_type' => TicketType::class,
            'allow_add' => true,
            'prototype' => true,
            'by_reference' => false
        ));
        $builder->add('submit', SubmitType::class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OrderMuseum::class,
        ));
    }
}