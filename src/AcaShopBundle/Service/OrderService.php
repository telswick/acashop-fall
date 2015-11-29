<?php


namespace AcaShopBundle\Service;

use Simplon\Mysql\Mysql;
use Symfony\Component\HttpFoundation\Session\Session;
use AcaShopBundle\Service\CartService;

class OrderService
{

    /**
     * Database class
     * @var Mysql
     */
    protected $db;

    /**
     * @var CartService
     */
    protected $cart;

    /**
     * Session object
     * @var Session
     */
    protected $session;

    public function __construct(Mysql $db, Session $session, $cart)
    {
        $this->db = $db;
        $this->session = $session;
        $this->cart = $cart;

        //start session if not already
        if (!$this->session->isStarted()) $this->session->start();
    }


    public function getOrderId()
    {
        $userId = $this->session->get('user_id');
        $orderId = $this->db->insert('aca_order', array('user_id' => $userId));
        return $orderId;



    }


    /**
     * Place an order
     * @return void
     * @todo: lets send a receipt email here
     */
    public function placeOrder()
    {
        // make a query for inserting order details into the aca_order table
        // similar to inserting into the aca_cart table before (see Cart Service)

        $orderId = $this->createOrderRecord();

        $products = $this->cart->getAllCartProducts();

        // echo '<pre>';
        // print_r($products);
        // die('products array to be looped through');

        // $productPrice = $this->getProductPrice($productId);

        // $subTotal = $quantity * $productPrice;

        // grab all products in cart and loop through those doing these following insert commands
        // in array bracket notation from $products

        // removing order_id from following loop adn removed sub_total

        foreach ($products as $product) {

            $this->db->insert(
                'aca_order_product',
                array(
                    'order_id' => $orderId,
                    'product_id' => $product['pid'],
                    'quantity' => $product['qty'],
                    'price' => $product['price'],
                )
            );

        }

        // $this->session->save();

        // return !empty($completedorderId) && is_int($completedorderId) ? true : false;

        // Clear the existing cart
        $this->cart->nixCart();

        $this->session->set('completed_order_id', $orderId);




    }

    /**
     * Create a new order record and return the last inserted orderId
     * @return int
     */
    protected function createOrderRecord()
    {
        $userId = $this->session->get('user_id');
        $query = '
        insert into
            aca_order (user_id, order_date)
        values
            ('.$userId.', NOW())';
        return $this->db->executeSql($query);
    }





}
