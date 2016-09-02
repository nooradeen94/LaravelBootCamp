<?php
class product {
    private $name;
    private $price;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


}
class CartItem {
    Private $CQuantity;

    /**
     * @return mixed
     */
    public function getCQuantity()
    {
        return $this->CQuantity;
    }

    /**
     * @param mixed $CQuantity
     */
    public function setCQuantity($CQuantity)
    {
        $this->CQuantity = $CQuantity;
    }

    /**
     * @return mixed
     */
    public function getCproduct()
    {
        return $this->Cproduct;
    }

    /**
     * @param mixed $Cproduct
     */
    public function setCproduct($Cproduct)
    {
        $this->Cproduct = $Cproduct;
    }
    Private $Cproduct ;



}
class Cart {
    public $stack = array();
    public function AddToCart($pro,$NQuantity){ //NQuantity is the needed quantity
        //print_r(count($this->stack));
        if (!$pro instanceof product) {
            return false;
        }
        if (empty($this->stack))
        {
                $Item = new CartItem();
                $Item->setCproduct($pro);
                $Item->setCQuantity($NQuantity);
                array_push($this->stack,$Item);
        }
        else
        {
            foreach ($this->stack as $key=>$value)
            {
                $NewProduct =$pro->getName();
                $CurrentProduct = $this->stack [$key]->getCproduct()->getName();
                if ( strcmp($CurrentProduct,$NewProduct) == 0)
                {
                    print_r('Product exists');
                    $Quantity = $this->stack[$key]->getCQuantity();
                    $this->stack[$key]->setCQuantity($NQuantity+$Quantity);
                    
                }
                else
                {
                    $Item = new CartItem();
                    $Item->setCproduct($pro);
                    $Item->setCQuantity($NQuantity);
                    array_push($this->stack,$Item);
                }
            }
        }
        return true;
    } //eof AddToCart
    public function getQuantity(){
        $Sum =0;
        foreach ($this->stack as $key=>$value){
            $Sum+=$this->stack[$key]->getCQuantity();
        }
        return $Sum;
    }
    public function getNumOfItem(){
        $Sum =0;
        foreach ($this->stack as $key=>$value){
            $Sum+=1;
        }
        return $Sum;
    }
    public function ViewCart(){
        return $this->stack;
    }//eof ViewCart
}

use PHPUnit\Framework\TestCase;
class CartTest extends TestCase
{
    /** @test */
    public function product_limttation()
    {
        $prod1 = new product();
        $prod1->setName('Product A');
        $prod1->setPrice(10);
        $prod2 = new product();
        $prod2->setName('Product B');
        $prod2->setPrice(10);
        $cart = new Cart();
        $this->assertEquals(true, $cart->AddToCart($prod1,1));
        $this->assertEquals(true, $cart->AddToCart($prod2,1));
    }
    /** @test */
    public function product_quantity()
    {
        $prod = new product();
        $prod->setName('Product A');
        $prod->setPrice(10);
        $cart = new Cart();
        $cart->AddToCart($prod,5);
        print_r('number of products in cart is '.$cart->getQuantity());
        $this->assertGreaterThan(0, $cart->getQuantity());
    }
    /** @test */
    public function add_new_product_or_increase_quantity()
    {
        $cart = new Cart();
        $product1 = new product();
        $product1->setPrice(3);
        $product1->setName("Product A");
        $cart->AddToCart($product1,1);
        $cart->AddToCart($product1,1);
        $this->assertNotEquals(1,$cart->getNumOfItem());
        print_r($cart->ViewCart());

    }
}