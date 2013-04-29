<?php

namespace VD\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use JMS\SecurityExtraBundle\Annotation\Secure;
use VD\AccountBundle\Form\User\RegisterUser;
use VD\AccountBundle\Entity\User;

class DefaultController extends Controller
{
    public function registerAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(new RegisterUser(), $user);

        if ($request->isMethod('POST')) {
            $form->bind($request);


            $data = $form->get('equation');
            if ($data->getData() !== '6') {
                $data->addError(new FormError('Pasikartokite penktos klasės matematikos kursą'));
            } elseif ($form->isValid()) {
                // perform some action, such as saving the task to the database
                $user = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $oUser = $em->getRepository('VDAccountBundle:User')
                    ->findByEmail($user->getEmail());
                if ($oUser) {
                    return $this->render(
                        'VDAccountBundle:Default:register.html.twig',
                        array('form' => $form->createView(), 'error' => 'Vartotojas jau egzistuoja')
                    );
                }

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();

                return $this->redirect($this->generateUrl('vd_account_register_success'));
            }
        }

        return $this->render('VDAccountBundle:Default:register.html.twig', array('form' => $form->createView()));
    }

    public function registerSuccessAction()
    {
        return $this->render('VDAccountBundle:Default:register_success.html.twig');
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
            'VDAccountBundle:Default:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                'error' => $error,
            )
        );
//        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
//            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
//        } else {
//            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
//        }
//
//        return array(
//            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
//            'error'         => $error,
//        );

//        $user = new User();

//        $form = $this->createFormBuilder($user)
//            ->add('email', 'text')
//            ->add('password', 'password')
//            ->getForm();

//        if ($request->isMethod('POST')) {
//            $form->bind($request);
//
//            if ($form->isValid()) {
//                // perform some action, such as saving the task to the database
//
//                return $this->redirect($this->generateUrl('task_success'));
//            }
//        }
//        return $this->render('VDAccountBundle:Default:login.html.twig', array('form' => $form->createView()));
    }

//slaptazodzio sukurimui
//$factory = $this->get('security.encoder_factory');
//$user = new Acme\UserBundle\Entity\User();
//
//$encoder = $factory->getEncoder($user);
//$password = $encoder->encodePassword('ryanpass', $user->getSalt());
//$user->setPassword($password);

    public function indexAction()
    {
        return $this->render('VDAccountBundle:Default:index.html.twig');
    }
}
