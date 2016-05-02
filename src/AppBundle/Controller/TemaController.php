<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Tema;
use AppBundle\Form\TemaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Tema controller.
 *
 * @Route("/tema")
 */
class TemaController extends Controller
{
    /**
     * Lists all Tema entities.
     *
     * @Route("/", name="tema_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $temas = $em->getRepository('AppBundle:Tema')->findAll();

        return $this->render('tema/index.html.twig', array(
            'temas' => $temas,
        ));
    }

    /**
     * Creates a new Tema entity.
     *
     * @Route("/new", name="tema_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tema = new Tema();
        $form = $this->createForm('AppBundle\Form\TemaType', $tema,
            array('action' => $this->generateUrl('tema_new')));
        $form->add('submit', 'submit');
            
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tema);
            $em->flush();

            return $this->redirectToRoute('tema_show', array('id' => $tema->getId()));
        }

        return $this->render('tema/new.html.twig', array(
            'tema' => $tema,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Tema entity.
     *
     * @Route("/{id}", name="tema_show")
     * @Method("GET")
     */
    public function showAction(Tema $tema)
    {
        return $this->render('tema/show.html.twig', array(
            'tema' => $tema,
        ));
    }

    /**
     * Displays a form to edit an existing Tema entcity.
     *
     * @Route("/{id}/edit", name="tema_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tema $tema)
    {
        //$deleteForm = $this->createDeleteForm($tema);
        $editForm = $this->createForm('AppBundle\Form\TemaType', $tema,
            array('action' => $this->generateUrl('tema_edit', array('id' => $tema->getId()))));
        $editForm->add('submit', 'submit');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            dump(get_class($tema));
            dump($tema);
            /*Gracia Divina, esto DA!*/
            foreach ($tema->getPadres() as $actual) {
                $actual->addHijo($tema);
            }
            //$em->persist($tema);
            $em->flush();

            return $this->redirectToRoute('tema_show', array('id' => $tema->getId()));
        }

        return $this->render('tema/new.html.twig', array(
            'tema' => $tema,
            'form' => $editForm->createView(),
            'edition' => $tema->getId(),
        ));
    }
}
