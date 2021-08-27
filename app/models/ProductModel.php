<?php

/**
 * 
 */
class ProductModel
{
	public function getProductLists() {
		return [
			'a1',
			'a2',
			'a3'
		];
	}

	public function getDetail($id) {
		$data = [
			'b1',
			'b2',
			'b3'
		];

		return $data[$id];
	}
}