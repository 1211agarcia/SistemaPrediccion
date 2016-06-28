<?php

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UserBundle\Entity\Estudiante;
use UserBundle\Form\EstudianteType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\File as FileConstraint;

/**
 * Estudiante controller.
 *
 * @Route("/estudiante")
 */
class EstudianteController extends BaseController
{
    /**
     * Authenticate a user with Symfony Security
     *
     * @param \FOS\UserBundle\Model\UserInterface        $user
     * @param \Symfony\Component\HttpFoundation\Response $response
     */
    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
    /**
     * Lists all Estudiante entities.
     *
     * @Route("/", name="estudiante_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $estudiantes = $em->getRepository('UserBundle:Estudiante')->findAll();

        return $this->render('estudiante/index.html.twig', array(
            'estudiantes' => $estudiantes,
            'CONST'=> array(
                'CARRERAS' => Estudiante::CARRERAS,
                'NIVELES_EDUCATIVOS'=> Estudiante::NIVELES_EDUCATIVOS,
                'GESTIONES_PLANTEL' => Estudiante::GESTIONES_PLANTEL,
                'TIPOS_PLANTEL' => Estudiante::TIPOS_PLANTEL,
                'NIVELES_SOCIOECONOMICOS'=> Estudiante::NIVELES_SOCIOECONOMICOS,
                'ESTADOS' => Estudiante::ESTADOS)
        ));
    }

    /**
     * Creates a new Estudiante entity.
     *
     * @Route("/new", name="estudiante_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');

        $estudiante = new Estudiante();
        $form = $this->createForm('UserBundle\Form\EstudianteType', $estudiante,
            array('action' => $this->generateUrl('estudiante_new')));
        $form->add('submit', 'submit');
        $form->handleRequest($request);

        /* Validacion de credenciales */
        /*$file = $form->get('credencial');
        $fileContraints = new FileConstraint();
        $fileContraints->maxSizeMessage = 'msg.validator.file.import.maxFileSize';
        $fileContraints->mimeTypes      = 'msg.validator.file.import.mimeType';

        $errorList = $this->get('validator')->validate($file, $fileContraints);
        if (count($errorList)) {
            $errorMessage = $errorList[0]->getMessage();
            $file->addError($errorMessage);

            // adding an error causes the form to be invalid:
            $form->isValid(); // now returns false
        }*/
        /* Estudiante de inicializa en estado de PENDIENTE */
        $estudiante->setEstado(Estudiante::PENDIENTE);
        if ($form->isSubmitted() && $form->isValid()) {
            /* Carga de archivo adjunto */
            $file = $estudiante->getCredencial();
            $fileName = $this->get('app.credencial_uploader')->upload($file);
            $estudiante->setCredencial($fileName);
            dump($estudiante);
            /* SE AGREGAN DATOS POR DEFECTO DE USUARIO DE ESTUDIANTE*/
            $estudiante->getUsuario()->setEnabled(false);
            $estudiante->getUsuario()->addRole(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();
            //Se inicia sesion con el estudiante creado.
            $token = new UsernamePasswordToken($estudiante->getUsuario(), null, "main", $estudiante->getUsuario()->getRoles());
            $this->get('security.context')->setToken($token);

            $event = new InteractiveLoginEvent($this->getRequest(), $token);
            $this->get('event_dispatcher')->dispatch('security.interactive_login', $event);

            return $this->redirectToRoute('fos_user_registration_check_email');
            
        }

        return $this->render('estudiante/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Estudiante entity.
     *
     * @Route("/{id}", name="estudiante_show")
     * @Method("GET")
     */
    public function showAction(Estudiante $estudiante)
    {
        $verifyForm = $this->createVerificationForm($estudiante);
        /*$verifyForm = $this->createForm('UserBundle\Form\EstudianteVerifyType', $estudiante,
            array('action' => $this->generateUrl('estudiante_verification', array('id' => $estudiante->getId()))));
        $verifyForm->add('submit', 'submit');*/

        return $this->render('estudiante/show.html.twig', array(
            'verify_form' => $verifyForm->createView(),
            'estudiante' => $estudiante,
            'CONST'=> array(
                'CARRERAS' => Estudiante::CARRERAS,
                'NIVELES_EDUCATIVOS'=> Estudiante::NIVELES_EDUCATIVOS,
                'GESTIONES_PLANTEL' => Estudiante::GESTIONES_PLANTEL,
                'TIPOS_PLANTEL' => Estudiante::TIPOS_PLANTEL,
                'NIVELES_SOCIOECONOMICOS'=> Estudiante::NIVELES_SOCIOECONOMICOS,
                'ESTADOS' => Estudiante::ESTADOS)
        ));
    }

    /**
     * Displays a form to edit an existing Estudiante entity.
     *
     * @Route("/{id}/edit", name="estudiante_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Estudiante $estudiante)
    {
        $editForm = $this->createForm('UserBundle\Form\EstudianteEditType', $estudiante,
            array('action' => $this->generateUrl('estudiante_edit', array('id' => $estudiante->getId()))));
        $editForm->add('submit', 'submit');

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();

            return $this->redirectToRoute('estudiante_show', array('id' => $estudiante->getId()));
        }

        return $this->render('estudiante/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $editForm->createView(),
            'edition'=>$estudiante->getId()
        ));
    }
    /**
     * Displays a form to edit an existing Estudiante entity.
     *
     * @Route("/{id}/editAvanced", name="estudiante_edit_advanced")
     * @Method({"GET", "POST"})
     */
    public function editAdvancedAction(Request $request, Estudiante $estudiante)
    {
        $editForm = $this->createForm('UserBundle\Form\EstudianteType', $estudiante,
            array('action' => $this->generateUrl('estudiante_edit_advanced', array('id' => $estudiante->getId()))));
        $editForm->add('submit', 'submit');

        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();
            dump($estudiante);
            //return $this->redirectToRoute('estudiante_prediccion', array('id' => $estudiante->getId()));
            //return $this->redirectToRoute('estudiante_show', array('id' => $estudiante->getId()));
        }

        return $this->render('estudiante/new.html.twig', array(
            'estudiante' => $estudiante,
            'form' => $editForm->createView(),
            'edition'=>$estudiante->getId(),
            'advanced' => true
        ));
    }

    /**
     * Deletes a Estudiante entity.
     *
     * @Route("/{id}", name="estudiante_prediction")
     * @Method("POST")
     */
    public function predictionAction(Request $request, Estudiante $estudiante)
    {
        $form = $this->createPredictionForm($estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($estudiante);
            $em->flush();
        }

        return $this->redirectToRoute('estudiante_index');
    }

    /**
     * Creates a form to Prediction a Estudiante entity.
     *
     * @param Estudiante $estudiante The Estudiante entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createPredictionForm(Estudiante $estudiante)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('estudiante_prediction', array('id' => $estudiante->getId())))
            ->setMethod('POST')
            ->getForm()
        ;
    }
    /**
     * Verify a estudiante entity.
     *
     * @Route("/{id}/verify", name="estudiante_verification")
     * @Method({"GET", "POST"})
     */
    public function toVerificationAction(Request $request, Estudiante $estudiante)
    {
        $form = $this->createVerificationForm($estudiante);
        $form = $this->createForm('UserBundle\Form\EstudianteVerifyType', $estudiante,
            array('action' => $this->generateUrl('estudiante_verification', array('id' => $estudiante->getId()))));
        $form->add('submit', 'submit');
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($estudiante);
            $em->flush();
            if($estudiante->getEstado() === Estudiante::VERIFICADO){
                //$this->prediction($estudiante);
            }           
        }
        return $this->redirectToRoute('estudiante_show', array('id' => $estudiante->getId()));
    }
    /**
     * Creates a form to "verificar" a estudiante entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createVerificationForm(Estudiante $estudiante)
    {
        $form = $this->createForm('UserBundle\Form\EstudianteVerifyType', $estudiante,
            array('action' => $this->generateUrl('estudiante_verification', array('id' => $estudiante->getId())),
                'attr' => array('class' =>'navbar-form navbar-left')
                )
            );
        $form->add('submit', 'submit');
        return $form;
    }


    private function prediction(Estudiante $estudiante)
    {
        echo getcwd() . "\n";
        dump(chdir('../src/AppBundle/R'));
        //file_put_contents("data.txt", shell_exec("Rscript inicio.R"));
        dump(shell_exec("Rscript inicio.R"));

        echo "inicio...";
        //echo "<pre>";
        //echo (shell_exec("Rscript my_rscript2.R"));
        //echo "</pre>";
        // current directory

        // current directory
        //echo getcwd() . "\n";
        
        //exec("php p.php");
        echo "fin...";die;
        echo getcwd() . "\n";
        dump(chdir('../src/AppBundle/R'));
        dump($estudiante);
        $objData = serialize( $estudiante);
        dump($objData);
        $filePath = getcwd().DIRECTORY_SEPARATOR."estudiante.in";
        //if (is_writable($filePath)) {
            $fp = fopen($filePath, "w") or die("Can't create file");
            fwrite($fp, $estudiante->prediction_format_file());
            fclose($fp);
        //}

        return $estudiante;
    }
}
