<?php
namespace App\Controller\Moment;

use App\Entity\Moment;
use App\Form\MomentType;
use App\Repository\MomentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MomentController extends AbstractController
{ 
    /**
    * @var MomentRepository
    */
    private $repository;
    /**
    * @var EntityManagerInterface
    */
    private $em;

     public function __construct(MomentRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    } 

    /**
    *@Route("/moment", name="admin.moment.index") 
    * @return \Symfony\Component\HttpFoundation\Response
    */
     public function index()
    {
        $moment = $this->repository->findAll();
        return $this->render('admin/moment/index.php.twig', compact('moment'));
    }
 
    /**
    *@Route("/admin/moment/create", name="admin.moment.ajout")
    */
    public function ajout(Request $request)
    {
        $moment = new Moment();
        $form = $this->createForm(MomentType::class, $moment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($moment);
            $this->em->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');
            return $this->redirectToRoute('admin.moment.index');
        }

        return $this->render('admin/moment/ajout.php.twig', [
            'moment' => $moment,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/mo/{id}", name="moment_show", methods={"GET"})
     */
    public function show(Moment $moment): Response
    {
        return $this->render('/admin/moment/show.html.twig', [
            'moment' => $moment,
        ]);
    }

 
    /**
    *@Route("/admin/moment/{id}", name="admin.moment.edit", methods="GET|POST")
    *@param Moment $moment
    *@param Request $request
    * @return \Symfony\Component\HttpFoundation\Response 
    */
    public function edit(Moment $moment, Request $request)
    {
        $form = $this->createForm(MomentType::class, $moment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin.moment.index');
        }

        return $this->render('admin/moment/edit.php.twig', [
            'moment' => $moment,
            'form' => $form->createView()
        ]);
    }

    /**
    *@Route("/admin/moment/{id}", name="admin.moment.delete", methods="DELETE")
    *@param Moment $moment
    * @return \Symfony\Component\HttpFoundation\RedirectResponse 
    */
     public function delete(Moment $moment, Request $request)
    {   
        dump('supppression');
        if($this->isCsrfTokenValid('delete'. $moment->getId(), $request->get('_token')))
        {
            $this->em->remove($moment);
            $this->em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');
        }
        return $this->redirectToRoute('admin.moment.index');
    }
} 