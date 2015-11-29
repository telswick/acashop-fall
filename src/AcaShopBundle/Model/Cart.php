<?php
namespace AcaShopBundle\Model;

class Cart extends AbstractModel
{
    /**
     * Get all products that are in my shopping cart
     * @param int $cartId PK for the shopping cart
     * @return array|null
     */
    public function getAllCartProducts($cartId)
    {
        // replaced query with my own version
        //
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
                'myCartId' => $cartId
            )
        );
    }
}