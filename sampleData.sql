/* user makeups(no user_id as its auto-increment) */
insert into user( city,state,zip, address, first_name, last_name,email,password,phone_number)
values('New York', 'New York State ',10001, '1111 brooklyn avenue', 'Stan', 'Lee', 'StrongestAvenger@yahoo.com','Y1965','718-111-1111');

insert into user( city,state,zip, address, first_name, last_name,email,password,phone_number)
values('North Fort Myers', 'Florida',33917, '545 Pine Island Rd', 'Jimmy', 'Dean', 'goodEatz@gmail.com','S3345','614-559-9931');

insert into user( city,state,zip, address, first_name, last_name,email,password,phone_number)
values('North Fort Myers', 'Florida',33917, '13050 N Cleveland Ave', 'George', 'Foreman', 'GrillinDad434@yahoo.com','G4456','614-443-2251');

insert into user( city,state,zip, address, first_name, last_name,email,password,phone_number)
values('Columbus', 'Ohio',43110, '78223 Goliad rd', 'Jimmy', 'Buffet', 'RunningOutOfIdeas331@bing.com','Z5123453','614-443-2251');

insert into user( city,state,zip, address, first_name, last_name,email,password,phone_number)
values('Obetz', 'Ohio',43110, '4529 Obetz Reese Rd', 'Jimmy', 'Hendrix', 'StoneFr33@gmail.com','S11112','614-222-3344');

/* Location makeups */

insert into location(location_id, location_name, location_state)
values(1111, 'Rpg Emporium', 'Ohio');

insert into location(location_id, location_name, location_state)
values(1112, 'The Fantasy Corner', 'Texas');

insert into location(location_id, location_name, location_state)
values(1113, 'The Heros respite ', 'Florida');

insert into location(location_id, location_name, location_state)
values(1114, 'Heros last stand', 'Alabama');

insert into location(location_id, location_name, location_state)
values(1115, 'Potions and curiosities', 'North Dakota');

/* Cart Makeups */

/*
insert into cart(product_id,cart_id, product_quantity)
values(111,001,1);

insert into cart(product_id,cart_id, product_quantity)
values(112,002,5);

insert into cart(product_id,cart_id, product_quantity)
values(113,003,1);

insert into cart(product_id,cart_id, product_quantity)
values(114,004,15);

insert into cart(product_id,cart_id, product_quantity)
values(115,005,4);
*/

/*Product Makeups */

insert into product(product_id,product_name,product_type,product_brand,product_quantity,product_price)
values(111,'Energy Sword', 'Weapon', 'Halo', 1 , 200);

insert into product(product_id,product_name,product_type,product_brand,product_quantity,product_price)
values(112,'Keyblade', 'Weapon', 'Kingdom Hearts', 5 , 500);

insert into product(product_id,product_name,product_type,product_brand,product_quantity,product_price)
values(113,'Master Sword', 'Weapon', 'Zelda', 1 , 300);

insert into product(product_id,product_name,product_type,product_brand,product_quantity,product_price)
values(114,'Blue Shell', 'Weapon', 'Mario', 15 , 200);

insert into product(product_id,product_name,product_type,product_brand,product_quantity,product_price)
values(115,'Ray Gun', 'Weapon', 'Activision', 4 , 450);

/* location_stock makeups */

insert into location_stock( product_quantity, product_id, location_id)
values(1,111,1111);

insert into location_stock( product_quantity, product_id, location_id)
values(5,112,1112);

insert into location_stock( product_quantity, product_id, location_id)
values(15,113,1113);

insert into location_stock( product_quantity, product_id, location_id)
values(1,114,1114);

insert into location_stock( product_quantity, product_id, location_id)
values(4,115,1115);
