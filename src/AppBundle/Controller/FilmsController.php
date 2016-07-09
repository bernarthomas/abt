<?php
/**
 * FilmsController class file
 *
 * PHP Version 7.0.4
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/films
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * FilmsController class file
 *
 * Call the template that list all existing movies links
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/films
 */
class FilmsController extends Controller
{
    /**
     * Show list of movies direct access links
     *
     * @Route("films")
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
        
        return $this->render('films/index.html.twig');
    }

}
