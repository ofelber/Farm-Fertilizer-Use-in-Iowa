--add a semicolon after each action in sql
--Final table to hold both nitrogen and phosphorus data, will not contain any null values
CREATE TABLE location_amount
(
	id SERIAL,
	fips_st INT NOT NULL,
	fips_co INT NOT NULL,
	state VARCHAR(50)  NOT NULL,
	co VARCHAR(50)  NOT NULL,
	location_type_id INT NOT NULL,
	nutrient_type_id INT NOT NULL,
	amount REAL NOT NULL,
	year INT NOT NULL
)

--holds the descriptions for the types of locations: farm = 1 vs nonfarm = 2
CREATE TABLE "location_type"
(
	id INT,
	description VARCHAR(50)
)

--holds the descriptions for nutrient types: nitrogen = 1 vs phosphorus = 2
CREATE TABLE nutrient_type
(
	id INT,
	description VARCHAR(50)
)

INSERT INTO location_type 
(id, description) 
VALUES (1, 'Farm')

INSERT INTO location_type 
(id, description) 
VALUES (2, 'Nonfarm')

INSERT INTO location_type 
(id, description) 
VALUES (3, 'Farm + Nonfarm')

INSERT INTO nutrient_type 
(id, description) 
VALUES (1, 'Nitrogen')

INSERT INTO nutrient_type 
(id, description) 
VALUES (2, 'Phosphorus')

INSERT INTO nutrient_type 
(id, description) 
VALUES (3, 'Nitrogen + Phosphorus')