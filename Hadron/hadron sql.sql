-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 01:33 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hadron`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AddItemsInStock` (IN `id` INT, IN `quantity` INT)   BEGIN
	DECLARE currStock INT;
    SELECT itemsInStock INTO currStock FROM inventory WHERE itemId = id;
    IF currStock IS NULL THEN SET currStock = 0; END IF;
	UPDATE inventory SET itemsInStock = currStock + quantity WHERE itemId = id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `AddTransaction` (IN `id` INT, IN `tDate` DATE, IN `itemsIss` INT, IN `itemsRec` INT, IN `sId` INT, IN `cId` INT, IN `oId` INT, IN `rem` VARCHAR(100), OUT `transaction_status` VARCHAR(20))   BEGIN
	DECLARE currStock INT;
    SELECT itemsInStock INTO currStock FROM inventory where itemId = id;
	IF itemsIss IS NOT NULL AND itemsIss > currStock THEN SET transaction_status = "Error! Not enough Items In Stock";
    ELSE SET transaction_status = "Transaction Entered successfully";
	INSERT INTO transactions(itemID, transactionDate, issued, received, supplierID, clientID, officeID, remarks) 
    VALUES (id, tDate, itemsIss, itemsRec, sId, cId, oId, rem);
    END IF;
    IF itemsRec IS NOT NULL THEN CALL AddItemsInStock(id, itemsRec);
    ELSE CALL RemoveItemsFromStock(id, itemsIss);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllClients` ()   BEGIN
select client_id, client_pass from add_client;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllItems` ()   BEGIN
	SELECT itemId, CONCAT(itemName, " ", brand, " ", quality) as item, itemsInStock from inventory;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllProjects` ()   BEGIN
select projectId, projectName from project;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTimelineSteps` (IN `projId` INT)   BEGIN
SELECT project_step_id, step_name, description, start_date, end_date, status, projectName, projectStatus FROM projectstepbridge JOIN steps ON projectstepbridge.step_id = steps.step_id JOIN project on projectstepbridge.projectId = project.projectId WHERE projectstepbridge.projectId = projId; 

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RemoveItemsFromStock` (IN `id` INT, IN `quantity` INT)   BEGIN
	DECLARE currStock INT;
    SELECT itemsInStock INTO currStock FROM inventory WHERE itemId = id;
	UPDATE inventory SET itemsInStock = currStock - quantity WHERE itemId = id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `add_client`
--

CREATE TABLE `add_client` (
  `client_id` varchar(20) NOT NULL,
  `client_pass` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `add_client`
--

INSERT INTO `add_client` (`client_id`, `client_pass`) VALUES
('', ''),
('em2115', 'donno3'),
('HD2114', 'hh1'),
('HD2119', 'check2'),
('mehak', 'donno3');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `complaint_no` int(11) NOT NULL,
  `complaint_description` varchar(100) NOT NULL,
  `complaint_status` tinyint(1) NOT NULL,
  `client_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`complaint_no`, `complaint_description`, `complaint_status`, `client_id`) VALUES
(1, 'mein genius hun', 1, 'HD2114'),
(2, 'mehak\'s complain', 0, 'mehak'),
(3, 'mehak\'s 2nd complain', 0, 'mehak');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `consultation_no` int(11) NOT NULL,
  `fullname` varchar(20) NOT NULL,
  `contact` int(11) NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`consultation_no`, `fullname`, `contact`, `address`, `email`) VALUES
