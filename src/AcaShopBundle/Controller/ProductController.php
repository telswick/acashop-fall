<?php
namespace AcaShopBundle\Controller;
use AcaShopBundle\Db\Database;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFpundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * 1. Write a query to get all products
     * 2. Create a template
     * 3. Hand off the data to the template
     */
    public function showProductsAction(Request $request)
    {
        //  echo "Here in the Products Controller";

        // $msg = null;
        // $session = $this->getSession();


        $query = '
            SELECT
                u.*
            FROM
                aca_product u
            ';

        // $db = new Database();
        $db = $this->get('acadb');
        $data = $db->fetchRowMany($query);


        // $data = $db->requestQuery($query);

        /*
        $row = array_pop($data);
        $product_id = $row['product_id']; //
        $name = $row['name'];
        $description = $row['description'];
        $image = $row['image'];
        $category = $row['category'];
        $price = $row['price'];
        $price = "$" . (float)$price;
        $date_added = $row['date_added'];
        */


        return $this->render(
            'AcaShopBundle:Product:all.products.html.twig',
            array('products' => $data)

        );


    }

    public function showProductDetailAction($slug)
    {
        // echo "Here in the ProductDetail Controller";


        $db = $this->get('acadb');

        $query = '
        SELECT
            *
        FROM
            aca_product
        WHERE slug= :mySlug';

        // this is like bound parameters


        $data = $db->fetchRow($query, array('mySlug' => $slug));


        return $this->render(
            'AcaShopBundle:Product:product.detail.html.twig',
            array('product' => $data)

        );


    }

}