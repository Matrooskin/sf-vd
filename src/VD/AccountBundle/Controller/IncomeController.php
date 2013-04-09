<?php

namespace VD\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

use VD\AccountBundle\Entity\Income;
use VD\AccountBundle\Form\Account\IncomeForm;

class IncomeController extends Controller
{
    public function addAction(Request $request)
    {
        $income = new Income();

        $timeZone = new \DateTimeZone('Europe/Vilnius');
        $date = new \DateTime('now', $timeZone);
        $income->setDate($date);

        $income->setPerson($this->getUser());

        $form = $this->createForm(new IncomeForm(), $income);

//        if ($request->isMethod('POST')) {
//            $form->bind($request);
//
//            if ($form->isValid()) {
                // perform some action, such as saving the task to the database
//                $user = $form->getData();
//                $em = $this->getDoctrine()->getManager();
//                $oUser = $em->getRepository('VDAccountBundle:User')
//                    ->findByEmail($user->getEmail());
//                if ($oUser) {
//                    return $this->render('VDAccountBundle:Default:register.html.twig',
//                        array('form' => $form->createView(), 'error' => 'Vartotojas jau egzistuoja'));
//                }
//
//                $factory = $this->get('security.encoder_factory');
//                $encoder = $factory->getEncoder($user);
//                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
//                $user->setPassword($password);
//
//                $em->persist($user);
//                $em->flush();
//
//                return $this->redirect($this->generateUrl('vd_account_register_success'));
//            }
//        }

        return $this->render('VDAccountBundle:Default:incomeAdd.html.twig', array('form' => $form->createView()));
    }
}
