<?php

namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('slug', TextType::class, [
                'required' =>false,
                'constraints' => [
                    new Length(min: 5),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9-]+$/',
                        'message' => 'Le slug d’utilisateur ne peut contenir que des lettres, des chiffres et des tirets.',
                    ])
                ]
            ])
            ->add('content')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('duration')
            ->add('glucidesByGame')
            ->add('ProteinesByGame')
            ->add('graissesByGame')
            ->add('kcal')
            ->add('save', SubmitType::class,['label' => 'Envoyer'])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...))
            ->addEventListener(formEvents::POST_SUBMIT, $this->attachTimestamps(...) )
       ;
    }
    //Tạo slug tự động từ title
    public function autoSlug(PreSubmitEvent $event): void
    {
        $data = $event->getData();
        if (empty($data['slug'])) 
        {
            $slugger = new AsciiSlugger();
            $data['slug'] = strtolower($slugger->slug($data['Title']));
            $event->setData($data);
        }

    }
    public function attachTimestamps(PostSubmitEvent $event): void
    {
        $data = $event->getData();
        if(!($data instanceof Recipe)){
            return;
        }
        $data->setUpdatedAt(new \DateTimeImmutable());
        if (!($data->getId())){
            $data->setCreatedAt(new \DateTimeImmutable());
        }

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
