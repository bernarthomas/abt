<?php
/**
 * HomeController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/
 */
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * HomeController class file
 *
 * Homepage
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/
 */
class HomeController extends Controller
{
    /**
     * Home page
     *
     * @param Request $request http request object
     *
     * @Route("/", name="homepage")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $isAuthenticated = $this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        if (true !== $isAuthenticated) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('home/index.html.twig');
    }
}
