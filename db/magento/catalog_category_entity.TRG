TYPE=TRIGGERS
triggers='CREATE DEFINER=`root`@`%` TRIGGER trg_catalog_category_entity_after_insert AFTER INSERT ON catalog_category_entity FOR EACH ROW\nBEGIN\nINSERT IGNORE INTO `catalog_category_product_cl` (`entity_id`) VALUES (NEW.`entity_id`);\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER trg_catalog_category_entity_after_update AFTER UPDATE ON catalog_category_entity FOR EACH ROW\nBEGIN\nIF (NOT(NEW.`entity_id` <=> OLD.`entity_id`) OR NOT(NEW.`attribute_set_id` <=> OLD.`attribute_set_id`) OR NOT(NEW.`parent_id` <=> OLD.`parent_id`) OR NOT(NEW.`created_at` <=> OLD.`created_at`) OR NOT(NEW.`path` <=> OLD.`path`) OR NOT(NEW.`position` <=> OLD.`position`) OR NOT(NEW.`level` <=> OLD.`level`) OR NOT(NEW.`children_count` <=> OLD.`children_count`)) THEN INSERT IGNORE INTO `catalog_category_product_cl` (`entity_id`) VALUES (NEW.`entity_id`); END IF;\nEND' 'CREATE DEFINER=`root`@`%` TRIGGER trg_catalog_category_entity_after_delete AFTER DELETE ON catalog_category_entity FOR EACH ROW\nBEGIN\nINSERT IGNORE INTO `catalog_category_product_cl` (`entity_id`) VALUES (OLD.`entity_id`);\nEND'
sql_modes=0 0 0
definers='root@%' 'root@%' 'root@%'
client_cs_names='utf8' 'utf8' 'utf8'
connection_cl_names='utf8_general_ci' 'utf8_general_ci' 'utf8_general_ci'
db_cl_names='latin1_swedish_ci' 'latin1_swedish_ci' 'latin1_swedish_ci'
created=164339456995 164339456997 164339456997
