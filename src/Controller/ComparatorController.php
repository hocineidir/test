<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Merchant;
use App\Entity\Product;
use Doctrine\ORM\Mapping\Entity;

class ComparatorController extends Controller
{
    /**
     * @Route("/comparator", name="comparator")
     */
    public function index()
    {
       
        $em = $this->getDoctrine()->getManager();
        //$existingproducts = $em->getRepository(Product::class)->findAll();
        
        $url = "https://www.careserve.fr/leguide-2-s1-fr-EUR.xml";
        $feed = simplexml_load_file($url);
        
        $namespace = $feed->getNamespaces(true);
                
        $products = array();
        foreach ($feed->channel->item as $item) {
            $g = $item->children($namespace["g"]);
            $product = new Product();
            // if existingproduct link patati patata
            $product->setTitle($item->title);
            $product->setDescription($item->description);
            $product->setLink($item->link);
            $product->setImagelink($g->image_link);
            $product->setPrice($g->price);
            $em->persist($product);
            array_push($products,$product);
        }
        
        $em->flush();
        
        return $this->render('comparator/index.html.twig', [
            'products' => array_slice($products, 0, 10)
        ]);   
    }
    
    /**
     * @Route("/show_products", name="show_products")
     */
    public function product_show() {
        
        $merchants = $em->getRepository(Merchant::class)->findAll();
        
        $feeds = array();
        foreach ( $merchants as $merchant) {
            $feeds[] = $merchant->getUrl();
        }
            
        return $this->render('comparator/show.html.twig', [
            'feeds' => $feeds,
        ]);
    }
    
    
}



