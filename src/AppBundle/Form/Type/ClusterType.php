<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Cluster;
use AppBundle\Entity\Workspace;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ClusterType
 *
 * @package AppBundle\Form\Type
 */
class ClusterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'app.form.cluster.title'
            ])
            ->add('workspace', EntityType::class, [
                'class'         => Workspace::class,
                'choice_label'  => 'title',
                'label'         => 'app.form.cluster.workspace'
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Cluster::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cluster';
    }
}
