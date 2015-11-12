<?php

namespace AcaShopBundle\Controller;

use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class CartController deals with all things related to the cart
 * @package AcaShopBundle\Controller
 */
class CartController extends Controller
{




    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showCartAction()
    {
        // Write a query to fetch all the products that are in your cart
        // This query should be written in the service
        // The method should return an array of all "joined" product records with
        //  relevant information needed to render a cart

        // Get all the products from the newly created method in the CartService
        // Assign that data to the template
        // loop through the data and display a table
        // Extra: Also create the forms mentioned on the board (update, delete)

        // $cart = $this->get('cart');


        // $db = $this->get('acadb');

        /**
        $query = '
        SELECT
            *
        FROM
            aca_cart_product'
        ;
        */



        // $cartdata = $db->fetchRowMany($query);

        // $lastitem = array_pop($cartdata);

        $cart = $this->get('cart');          // trying to use CartService

        $cartProducts = $cart->getAllCartProducts();



        return $this->render(
            'AcaShopBundle:Cart:show.all.html.twig',
            array('cartProducts' => $cartProducts)


        );


    }


    public function addCartAction(Request $request)
    {
        // echo "Here in addCartAction";
        // echo "<br/>";

        // echo "Here in the Cart Controller";


        $cart = $this->get('cart');          // trying to use CartService


        $productId = $request->get('product_id');
        // echo '$productId=' . $productId;
        // echo "<br/>";

        $quantity = $request->get('qty');
        // echo '$quantity=' . $quantity;
        // echo "<br/>";

        // die('should have added to table aca_cart_product');

        // echo '<pre/>';
        // print_r($result);


        $cart->addProduct($productId, $quantity);

        return new RedirectResponse('/cart');


    }



}