(1, 'Eman', 2147483647, 'defence', 'emanamjad2002@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `itemId` int(11) NOT NULL,
  `itemName` varchar(50) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `quality` varchar(50) DEFAULT NULL,
  `itemRate` int(11) DEFAULT NULL,
  `itemsInStock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`itemId`, `itemName`, `brand`, `quality`, `itemRate`, `itemsInStock`) VALUES
(1, 'SOLAR PANEL', 'LONGI', '', 500, 625),
(2, 'SOLAR PANEL', 'JINKO', '', 1500, 54),
(3, 'DC CABLE', 'PAKISTAN CABLES', '4MM', 2500, 3130),
(4, 'AC CABLE', 'PAKISTAN CABLES', 'FAST 25MM 4 CORE', 4000, 4760),
(5, 'SILICON TUBE', '', '', 4500, 25),
(6, 'SOLAR PANEL', 'TRINA', '', 80000, 527),
(7, 'AC CABLE', 'PAKISTAN CABLES', '16MM 4 CORE', 9600, 90),
(8, 'DONGLE', 'SUNGROW', '', 200, 5),
(9, 'DONGLE', 'HUAWEI', '', 40000, 5),
(10, 'EARTHING CABLE', '', 'GREEN 2.5MM', 1000, 10),
(11, 'EARTHING CABLE', '', 'GREEN 4MM', 5859, 3),
(12, 'COPPER RODS ', '', '16MM', 8760, 5),
(13, 'DC CABLE', 'PAKISTAN CABLES', '2.5MM', 98877, 12),
(14, 'SMART METERS', 'FRONIUS', '', 3000, 1),
(15, 'SMART METERS', 'SUNGROW', '', 2000, 3),
(16, 'SMART METERS', 'SOLIS', '', 1500, 1),
(17, 'CABLE TIE PACKETS', '', '', 3800, 26),
(18, 'DURA DUCT', '', '60 * 60 G/S 2M', 9800, 10);

-- --------------------------------------------------------

--
-- Table structure for table `office`
--

CREATE TABLE `office` (
  `officeID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `office`
--

INSERT INTO `office` (`officeID`, `name`) VALUES
(1, 'Lahore'),
(2, 'Karachi'),
(3, 'Sukkur');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `projectId` int(11) NOT NULL,
  `projectName` varchar(100) NOT NULL,
  `projectStatus` varchar(20) NOT NULL DEFAULT '"In Progress"',
  `clientID` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projectId`, `projectName`, `projectStatus`, `clientID`) VALUES
(101, 'Mr. Ahmed Khan (Solar Installation)', '\"In Progress\"', '201'),
(102, 'Mrs. Fatima Ali (Solar Installation)', 'Completed', '202'),
(103, 'Mr. Hassan Ahmed (Solar Installation)', '\"In Progress\"', '203'),
(104, 'Mrs. Aisha Khan (Solar Installation)', '\"In Progress\"', '204'),
(105, 'Mr. Zainab Malik (Solar Installation)', '\"In Progress\"', '205'),
(106, 'Mrs. Usman Ali (Solar Installation)', '\"In Progress\"', '206'),
(107, 'hjbihjn', '\"In Progress\"', '1'),
(108, 'jbkjnn', '\"In Progress\"', '1'),
(109, 'jbkjnn', '\"In Progress\"', '1'),
(110, 'jjejioejo', '\"In Progress\"', '1'),
(111, 'Mr. Albus Dumbeldore (Solar Installation)', '\"In Progress\"', '4'),
(113, 'testproject', '\"In Progress\"', 'mehak');

-- --------------------------------------------------------

--
-- Table structure for table `projectstepbridge`
--

CREATE TABLE `projectstepbridge` (
  `project_step_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'PENDING',
  `step_id` int(11) NOT NULL,
  `projectId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projectstepbridge`
--

INSERT INTO `projectstepbridge` (`project_step_id`, `start_date`, `end_date`, `status`, `step_id`, `projectId`) VALUES
(2, '2023-01-10', '2023-01-15', 'Completed', 1, 101),
(3, '2023-01-16', '2023-01-25', 'Completed', 2, 101),
(4, '2023-01-26', '2023-01-28', 'Completed', 3, 101),
(5, '2023-01-26', '2023-01-28', 'Completed', 4, 101),
(6, '2023-01-27', '2023-01-30', 'Completed', 5, 101),
(7, '2023-01-27', '2023-01-30', 'Completed', 6, 101),
(8, '2023-02-01', '2023-02-10', 'Completed', 7, 101),
(9, '2023-02-11', '2023-02-15', 'Completed', 8, 101),
(10, '2023-02-16', '2023-02-20', 'Planned', 9, 101),
(11, '2023-01-15', '2023-01-20', 'Completed', 10, 102),
(12, '2023-01-21', '2023-01-25', 'Completed', 11, 102),
(14, '2023-02-06', '2023-02-10', 'Completed', 13, 102),
(15, '2023-02-11', '2023-02-28', 'Completed', 14, 102),
(17, '2023-01-10', '2023-01-15', 'Completed', 1, 106),
(18, '2023-01-16', '2023-01-25', 'Completed', 2, 106),
(19, '2023-02-01', '2023-02-10', 'Completed', 7, 106),
(20, '2023-02-11', '2023-02-15', 'Completed', 8, 106),
(21, '2023-02-16', '2023-02-20', 'Planned', 9, 106),
(22, '2023-01-10', '2023-01-15', 'Completed', 1, 103),
(23, '2023-01-26', '2023-01-28', 'Completed', 4, 103),
(24, '2023-02-01', '2023-02-10', 'In Progress', 7, 103),
(25, '2023-01-15', '2023-01-20', 'Completed', 10, 103),
(26, '2023-02-11', '2023-02-28', 'Planned', 14, 103),
(27, '2023-01-10', '2023-01-15', 'Completed', 1, 104),
(28, '2023-01-26', '2023-01-28', 'Completed', 3, 104),
(29, '2023-01-27', '2023-01-30', 'Completed', 5, 104),
(30, '2023-01-27', '2023-01-30', 'Completed', 6, 104),
(31, '2023-02-01', '2023-02-10', 'In Progress', 7, 104),
(32, '2023-01-10', '2023-01-15', 'Completed', 1, 105),
(33, '2023-01-16', '2023-01-25', 'Completed', 2, 105),
(34, '2023-02-01', '2023-02-10', 'Completed', 3, 105),
(35, '2023-02-11', '2023-02-15', 'Completed', 8, 105),
(36, '2023-02-16', '2023-02-20', 'Planned', 9, 105),
(64, '2023-06-16', '2023-06-17', 'Completed', 1, 111),
(65, '2023-06-16', '2023-06-17', 'Completed', 5, 111),
(66, '2023-06-21', '2023-06-23', 'PENDING', 7, 111),
(67, '2023-06-12', '2023-06-20', 'PENDING', 1, 113),
(68, '2023-06-13', '2023-06-13', 'PENDING', 2, 113),
(69, '2023-06-13', '2023-06-14', 'PENDING', 3, 113);

--
-- Triggers `projectstepbridge`
--
DELIMITER $$
CREATE TRIGGER `on_update_step_status` AFTER UPDATE ON `projectstepbridge` FOR EACH ROW BEGIN
    IF NEW.status <> OLD.status THEN
        SET @pId := (SELECT projectId FROM projectstepbridge WHERE project_step_id = NEW.project_step_id);
        SET @st := (SELECT status FROM projectstepbridge WHERE projectId = @pId ORDER BY end_date DESC LIMIT 1);
        
        IF @st = 'Completed' THEN
            UPDATE project SET projectStatus = 'Completed' WHERE projectId = @pId;
        END IF;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `steps`
--

CREATE TABLE `steps` (
  `step_id` int(11) NOT NULL,
  `step_name` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `steps`
--

INSERT INTO `steps` (`step_id`, `step_name`, `description`) VALUES
(1, 'Technical Survey', 'Conduct a survey to assess the technical requirements'),
(2, 'Final Drawing', 'Prepare the final installation drawings'),
(3, 'Delivery - Civil Material', 'Deliver civil construction materials to the site'),
(4, 'Delivery - Structural Material', 'Deliver structural components to the site'),
(5, 'Delivery - Solar Panels', 'Deliver solar panels to the site'),
(6, 'Delivery - BOQ', 'Deliver Bill of Quantities (BOQ) to the site'),
(7, 'Installation', 'Perform the solar panel installation'),
(8, 'Quality Control (Q.C)', 'Conduct quality checks and inspections'),
(9, 'Handover and Training', 'Handover the project and provide training to the client'),
(10, 'Permitting', 'Obtain necessary permits and approvals'),
(11, 'Site Preparation', 'Prepare the installation site'),
(13, 'Testing and Commissioning', 'Test and commission the installed solar system'),
(14, 'Maintenance and Support', 'Provide ongoing maintenance and support services');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplierId` int(11) NOT NULL,
  `supplierName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplierId`, `supplierName`) VALUES
(1, 'Sabri'),
(2, 'Jilani');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `transactionDate` date NOT NULL,
  `issued` int(11) DEFAULT NULL,
  `received` int(11) DEFAULT NULL,
  `supplierID` int(11) DEFAULT NULL,
  `clientID` varchar(11) DEFAULT NULL,
  `officeID` int(11) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `itemID`, `transactionDate`, `issued`, `received`, `supplierID`, `clientID`, `officeID`, `remarks`) VALUES
(1, 1, '2023-06-13', 0, 25, 1, '0', 0, ''),
(2, 1, '2023-06-13', 0, 25, 1, '0', 0, ''),
(3, 1, '2023-06-13', 0, 25, 1, '0', 0, ''),
(4, 1, '2023-06-13', 0, 25, 1, '0', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `add_client`
--
ALTER TABLE `add_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`complaint_no`),
  ADD KEY `fk_client_comp` (`client_id`);

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`consultation_no`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`itemId`);

