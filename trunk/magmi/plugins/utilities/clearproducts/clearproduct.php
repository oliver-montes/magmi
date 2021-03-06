<?php
class ClearProductUtility extends Magmi_UtilityPlugin
{
	public function getPluginInfo()
	{
		return array("name"=>"Clear Catalog",
					 "author"=>"Dweeves",
					 "version"=>"1.0.2");
	}
	
	public function runUtility()
	{
		$sql="SET FOREIGN_KEY_CHECKS = 0";
		$this->exec_stmt($sql);
		$tables=array("catalog_product_bundle_option",
					  "catalog_product_bundle_option_value",
					  "catalog_product_bundle_selection",
					  "catalog_product_entity_datetime",
					  "catalog_product_entity_decimal",
					  "catalog_product_entity_gallery",
					  "catalog_product_entity_int",
					  "catalog_product_entity_media_gallery",
					  "catalog_product_entity_media_gallery_value",
					  "catalog_product_entity_text",
					  "catalog_product_entity_tier_price",
					  "catalog_product_entity_varchar",
					  "catalog_product_entity",
					  "catalog_product_option",
					  "catalog_product_option_price",
					  "catalog_product_option_title",
					  "catalog_product_option_type_price",
					  "catalog_product_option_type_title",
					  "catalog_product_option_type_value",		
					  "catalog_product_super_attribute_label",
					  "catalog_product_super_attribute_pricing",
					  "catalog_product_super_attribute",
					  "catalog_product_super_link",
					  "catalog_product_link",
					  "catalog_product_link_attribute_varchar",
					  "catalog_product_link_attribute_int",
		
					  "catalog_product_relation",
					  "catalog_product_enabled_index",
					  "catalog_product_website",
					  "catalog_category_product_index",
					  "catalog_category_product",
					  "cataloginventory_stock_item",
					  "cataloginventory_stock_status");
		
		//Bugfix , add catalog product flat tables to clear products
		$sql="SELECT store_id FROM ".$this->tablename("core_store")." WHERE store_id!=0";
		$result=$this->selectAll($sql);
		foreach($result as $sids)
		{
			$tables[]="catalog_product_flat_".$sids["store_id"];
		}
		
		foreach($tables as $table)
		{
			$this->exec_stmt("TRUNCATE TABLE `".$this->tablename($table)."`");
		}

		$sql="SET FOREIGN_KEY_CHECKS = 1";

		$this->exec_stmt($sql);
		echo "Catalog cleared";
	}
	
	public function getWarning()
	{
		return "Are you sure?, it will destroy all existing items in catalog!!!";
	}
	public function getShortDescription()
	{
		return "This Utility clears the catalog";	
	}
}