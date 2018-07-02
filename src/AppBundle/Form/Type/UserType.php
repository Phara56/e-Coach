<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 14/03/2018
 * Time: 11:55
 */

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {
    /** * {@inheritdoc} */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('username', null, array('label' => "Nom d'utilisateur", 'attr' => array('class' => 'input-field col s12')))
            ->add('email', null, array('required' => false, 'label' => 'E-mail', 'attr' => array('class' => 'input-field col s12')))
            ->add('roles', CollectionType::class, array(
                    'type' => 'choice',
                    'label' => false,
                    'options' => array(
                        'label' => 'Rôle',
                        'attr' => array('class' => 'custom-select'),
                        'choices' => array(
                            'ROLE_SUPER_ADMIN' => 'Super admin',
                            'ROLE_USER' => 'Utilisateur',
                            'ROLE_ADMIN' => 'Admin'
                        )
                    )
                )
            )
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'required' => $options['passwordRequired'],
                'first_options'  => array('label' => 'Mot de passe','attr' => array('class' => 'input-field col s12')),
                'second_options' => array('label' => 'Répétez le mot de passe','attr' => array('class' => 'input-field col s12'))
            ))
        ;
    if ($options['lockedRequired']) {
        $builder->add('locked', null, array('required' => false,
            'label' => 'Vérouiller le compte'));
    }

}

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
            'passwordRequired' => true,
            'lockedRequired' => false,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user';
    }
}