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
        $cart = $this->get('cart');

        $cartProducts = $cart->getAllCartProducts();

        // need to get cart_id from aca_cart_product
        $cartId = $cart->getCartId();

        // need to get user_id from aca_cart given cartId

        $userId = '
            select
                user_id
            from aca_cart
            where
             id = "' . $cartId . '"
             ';

        // need to get shipping_address_id and billing_address_id from aca_user given user_id

        $shippingId = '
            select
                shipping_address_id
            from aca_user
            WHERE
                id = "' . $userId . '"
        ';

        $billingId = '
            select
                billing_address_id
            from aca_user
            WHERE
                id = "' . $userId . '"
        ';

        // now get shipping address
        $shipQuery ='
                select
                    *
                 from aca_address
                WHERE
                    address_id = "' . $shippingId . '"
            ';

        // now get billing address
        $billQuery ='
                select
                    *
                 from aca_address
                WHERE
                    address_id = "' . $billingId . '"
            ';

        $db = $this->get('acadb');
        $shipAddress = $db->fetchRow($shipQuery,
            array('addressId' => $shippingId));
        



        $billAddress = $db->fetchRow($billQuery,
            array('addressId' => $billingId));






        return $this->render(
            'AcaShopBundle:Checkout:show.checkout.html.twig',
            array(
                'shipAddress' => $shipAddress,
                'billAddress' => $billAddress)


        );


    }



}