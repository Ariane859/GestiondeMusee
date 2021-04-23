<?php
namespace App\Controller\Visiter;

use App\Entity\Visiter;
use App\Form\VisiterType;
use App\Repository\VisiterRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiterController extends AbstractController
{
    /**
    * @var VisiterRepository
    */
    private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

    public function __construct(VisiterRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
    *@Route("/visiter", name="admin.visiter.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
    public function index()
    {
        $visiter = $this->repository->findAll();
        return $this->render('admin/visiter/index.php.twig', compact('visiter'));
    }

    /**
    *@Route("/admin/visiter/create", name="admin.visiter.ajout")
    */
    public function ajout(Request $request)
    {
        $visiter = new Visiter();
        $form = $this->createForm(VisiterType::class, $visiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($visiter);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.visiter.index');
        }

        return $this->render('admin/visiter/ajout.php.twig', [
            'visiter' => $visiter,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/vi/{id}", name="visiter_show", methods={"GET"})
     */
    public function show(Visiter $visiter): Response
    {
        return $this->render('/admin/visiter/show.html.twig', [
            'visiter' => $visiter,
        ]);
    }

    /**
    *@Route("/admin/visiter/{id}", name="admin.visiter.edit", methods="GET|POST")
    *@param Visiter $visiter
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
    public function edit(Visiter $visiter, Request $request)
    {
        $form = $this->createForm(VisiterType::class, $visiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.visiter.index');
        }

        return $this->render('admin/visiter/edit.php.twig', [
            'visiter' => $visiter,
            'form' => $form->createView()
        ]);
    }

    /**
    *@Route("/admin/visiter/{id}", name="admin.visiter.delete", methods="DELETE")
    *@param Visiter $visiter
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
    public function delete(Visiter $visiter, Request $request)
    {   
        dump('supppression');
        if($this->isCsrfTokenValid('delete'. $visiter->getId(), $request->get('_token')))
        {
            $this->em->remove($visiter);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.visiter.index');
    }
}