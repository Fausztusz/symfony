<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Enum\TaskPriority;
use App\Enum\TaskStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Todo' => TaskStatus::TODO,
                    'In progress' => TaskStatus::IN_PROGRESS,
                    'Done' => TaskStatus::DONE,
                ]
            ])
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    'Low' => TaskPriority::LOW,
                    'Medium' => TaskPriority::MEDIUM,
                    'High' => TaskPriority::HIGH,
                ]
            ])
            ->add('dueDate', DateType::class, [
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y', strtotime('+3 year'))),
            ])
            ->add('assignee', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
            ])
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'title',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