--
-- Indexes for table `office`
--
ALTER TABLE `office`
  ADD PRIMARY KEY (`officeID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`projectId`),
  ADD KEY `fk_client_proj` (`clientID`);

--
-- Indexes for table `projectstepbridge`
--
ALTER TABLE `projectstepbridge`
  ADD PRIMARY KEY (`project_step_id`),
  ADD KEY `fk_projID` (`projectId`),
  ADD KEY `fk_stepID` (`step_id`);

--
-- Indexes for table `steps`
--
ALTER TABLE `steps`
  ADD PRIMARY KEY (`step_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplierId`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `trans_fk1` (`supplierID`),
  ADD KEY `trans_fk2` (`clientID`),
  ADD KEY `trans_fk3` (`officeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `complaint_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `consultation_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `itemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `projectstepbridge`
--
ALTER TABLE `projectstepbridge`
  MODIFY `project_step_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `supplierId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `fk_client_comp` FOREIGN KEY (`client_id`) REFERENCES `add_client` (`client_id`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_client_proj` FOREIGN KEY (`clientID`) REFERENCES `add_client` (`client_id`);

--
-- Constraints for table `projectstepbridge`
--
ALTER TABLE `projectstepbridge`
  ADD CONSTRAINT `fk_projID` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`),
  ADD CONSTRAINT `fk_stepID` FOREIGN KEY (`step_id`) REFERENCES `steps` (`step_id`),
  ADD CONSTRAINT `projectstepbridge_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `projectstepbridge_ibfk_2` FOREIGN KEY (`step_id`) REFERENCES `steps` (`step_id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `trans_fk1` FOREIGN KEY (`supplierID`) REFERENCES `supplier` (`supplierId`),
  ADD CONSTRAINT `trans_fk2` FOREIGN KEY (`clientID`) REFERENCES `add_client` (`client_id`),
  ADD CONSTRAINT `trans_fk3` FOREIGN KEY (`officeID`) REFERENCES `office` (`officeID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
