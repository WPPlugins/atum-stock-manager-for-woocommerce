<?php
/**
 * @package         Atum\InventoryLogs
 * @subpackage      Items
 * @author          Salva Machí and Jose Piera - https://sispixels.com
 * @copyright       ©2017 Stock Management Labs™
 *
 * @since           1.2.4
 *
 * The model class for the Log Item Product objects
 */

namespace Atum\InventoryLogs\Items;

defined( 'ABSPATH' ) or die;


class LogItemProduct extends \WC_Order_Item_Product {

	/**
	 * The Product item data array
	 * @var array
	 */
	protected $extra_data = array(
		'product_id'   => 0,
		'variation_id' => 0,
		'quantity'     => 1,
		'tax_class'    => '',
		'subtotal'     => 0,
		'subtotal_tax' => 0,
		'total'        => 0,
		'total_tax'    => 0,
		'taxes'        => array(
			'subtotal' => array(),
			'total'    => array(),
		),
		'log_id'       => 0
	);

	/**
	 * Meta keys reserved for internal use
	 * @var array
	 */
	protected $internal_meta_keys = array( '_product_id', '_variation_id', '_qty', '_tax_class', '_line_subtotal', '_line_subtotal_tax', '_line_total', '_line_tax', '_line_tax_data', '_log_id' );

	// Load the shared methods
	use LogItemTrait;

	/**
	 * Saves an item's meta data to the database
	 * Runs after both create and update, so $id will be set
	 *
	 * @since 1.2.4
	 */
	public function save_item_data() {

		$save_values = (array) apply_filters( 'atum/inventory_logs/log_item_product/save_data', array(
			'_product_id'        => $this->get_product_id( 'edit' ),
			'_variation_id'      => $this->get_variation_id( 'edit' ),
			'_qty'               => $this->get_quantity( 'edit' ),
			'_tax_class'         => $this->get_tax_class( 'edit' ),
			'_line_subtotal'     => $this->get_subtotal( 'edit' ),
			'_line_subtotal_tax' => $this->get_subtotal_tax( 'edit' ),
			'_line_total'        => $this->get_total( 'edit' ),
			'_line_tax'          => $this->get_total_tax( 'edit' ),
			'_line_tax_data'     => $this->get_taxes( 'edit' )
		) );

		$this->log_item_model->save_meta( $save_values );

	}

}