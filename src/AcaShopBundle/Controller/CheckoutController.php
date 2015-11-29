<?php


namespace AcaShopBundle\Controller;

use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class CheckoutController deals with all things related to the cart
 * @package AcaShopBundle\Controller
 */
class CheckoutController extends Controller
{


    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verifyAddressAction()
    {
        $cart = $this->get('cart');           // using cart service container
        $checkout = $this->get('checkout');   // using checkout service container



        // need to get cart_id from aca_cart_product

        // $cartId = $cart->getCartId();

        // need to get user_id from aca_cart given cartId

        $userId = $checkout->getUserId();

        // $userId = '
        //     select
        //         user_id
        //     from aca_cart
        //     where
        //      id = "' . $cartId . '"
        //      ';

        // need to get shipping_address_id and billing_address_id from aca_user given user_id


        $shippingId = $checkout->getShippingAddressId($userId);
        $shippingId = array_pop($shippingId);
        $billingId = $checkout->getBillingAddressId($userId);
        $billingId = array_pop($billingId);

        // echo '<pre/>';
        // print_r($shippingId);
        // echo '<br/>';
        // print_r($billingId);

        // die('shippingId and BillingId');


        $shippingAddress = $checkout->getShippingAddress($shippingId);
        $billingAddress = $checkout->getBillingAddress($billingId);



        return $this->render(
            'AcaShopBundle:Checkout:show.checkout.html.twig',
            array(
                'shippingAddress' => $shippingAddress,
                'billingAddress' => $billingAddress)


        );


    }

    public function selectPaymentAction()
    {

        return $this->render(
            'AcaShopBundle:Checkout:select.payment.html.twig');



    }

}