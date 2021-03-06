CREATE TABLE `location`
(
	location_id INT NOT NULL,
	location_name VARCHAR(255) NOT NULL,
	location_state VARCHAR(255) NOT NULL,
	PRIMARY KEY (location_id)
);

CREATE TABLE `user`
(
	city VARCHAR(255) NOT NULL,
	state VARCHAR(255) NOT NULL,
	zip VARCHAR(255) NOT NULL,
	address VARCHAR(255) NOT NULL,
	first_name VARCHAR(255) NOT NULL,
	last_name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL,
	user_id INT NOT NULL AUTO_INCREMENT,
	password VARCHAR(255) NOT NULL,
	phone_number VARCHAR(255) NOT NULL,
	PRIMARY KEY (user_id)
);

CREATE TABLE `product`
(
	product_id INT NOT NULL,
	product_name VARCHAR(255) NOT NULL,
	product_type VARCHAR(255) NOT NULL,
	product_brand VARCHAR(255) NOT NULL,
	product_quantity INT NOT NULL,
	product_price INT NOT NULL,
	location_id INT NOT NULL,

	PRIMARY KEY (product_id),
	FOREIGN KEY (location_id) REFERENCES location(location_id)

);

CREATE TABLE `cart`
(
	product_id INT NOT NULL,
	user_id INT NOT NULL,
	product_quantity INT NOT NULL,
	PRIMARY KEY (product_id, user_id),
	FOREIGN KEY (product_id) REFERENCES product(product_id),
	FOREIGN KEY (user_id) REFERENCES user(user_id)
);
