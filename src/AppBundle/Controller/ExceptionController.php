<?php
/**
 * ExceptionController class file
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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use  \Symfony\Bundle\TwigBundle\Controller\ExceptionController as Exception;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/**
 * ExceptionController class file
 *
 * Permit to play flash message in main layout
 *
 * @category Controller
 * @package  Controller
 * @author   Bernard Thomas <bernarthomas@free.fr>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://abt/
 */
class ExceptionController extends Exception
{

    protected $session;

    /**
     * ExceptionController constructor.
     *
     * @param Twig_Environment $twig    Stores the configuration.
     * @param Bool             $debug   Show error (false) or exception (true) pages
     * @param SessionInterface $session Current Session object
     */
    public function __construct(
        \Twig_Environment $twig,
        $debug,
        SessionInterface $session
    ) {
        parent::__construct($twig, $debug);
        $this->session = $session;
    }

    /**
     * Redirect to homepage in displaying flash message
     *
     * @param Request              $request   The request
     * @param FlattenException     $exception A FlattenException instance
     * @param DebugLoggerInterface $logger    A DebugLoggerInterface instance
     *
     * @return Response
     */
    public function showAction(
        Request $request,
        FlattenException $exception,
        DebugLoggerInterface $logger = null
    ) {

        $this->session->getFlashBag()->add(
            'info',
            'La page que vous demandez n\'existe pas.'
        );

        $response = new Response();

        return $response->setContent($this->twig->render('home/index.html.twig'));
    }
}
