<?php
namespace App\Controller\Musee;

use App\Entity\Musee;
use App\Form\MuseeType;
use App\Repository\MuseeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MuseeController extends AbstractController
{ 
    /**
    * @var MuseeRepository
    */
    private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

     public function __construct(MuseeRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    } 

    /**
    *@Route("/muse", name="admin.musee.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
     public function index()
    {
        $musee = $this->repository->findAll();
        return $this->render('admin/musee/index.php.twig', compact('musee'));
    }
 
    /**
    *@Route("/admin/musee/create", name="admin.musee.ajout")
    */
    public function ajout(Request $request)
    {
        $musee = new Musee();
        $form = $this->createForm(MuseeType::class, $musee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($musee);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.musee.index');
        }

        return $this->render('admin/musee/ajout.php.twig', [
            'musee' => $musee,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/mu/{id}", name="musee_show", methods={"GET"})
     */
    public function show(Musee $musee): Response
    {
        return $this->render('/admin/musee/show.html.twig', [
            'musee' => $musee,
        ]);
    }
 
    /**
    *@Route("/admin/musee/{id}", name="admin.musee.edit", methods="GET|POST")
    *@param Musee $musee
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
    public function edit(Musee $musee, Request $request)
    {
        
        
        $form = $this->createForm(MuseeType::class, $musee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.musee.index');
        }

        return $this->render('admin/musee/edit.php.twig', [
            'musee' => $musee,
            'form' => $form->createView()
        ]);
    }

    /**
    *@Route("/admin/musee/{id}", name="admin.musee.delete", methods="DELETE")
    *@param Musee $musee
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
     public function delete(Musee $musee, Request $request)
    {   
        dump('suppression');
        if($this->isCsrfTokenValid('delete'. $musee->getId(), $request->get('_token')))
        {
            $this->em->remove($musee);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.musee.index');
    }
} 