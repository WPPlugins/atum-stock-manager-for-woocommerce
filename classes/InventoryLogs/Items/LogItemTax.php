<?php
/**
 * @package         Atum\InventoryLogs
 * @subpackage      Items
 * @author          Salva Machí and Jose Piera - https://sispixels.com
 * @copyright       ©2017 Stock Management Labs™
 *
 * @since           1.2.4
 *
 * The model class for the Log Item Tax objects
 */

namespace Atum\InventoryLogs\Items;

defined( 'ABSPATH' ) or die;


class LogItemTax extends \WC_Order_Item_Tax {

	/**
	 * The Tax item data array
	 * @var array
	 */
	protected $extra_data = array(
		'rate_code'          => '',
		'rate_id'            => 0,
		'label'              => '',
		'compound'           => FALSE,
		'tax_total'          => 0,
		'shipping_tax_total' => 0,
		'log_id'             => 0
	);

	protected $internal_meta_keys = array( '_rate_id', '_label', '_compound', '_tax_amount', '_shipping_tax_amount', '_log_id' );

	// Load the shared methods
	use LogItemTrait;

	/**
	 * Saves an item's meta data to the database
	 * Runs after both create and update, so $id will be set
	 *
	 * @since 1.2.4
	 */
	public function save_item_data() {

		$save_values = (array) apply_filters( 'atum/inventory_logs/log_item_tax/save_data', array(
			'_rate_id'             => $this->get_rate_id( 'edit' ),
			'_label'               => $this->get_label( 'edit' ),
			'_compound'            => $this->get_compound( 'edit' ),
			'_tax_amount'          => $this->get_tax_total( 'edit' ),
			'_shipping_tax_amount' => $this->get_shipping_tax_total( 'edit' )
		) );

		$this->log_item_model->save_meta( $save_values );

	}

}