<?php
namespace AcaShopBundle\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCartAction(Request $request)
    {

        echo "Here in the Cart Controller";

        return $this->render(
            'AcaShopBundle:CartsForm:cart-form.html.twig'

        );


    }
}