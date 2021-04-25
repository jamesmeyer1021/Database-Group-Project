Delimiter//
create trigger on_insert after insert on cart
for each row
begin
update product 
set product.product_quantity - 1 
where cart.product_id = product.product_id;
end//
Delimiter;

Delimiter//
create trigger on_deletion after delete on cart
for each row
begin 
update product 
set product.product_quantity+(select product_quantity from cart) 
where cart.product_id = product.product_id;
end//
Delimiter;

Delimiter//
create trigger on_update after update on cart 
for each row
begin
update product
declare update_dif integer;
set update_dif= new.product_quantity-old.product_quantity
set product.product_quantity= product_quantity - update_dif
end//
Delimiter;