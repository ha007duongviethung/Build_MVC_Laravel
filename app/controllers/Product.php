<?php 

/**
 * 
 */
class Product extends Controller
{
	public $data = [];

	public function index() {
		echo "List product: ";
	}

	public function listProduct() {
		$product = $this->model('ProductModel');
		$dataProduct = $product->getProductLists();

		$title = "List Product";

		$this->data['sub_content']['listProduct'] = $dataProduct;
		$this->data['sub_content']['titleProduct'] = $title;
		$this->data['page_title'] = $title;

		$this->data['content'] = 'products/list';

		// Render views
		$this->render('layouts/client_layout', $this->data);
	}

	public function detail($id=0) {
		$product = $this->model('ProductModel');
		$this->data['sub_content']['info'] = $product->getDetail($id);
		$this->data['sub_content']['title'] = 'Product Detail';
		$this->data['page_title'] = 'Product Detail';
		$this->data['content'] = 'products/detail';
		$this->render('layouts/client_layout', $this->data);
	}
	
}