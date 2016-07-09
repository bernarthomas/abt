<?php
/**
 * ListesController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/listes
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * ListesController
 *
 * Call the template that permit to create new liste and list all existing lists
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/listes
 */
class ListesController extends Controller
{
    /**
     * Show all lists
     *
     * @Route("/listes")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $isAuthenticated = $this->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        if (true !== $isAuthenticated) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('listes/index.html.twig');
    }

}
