<?php


namespace AcaShopBundle\Service;

use Simplon\Mysql\Mysql;
use AcaShopBundle\Model\Cart as CartModel;
use Symfony\Component\HttpFoundation\Session\Session;

class CartService
{

    // need to access db
    // can be anyone's class
    // should know what it does without referring to anything outside of it
    // type hinting good
    // use buys you $this->db->x   chaining


    /**
     * Database class
     * @var Mysql
     */
    protected $db;

    /**
     * Session object
     * @var Session
     */
    protected $session;


    /**
     * @var CartModel
     */
    protected $cartModel;


    public function __construct(Mysql $db, Session $session, CartModel $cart)
    {
        $this->db = $db;
        $this->session = $session;
        $this->cartModel = $cart;

        //start session if not already
        if (!$this->session->isStarted()) $this->session->start();
    }


    /**
     * Add a product to the cart
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public function addProduct($productId, $quantity)
    {

        /* do something here
        $addProduct = "
            Insert INTO
              aca_cart_product
                (product_id, qty)
              VALUES
                 ('$productId', '$quantity')";
        */

        // add stuff about getting userId

        // Check if I have a cart record?

        $cartId = $this->getCartId();

        $productPrice = $this->getProductPrice($productId);

        $subTotal = $quantity * $productPrice;


        // echo $cartId;
        // echo $productPrice;

        //$insertedId = $this->db->insert()

        $insertedId = $this->db->insert('aca_cart_product',
            array(
                'cart_id' => $cartId,
                'product_id' => $productId,
                'qty' => $quantity,
                'unit_price' => $productPrice,
                'sub_total' => $subTotal)
        );

        $this->session->save();

        return !empty($insertedId) && is_int($insertedId) ? true : false;

    }

    /**
     * Get the price of one product
     * @param int $productId
     * @return float
     */
    protected function getProductPrice($productId)
    {
     $query = 'select price from aca_product where id = "'. $productId . '"';

        $row = $this->db->fetchRow($query);

        return isset($row['price']) ? $row['price'] : null;

    }

    public function getUserId()
    {
        return $this->session->get('user_id');

    }


    /**
     * Create a cart record, and return the ID, if it doesn't exist
     * If it does exist, just return the Id
     * @throws \Exception
     * @return int
     */
    public function getCartId()
    {

        // check if user has a cart
        $userId = $this->session->get('user_id');
        if (empty($userId)) {
            throw new \Exception('You must be logged in');
        }


        $query = '
            Select
                id
            from
                aca_cart
            WHERE
                user_id = ' . $userId;

        $row = $this->db->fetchRow($query, array('userId' => $userId));

        // We have a cart record
        if (isset($row['id']) && !empty($row)) {
            return $cartId = $row['id'];
        }
        else {
            $cartId = $this->db->insert('aca_cart', array('user_id' => $userId));
            return $cartId;
        }
    }


    /**
     * Get all products that are in this user's shopping cart
     * @return array|null
     * @throws \Exception
     * should id be p.id or cp.id?
     */
    public function getAllCartProducts()
    {

        return $this->cartModel->getAllCartProducts($this->getCartId());


        /* Replace the following section with cartModel version, above
        $query = '
        select
	      cp.product_id as pid,
	      p.name,
	      p.description,
	      p.image,
	      cp.unit_price as price,
	      cp.qty,
	      cp.sub_total as sub
        from
            aca_cart_product as cp
	        inner join aca_product as p on (p.id = cp.product_id)
	        left join aca_cart as c on (c.id = cp.cart_id)
        where
	        cp.cart_id = :myCartId';


        return $this->db->fetchRowMany($query,
            array(
                'myCartId' => $this->getCartId()
            )
        );
        */

    }

    public function updateQty($cartproductId, $quantity, $cartId)
    {
        // $cartId = $this->getCartId();

        // Also need to update subtotal when updating qty

        $productPrice = $this->getProductPrice($cartproductId);

        $subTotal = $quantity * $productPrice;

        $this->db->update('aca_cart_product',
        array(
            'product_id' => $cartproductId
        ),
            array(
                'qty' => $quantity,
                'sub_total' => $subTotal
            )
        );

    }

    public function deleteItem($cartproductId, $cartId)
    {
        // $cartId = $this->getCartId();


        /*
        $query = '
            delete
              *
            from
              aca_cart_product
            where
              product_id = ' . $cartproductId;
        */

        /*
        return $this->db->delete('aca_cart_product',
            array(
                'product_id' => $productId
            )
            );
        */

        // $tablename = 'aca_cart_product';

        // echo 'cart product id: ' . $cartproductId;

        $this->db->delete('aca_cart_product', array('product_id' => $cartproductId, 'cart_id' => $cartId));


    }

    /**
     * Delete a shopping cart. Because SRP
     * @see https://en.wikipedia.org/wiki/Single_responsibility_principle
     * @throws \Exception
     */
    public function nixCart()
    {
        $cartId = $this->getCartId();

        $this->db->delete('aca_cart_product', array('cart_id' => $cartId));

        $this->db->delete('aca_cart', array('id' => $cartId));
    }

}



