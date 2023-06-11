<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Form\TodoType;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class TodoController extends AbstractController
{
    #[Route('/', name: 'app_todo')]
    public function index(TodoRepository $todoRepository): Response
    {

        $todos = $todoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            "todos"=>$todos
        ]);
    }



    #[Route('/todo/create',name: "todo_create")]
    public function create(Request $request, EntityManagerInterface $manager){

        $todo = new Todo();
        $form = $this->createForm(TodoType::class,$todo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $todo->setCreatedAt( new \DateTime());
            $todo->setFinished(false);
            $manager->persist($todo);
            $manager->flush();

            return $this->redirectToRoute('app_todo',['id'=>$todo->getId()]);

        }

        return $this->renderForm('todo/create.html.twig', [
            'formulaire'=>$form,
            "baseline"=>"Créer un Todo"
        ]);
    }


    #[Route('/todo/edit/{id}',name: "todo_edit")]
    public function edit(Request $request,Todo $todo, EntityManagerInterface $manager){


        $form = $this->createForm(TodoType::class,$todo);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){


            $manager->persist($todo);
            $manager->flush();

            return $this->redirectToRoute('app_todo',['id'=>$todo->getId()]);

        }

        return $this->renderForm('todo/create.html.twig', [
            'formulaire'=>$form,
            "baseline"=>"Éditer un Todo"
        ]);
    }


    #[Route("/todo/delete/{id}",name: "todo_delete")]
    public function delete(TodoRepository $todoRepository,Todo $todo, EntityManagerInterface $manager){



        if ($todo){
            $manager->remove($todo);
            $manager->flush();
        }

        $todos = $todoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            "todos"=>$todos
        ]);

    }


    #[Route("/todo/show/{id}",name: "todo_show")]
    public function show(Todo $todo){

        return $this->render("todo/show.html.twig",[
            "todo"=>$todo
        ]);

    }


    #[Route("/todo/done/{id}",name: "todo_done")]
    public function done(TodoRepository $todoRepository, Todo $todo, EntityManagerInterface $manager){


        $todo->setFinished(1);
        $manager->flush();


        $todos = $todoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            "todos"=>$todos
        ]);
    }

    #[Route("/todo/undone/{id}",name: "todo_undone")]
    public function undone(TodoRepository $todoRepository, Todo $todo, EntityManagerInterface $manager){

        $todo->setFinished(0);
        $manager->flush();


        $todos = $todoRepository->findAll();

        return $this->render('todo/index.html.twig', [
            "todos"=>$todos
        ]);
    }


}
