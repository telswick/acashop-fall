<?php



namespace AcaShopBundle\Controller;

use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class OrderController deals with all things related to the order
 * @package AcaShopBundle\Controller
 */
class OrderController extends Controller
{
    /**
     * Place an order
     * @param Request $request
     * @return RedirectResponse
     */
    public function placeOrderAction(Request $request)
    {
        $submitCheck = $request->get('submit_check');

        if (empty($submitCheck) || $submitCheck != 1) {
            return new RedirectResponse('/cart');
        }

        // Place the order...
        // Create a service called OrderService
        // The service should have a method called placeOrder
        // Take everything from the cart family of tables and move it to the order table
        // Delete the contents of the cart (DB)
        // Add the completed_order_id to session
        // Redirect them to a receipt page (/receipt || /thank_you)
        //       will require table JOIN with order
        // more requirements to follow

        $order = $this->get('order');

        $order->placeOrder();

        return new RedirectResponse('/thank_you');

    }

    /**
     * @return null
     */
    public function thankYouAction()
    {
        ?>
        <br>
        <?php

        return $this->render(
            'AcaShopBundle:Checkout:show.thankyou.html.twig');


    }

}