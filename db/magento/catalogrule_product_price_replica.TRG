TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`%` TRIGGER trg_catalogrule_product_price_replica_after_insert AFTER INSERT ON catalogrule_product_price_replica FOR EACH ROW\nBEGIN\nINSERT IGNORE INTO `catalog_product_price_cl` (`entity_id`) VALUES (NEW.`product_id`);\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER trg_catalogrule_product_price_replica_after_update AFTER UPDATE ON catalogrule_product_price_replica FOR EACH ROW\nBEGIN\nIF (NOT(NEW.`rule_product_price_id` <=> OLD.`rule_product_price_id`) OR NOT(NEW.`rule_date` <=> OLD.`rule_date`) OR NOT(NEW.`customer_group_id` <=> OLD.`customer_group_id`) OR NOT(NEW.`product_id` <=> OLD.`product_id`) OR NOT(NEW.`rule_price` <=> OLD.`rule_price`) OR NOT(NEW.`website_id` <=> OLD.`website_id`) OR NOT(NEW.`latest_start_date` <=> OLD.`latest_start_date`) OR NOT(NEW.`earliest_end_date` <=> OLD.`earliest_end_date`)) THEN INSERT IGNORE INTO `catalog_product_price_cl` (`entity_id`) VALUES (NEW.`product_id`); END IF;\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER trg_catalogrule_product_price_replica_after_delete AFTER DELETE ON catalogrule_product_price_replica FOR EACH ROW\nBEGIN\nINSERT IGNORE INTO `catalog_product_price_cl` (`entity_id`) VALUES (OLD.`product_id`);\nEND'
sql_modes=0 0 0
definers='root@%' 'root@%' 'root@%'
client_cs_names='utf8' 'utf8' 'utf8'
connection_cl_names='utf8_general_ci' 'utf8_general_ci' 'utf8_general_ci'
db_cl_names='latin1_swedish_ci' 'latin1_swedish_ci' 'latin1_swedish_ci'
created=164339457084 164339457085 164339457086
