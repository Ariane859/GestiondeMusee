<?php
namespace App\Controller\Referencer;

use App\Entity\Referencer;
use App\Form\ReferencerType;
use App\Repository\ReferencerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferencerController extends AbstractController
{ 
    /**
    * @var ReferencerRepository
    */
    private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

     public function __construct(ReferencerRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    } 

    /**
    *@Route("/referencer", name="admin.referencer.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
     public function index()
    {
        $referencer = $this->repository->findAll();
        return $this->render('admin/referencer/index.php.twig', compact('referencer'));
    } 

    /**
    *@Route("/admin/referencer/create", name="admin.referencer.ajout")
    */
    public function ajout(Request $request)
    {
        $referencer = new Referencer();
        $form = $this->createForm(ReferencerType::class, $referencer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($referencer);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.referencer.index');
        }

        return $this->render('admin/referencer/ajout.php.twig', [
            'referencer' => $referencer,
            'form' => $form->createView()
        ]);

    } 

    /**
     * @Route("/admin/re/{id}", name="referencer_show", methods={"GET"})
     */
    public function show(Referencer $referencer): Response
    {
        return $this->render('/admin/referencer/show.html.twig', [
            'referencer' => $referencer,
        ]);
    }

    /**
    *@Route("/admin/referencer/{id}", name="admin.referencer.edit", methods="GET|POST")
    *@param Referencer $referencer
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
    public function edit(Referencer $referencer, Request $request)
    {
        $form = $this->createForm(ReferencerType::class, $referencer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.referencer.index');
        }

        return $this->render('admin/referencer/edit.php.twig', [
            'referencer' => $referencer,
            'form' => $form->createView()
        ]);
    }
    /**
    *@Route("/admin/referencer/{id}", name="admin.referencer.delete", methods="DELETE")
    *@param Referencer $referencer
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
    public function delete(Referencer $referencer, Request $request)
    {   
        dump('suppression');
        if($this->isCsrfTokenValid('delete'. $referencer->getId(), $request->get('_token')))
        {
            $this->em->remove($referencer);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.referencer.index');
    }
} 