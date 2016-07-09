<?php
/**
 * SecurityController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/login
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * SecurityController
 *
 * Used for login
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/login
 */
class SecurityController extends Controller
{
    /**
     * Call login template
     *
     * @Route("/login", name="login")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }

}
