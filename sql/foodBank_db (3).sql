

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




--
-- Database: `foodbank_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE IF NOT EXISTS `donors` (
  `donor_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `phoneNumber` varchar(80) NOT NULL,
  `zipCode` varchar(25) NOT NULL,
  `type` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`donor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`donor_id`, `name`, `email`, `password`, `phoneNumber`, `zipCode`, `type`) VALUES
(1, 'Keri', 'Keri123@gmail.com', 'Keri', '631-951-8699', '11746', 1),
(2, 'Yoel', 'Yoel123@gmail.com', 'Yoel', '555-321-5959', '11369', 0),
(3, 'Timmy', 'Timmy123@gmail.com', 'Timmy', '777-856-9841', '11964', 1),
(4, 'Luke', 'Luke123@gmail.com', 'Luke', '999-231-1900', '11356', 0),
(5, 'Josh', 'Josh123@gmail.com', 'Josh', '856-454-8700', '11568', 0),
(6, 'Sebastian', 'Sebastian123@gmail.com', 'Sebastian', '999-231-1900', '11235', 1),
(7, 'Drake', 'Drake123@gmail.com', 'Drake', '689-486-9574', '11726', 0),
(8, 'Mario', 'Mario123@gmail.com', 'Mario', '655-700-5690', '11232', 1);

-- --------------------------------------------------------


--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `workEmail` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  `phoneNumber` varchar(80) NOT NULL,
  `manager` tinyint(1) DEFAULT NULL,
  `ein_number` varchar(10) NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `name`, `workEmail`, `password`, `phoneNumber`, `manager`, `ein_number`)VALUES
(1001, 'Kel', 'Kel123@gmail.com', 'Kel', '631-265-8477', 1, '26-8438447'),
(1002, 'Cristian', 'Cristian@gmail.com', 'Cristian', '348-658-8491', 0, '26-8438447'),
(1003, 'Kidd', 'Kidd123@gmail.com', 'Kidd', '631-954-6842', 1, '38-1983547'),
(1004, 'Ruth', 'Ruth123@gmail.com', 'Ruth', '631-896-4127', 0, '38-1983547'),
(1005, 'Paolo', 'Paolo123@gmail.com', 'Paolo', '631-854-6321', 1, '14-7849153'),
(1006, 'Colby', 'Colby123@gmail.com', 'Colby', '631-753-9519', 0, '14-7849153'),
(1007, 'Morty', 'Morty123@gmail.com', 'Morty', '631-456-8452', 1, '95-8426571'),
(1008, 'Rick', 'Rick123@gmail.com', 'Rick', '631-746-8523', 0, '95-8426571');


-- --------------------------------------------------------


--
-- Table structure for table `food_banks`
--

DROP TABLE IF EXISTS `food_banks`;
CREATE TABLE IF NOT EXISTS `food_banks` (
  `ein_number` varchar(20) NOT NULL,
  `name` 	   varchar(80) NOT NULL,
  `address`	   varchar(80) NOT NULL.
  `city`	   varchar(80) NOT NULL,
  `state`      varchar(80) NOT NULL,
  `zipcode`	   varchar(15) NOT NULL,
  `phoneNumber` varchar(80) NOT NULL,
  `url`		   varchar(80) NOT NULL,
  `longitude`  float(25) NULL,
  `latitude`   float(25) NULL,
  `employee_id` int NOT NULL,
  PRIMARY KEY (`ein_number`),
  FOREIGN KEY (`employee_id`) REFERENCES `employee`(`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;



--
-- Dumping data for table `food_banks`
--

INSERT INTO `food_banks` (`ein_number`,`name`,`address`,`city`,`state`,`zipcode`,`phoneNumber`,`url`,`employee_id`) VALUES
( '26-8438447', 'Saint Kilian', '140 Elizabeth St', 'Farmingdale', 'NY', '11735', '631-849-6668','https://stkilian.com/', 1001),
( '38-1983547', 'Island Harvest', '126 Spagnoli Road', 'Melville', 'NY', '11747', '631-448-3421','https://www.islandharvest.org/','126', 1003),
( '14-7849153', 'Long Island Cares Inc', '10 Davids Drive', 'Hauppauge', 'NY', '11788', '631-855-4172','https://www.licares.org/','10', 1005),
( '95-8426571', 'City Harvest', '150 52nd Street', 'Brooklyn', 'NY', '11232', '631-332-1124','http://www.cityharvest.org/', 1007);
COMMIT;

