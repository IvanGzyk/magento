TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`%` TRIGGER trg_catalog_product_link_after_insert AFTER INSERT ON catalog_product_link FOR EACH ROW\nBEGIN\nINSERT IGNORE INTO `catalogsearch_fulltext_cl` (`entity_id`) VALUES (NEW.`product_id`);\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER trg_catalog_product_link_after_update AFTER UPDATE ON catalog_product_link FOR EACH ROW\nBEGIN\nIF (NOT(NEW.`link_id` <=> OLD.`link_id`) OR NOT(NEW.`product_id` <=> OLD.`product_id`) OR NOT(NEW.`linked_product_id` <=> OLD.`linked_product_id`) OR NOT(NEW.`link_type_id` <=> OLD.`link_type_id`)) THEN INSERT IGNORE INTO `catalogsearch_fulltext_cl` (`entity_id`) VALUES (NEW.`product_id`); END IF;\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER trg_catalog_product_link_after_delete AFTER DELETE ON catalog_product_link FOR EACH ROW\nBEGIN\nINSERT IGNORE INTO `catalogsearch_fulltext_cl` (`entity_id`) VALUES (OLD.`product_id`);\nEND'
sql_modes=0 0 0
definers='root@%' 'root@%' 'root@%'
client_cs_names='utf8' 'utf8' 'utf8'
connection_cl_names='utf8_general_ci' 'utf8_general_ci' 'utf8_general_ci'
db_cl_names='latin1_swedish_ci' 'latin1_swedish_ci' 'latin1_swedish_ci'
created=164339457197 164339457198 164339457199
