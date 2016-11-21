<?php

namespace MKTBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use MKTBundle\Entity\MKT;
use MKTBundle\Entity\User;

class MainController extends Controller
{
    /**
     * @Route("/mkt", name="mkt_def")
     */
    public function indexAction()
    {

        $repository = $this->getDoctrine()->getRepository('MKTBundle:MKT');
        $measurments = $repository->findAll();

        return $this->render(
            'MKTBundle:Default:index.html.twig',
            array(
                'mkt' => $measurments,
            )
        );
    }

    /**
     * @Route("mkt/calc", name="mkt_calc")
     * @Method({"GET", "POST"})
     */
    public function dataAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $data = json_decode($request->get('value'));

            $MKT = new MKT();
            $MKT->setActivationEnergy($data[0]);
            $MKT->setGasConstant($data[1]);
            $MKT->setTemperatures($data[2]);
            $MKT->calculateMKT();


            return new JsonResponse(array('data' => $MKT->getMKT()));
        }

        return new JsonResponse(array('data' => 'Data not received'));
    }

    /**
     * @Route("mkt/send", name="mkt_send")
     * @Method({"GET", "POST"})
     */
    public function sendAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $data = json_decode($request->get('value'));


            $message = \Swift_Message::newInstance()
                ->setSubject('Your MKT readings ')
                ->setFrom('send@example.com')
                ->setTo($data[4])
                ->setBody(
                    "Your readings are the following:",
                    array(
                        'Activation energy:' => $data[0],
                        'Gas constan:t' => $data[1],
                        'Tempeture values:' => $data[2],
                        'MKT:' => $data[3],
                    )
                );


            $this->get('mailer')->send($message);


            return new JsonResponse(array('data' => "Message sent"));
        }

        return new JsonResponse(array('data' => 'Data not received'));
    }

    /**
     * @Route("mkt/save", name="mkt_save")
     * @Method({"GET", "POST"})
     */
    public function saveAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $data = json_decode($request->get('value'));
            $em = $this->getDoctrine()->getManager();

            $MKT = new MKT();
            $MKT->setActivationEnergy($data[0]);
            $MKT->setGasConstant($data[1]);
            $MKT->setTemperatures($data[2]);

            $MKT->calculateMKT();
            $MKT->setDatetime(date('Y-m-d H:i:s'));


            $em->persist($MKT);


            $user = new User();
            $user->setEmail($data[4]);


            $ip = getenv('HTTP_CLIENT_IP') ?:
                getenv('HTTP_X_FORWARDED_FOR') ?:
                    getenv('HTTP_X_FORWARDED') ?:
                        getenv('HTTP_FORWARDED_FOR') ?:
                            getenv('HTTP_FORWARDED') ?:
                                getenv('REMOTE_ADDR');

            $user->setIP($ip);
            $em->persist($user);


            $em->flush();

            return new JsonResponse(array('data' => "Check DB!"));
        }

        return new JsonResponse(array('data' => 'Data not received'));
    }

    /**
     * @Route("mkt/load", name="mkt_load")
     * @Method({"GET", "POST"})
     */
    public function loadAction(Request $request)
    {
        if ($request->isXMLHttpRequest()) {

            $data = json_decode($request->get('value'));

            $repository = $this->getDoctrine()->getRepository('MKTBundle:MKT');

            $MKT = $repository->findOneByDatetime($data);

            if (!$MKT) {


                return new JsonResponse(array('data' => 'No data found '));

            }


            return new JsonResponse(
                array(
                    'mkt' => $MKT->getMKT(),
                    'E' => $MKT->getActivationEnergy(),
                    'T' => $MKT->getTemperatures(),
                    'R' => $MKT->getGasConstant(),
                )
            );
        }

        return new JsonResponse(array('data' => 'Data not received'));
    }

}
