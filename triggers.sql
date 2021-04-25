DELIMITER //
CREATE TRIGGER on_insert AFTER INSERT ON cart
FOR EACH ROW
BEGIN
    UPDATE product 
    SET product.product_quantity = product.product_quantity - 1 
	  WHERE product.product_id = NEW.product_id;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER on_deletion AFTER DELETE ON cart
FOR EACH ROW
BEGIN
	  UPDATE product 
  	SET product.product_quantity = product.product_quantity + (OLD.product_quantity) 
	  WHERE product.product_id = OLD.product_id;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER on_update AFTER UPDATE ON cart 
FOR EACH ROW
BEGIN
  	DECLARE update_dif integer;
  	SET update_dif = NEW.product_quantity - OLD.product_quantity;
    UPDATE product
  	SET product.product_quantity = product.product_quantity - update_dif
    WHERE product.product_id = NEW.product_id;
END //
DELIMITER ;