-- --------------------------------------------------------------------------------------------------------------
-- Table structure for food bank 1
drop table if exists '147849153_inv';
create table if not exists '147849153_inv' (
  `itemNumber` int(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `type` varchar(25) NOT NULL,
  `quantity` int(10) NOT NULL,
  `priority` ENUM('Low', 'Medium', 'High') DEFAULT NULL,
  `display` tinyint(1) DEFAULT 1,
  primary key (`itemNumber`) 
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
  
  -- Dumping data for table '147849153_inv'
  INSERT INTO '147849153_inv' (`itemNumber`,`name`,`type`,`quantity`,`priority`,`display`) VALUES
( '10001', 'Baked Beans', 'Protein', 27),
( '10002', 'Beefaroni', 'Combo Food', 26),
( '10003', 'Black Beans', 'Protein', 41),
( '10004', 'Brownie Mix', 'Sweets', 15),
( '10005', 'Cake Mix', 'Sweets', 23),
( '10006', 'Canned Beef Stew', 'Protein', 2),
( '10007', 'Canned Chicken', 'Protein', 41),
( '10008', 'Canned Chilli', 'Protein', 7),
( '10009', 'Carrots', 'Vegetable', 1),
( '10010', 'Cereal', 'Grains', 22),
( '10011', 'Chickpeas', 'Protein', 48),
( '10012', 'Chicken Helper', 'Combo Food', 28),
( '10013', 'Coffee', 'Drinks', 49),
( '10014', 'Condensed Milk', 'Dairy', 2),
( '10015', 'Conditioner', 'Personal Care', 43),
( '10016', 'Cookies', 'Sweets', 23),
( '10017', 'Corn', 'Vegetable', 26),
( '10018', 'Crackers', 'Grains', 9),
( '10019', 'Canned Cranberries', 'Canned Fruit', 32),
( '10020', 'Deodrant', 'Personal Care', 6),
( '10021', 'Evaporated Milk', 'Dairy', 42),
( '10022', 'Gravy', 'Condiments', 28),
( '10023', 'Hamburger Helper', 'Combo Food', 40),
( '10024', 'Hot Chocolate', 'Drinks', 46),
( '10025', 'Icing', 'Sweets', 10),
( '10026', 'Jam', 'Sweets', 49),
( '10027', 'Jello', 'Sweets', 4),
( '10028', 'Juice', 'Drinks', 48),
( '10029', 'Ketchup', 'Condiments', 38),
( '10030', 'Laundry Detergent', 'Cleaning', 17),
( '10031', 'Lentils', 'Protein', 31),
( '10032', 'Macaroni & Cheese', 'Combo Food', 1),
( '10033', 'Mayonnaise', 'Condiments', 1),
( '10034', 'Canned Mixed Fruit', 'Canned Fruit', 13),
( '10035', 'Mixed Vegtables', 'Vegetable', 36),
( '10036', 'Mustard', 'Condiments', 35),
( '10037', 'Napkins', 'Cleaning', 28),
( '10038', 'Oatment', 'Cereal', 5),
( '10039', 'Canned Oranges', 'Canned Fruit', 44),
( '10040', 'Pancake Mix', 'Sweets', 8),
( '10041', 'Pancake Syrup', 'Sweets', 3),
( '10042', 'Paper Towels', 'Cleaning', 7),
( '10043', 'Pasta Roni', 'Combo Food', 15),
( '10044', 'Canned Peaches', 'Canned Fruit', 42),
( '10045', 'Peanut Butter', 'Protein', 37),
( '10046', 'Canned Pears', 'Canned Fruit', 32),
( '10047', 'Peas', 'Vegetable', 42),
( '10048', 'Canned Pineapple', 'Canned Fruit', 4),
( '10049', 'Potatoes', 'Vegetable', 22),
( '10050', 'Powdered Milk', 'Dairy', 25),
( '10051', 'Pudding', 'Sweets', 43),
( '10052', 'Red Beans', 'Protein', 43),
( '10053', 'Rice', 'Grains', 37),
( '10054', 'Rice-A-Roni', 'Combo Food', 27),
( '10055', 'Salad Dressing', 'Protein', 36),
( '10056', 'Salmon', 'Protein', 19),
( '10057', 'Salt', 'Condiments', 24),
( '10058', 'Shampoo', 'Personal Care', 6),
( '10059', 'Soap', 'Personal Care', 7),
( '10060', 'Spaghettios', 'Combo Food', 42),
( '10061', 'Spinach', 'Vegetable', 20),
( '10062', 'Sugar', 'Sweets', 0),
( '10063', 'Tea', 'Drinks', 3),
( '10064', 'Tissues', 'Cleaning', 49),
( '10065', 'Toilet Paper', 'Personal Care', 25),
( '10066', 'Tomato Pasta', 'Combo Food', 15),
( '10067', 'Tomato Sauce', 'Combo Food', 33),
( '10068', 'Tomatoes', 'Vegetable', 48),
( '10069', 'Toothpaste', 'Personal Care', 40),
( '10070', 'Tuna', 'Protein', 36),
( '10071', 'White Beans', 'Protein', 48),
( '10072', 'Yams', 'Vegetable', 35);
COMMIT;



drop table is exists `donations`;
create table if not exists `donations` (
	`donationId` int NOT NULL,
	`foodbankId` varchar(20) NOT NULL,
	`userId` int NOT NULL,
	`status` enum('Pending', 'Complete') DEFAULT 'Pending',
	`donoDate` date DEFAULT NULL,
	`donoTime` time NOT NULL,
	primary key (`donationId`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO `donations` (`donationId`,`foodbankId`,`userId`,`status`,`donoDate`,`donoTime`) VALUES
('100000', '11-2223345', '10', 'Pending', '2022-11-25', '15:00:00'),
('100001', '11-2223345', '10', 'Pending', '2022-11-25', '15:10:00'),
('100002', '11-2223345', '10', 'Pending', '2022-11-25', '15:20:00');
COMMIT;
-- --------------------------------------------------------------------------------------------------------------

