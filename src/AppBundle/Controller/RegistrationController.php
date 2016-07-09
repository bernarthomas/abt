<?php
/**
 * RegistrationController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/utilisateur/creer
 */
namespace AppBundle\Controller;

use AppBundle\Form\UtilisateurType;
use AppBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * RegistrationController
 *
 * Let admin add a new user from the form
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/utilisateur/creer
 */
class RegistrationController extends Controller
{
    /**
     * Put new User in database when form is submitted
     *
     * @param \Symfony\Component\HttpFoundation\Request $request http request object
     *
     * @Route("/utilisateur/creer", name="utilisateur_creer")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
//        $isAuthenticated = $this->get('security.authorization_checker')
//            ->isGranted('IS_AUTHENTICATED_FULLY');
//        if (true !== $isAuthenticated) {
//            throw $this->createAccessDeniedException();
//        }
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($utilisateur, $utilisateur->getPlainPassword());
            $utilisateur->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
