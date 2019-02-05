<?php
namespace App\Controller;

use App\Form\DriverType;
use App\Entity\Driver;
use App\Form\ManagerType;
use App\Entity\Manager;
use App\Form\AdminType;
use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/*https://github.com/nojacko/email-validator*/
use EmailValidator\EmailValidator;
use Doctrine\DBAL\DBALException;

class RegistrationController extends AbstractController
{

    public function registerAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {

        if ( !$request->isXmlHttpRequest() ) {
        // 1) build the form
            $user = new Admin();
            $form = $this->createForm(AdminType::class, $user);
        
            return $this->render(
                'registration/register.html.twig',
                array('form' => $form->createView())
            );
        }
        
        else  {
            $err = array();
            $email ='';

            $user = new Admin();
            
            $form = $this->createForm(AdminType::class, $user);

            $form->handleRequest($request);

            if (!$form->isValid()) {
                $response = array(
                    'result' => -1,
                    'message' => 'fail',
                    'data' => $this->getErrorMessages($form)
                );
            }
            
            if ($form->isSubmitted() && $form->isValid()) {

            $email = $form->get('email')->getData();

            /*CHECK IF EMAIL IF VALID*/
            if($email){
                $er = '';
                $validator = new \EmailValidator\Validator();
                $validator->isEmail($email) ? false : $er = 'Insert a valid email';
                $validator->isSendable($email) ? false : $er = 'Insert a valid email';
                $validator->hasMx($email) ? false : $er = 'Insert a valid email';
                $validator->hasMx($email) != null ? false : $er = 'Insert a valid email';
                $validator->isValid($email) ? false : $er = 'Insert a valid email';
                if ($er)
                    $err = array('email' => $er);
            }

            if($err)
                return new JsonResponse(array('result' => 0,'data' => $err, 'message' => 'fail'));

                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                // 4) save the User!
                $entityManager = $this->getDoctrine()->getManager();

                try {
                    $entityManager->persist($user);
                    $user->setCreatedAt(new \DateTime());
                    $entityManager->flush();
                    $response = array(
                        'result' => 1,
                        'message' => 'success',
                        'data' => $user->getId());
                return new JsonResponse($response);
                } 
                catch(DBALException $e){
                    $entityManager->rollback();
                    $response = array(
                        'result' => 0,
                        'message' => 'fail',
                        'data' => $e->getMessage());
                    return new JsonResponse($response);
                exit;
                }

                $transport = (new \Swift_SmtpTransport('smtp.sapo.pt', 465, 'ssl'))
                    ->setUsername('vgspedro@15sapo.pt')
                    ->setPassword('ledcpu');

                $mailer = new \Swift_Mailer($transport);
                        
                $subject ='Registo efetuado';

                $message = (new \Swift_Message($subject))
                    ->setFrom(['vgspedro15@sapo.pt' => 'Pedro Viegas'])
                    ->setTo([$user->getEmail() => $user->getUsername()])
                    ->addPart($subject, 'text/plain')
                    ->setBody(
                        $this->renderView(
                            'emails/register.html.twig',
                            array(
                                'username' => $user->getUsername()
                            )
                        ),
                    'text/html'
                );

                $mailer->send($message);

                return $this->redirectToRoute('home');
            }
        return new JsonResponse($response);
        }
    }


    protected function getErrorMessages(\Symfony\Component\Form\Form $form) 
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }


}

