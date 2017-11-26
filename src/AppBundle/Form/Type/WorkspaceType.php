<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Cluster;
use AppBundle\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class NoteType
 *
 * @package AppBundle\Form\Type
 */
class NoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'app.form.note.title'
            ])
            ->add('content', TextareaType::class, [
                'label'     => 'app.form.note.content',
                'required'  => false
            ])
            ->add('clusters', CollectionType::class, [
                'data_class'    => Cluster::class,
                'entry_type'    => ClusterType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'label'         => 'app.form.note.clusters'
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Note::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_note';
    }


}
