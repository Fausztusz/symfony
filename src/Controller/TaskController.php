<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task')]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
        $limit = $request->query->getInt('limit', 10);

        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->paginate(
                $request->query->getInt('page', 1),
                $limit,
            ),
        ]);
    }

    #[Route('/task/create', name: 'task.create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/task/{id}', name: 'task.update')]
    public function update(?Task $task, Request $request, EntityManagerInterface $em): Response
    {
        if (null === $task) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('task');
        }

        return $this->render('task/create.html.twig', [
            'form' => $form,
            'id' => $task->getId(),
        ]);
    }

    #[Route('/task/{id}/delete', name: 'task.delete',)]
    public function delete(?Task $task, EntityManagerInterface $em): RedirectResponse
    {
        if (null === $task) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $em->remove($task);
        $em->flush();
        return $this->redirectToRoute('task');
    }
}
