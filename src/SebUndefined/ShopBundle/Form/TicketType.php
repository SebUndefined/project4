<?php
/**
 * Created by PhpStorm.
 * User: sebby
 * Date: 18/06/17
 * Time: 09:55
 */

namespace SebUndefined\ShopBundle\Form;


use SebUndefined\ShopBundle\Entity\Ticket;
use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName', TextType::class, array(
                    'label' => "Prénom"
                ))
                ->add('lastName', TextType::class, array(
                    'label' => "Nom"
                ))
                ->add('country', CountryType::class, array(
                    'label' => "Pays"
                ))
                ->add('birthDate', BirthdayType::class, array(
                    'format' => 'dd-MM-yyyy',
                    'label' => 'Date de naissance'
                ))
                ->add('discountTicket', CheckboxType::class, array(
                    'label' => "Tarif réduit ?"
                ));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ticket::class,
        ));
    }
}