-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2012 at 07:11 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ces`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryID` int(11) NOT NULL,
  `categoryLocation` varchar(255) NOT NULL,
  `categoryName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `categoryLocation`, `categoryName`) VALUES
(1, 'Ground Floor', 'Appliances'),
(2, '1st Floor', 'Computers'),
(3, '1st Floor', 'Computer Parts'),
(4, '1st Floor', 'Multimedia Gadgets'),
(5, '2nd Floor', 'Speakers'),
(6, '3rd Floor', 'IC Parts'),
(7, '3rd Floor', 'Batteries'),
(8, 'Ground Floor', 'Cell Phones');

-- --------------------------------------------------------

--
-- Table structure for table `computer`
--

CREATE TABLE IF NOT EXISTS `computer` (
  `computerID` int(11) NOT NULL AUTO_INCREMENT,
  `computerName` varchar(45) NOT NULL,
  `computerMACAddress` varchar(45) NOT NULL,
  `computerIPAddress` varchar(45) NOT NULL,
  `computerUser` varchar(45) NOT NULL,
  PRIMARY KEY (`computerID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `computer`
--

INSERT INTO `computer` (`computerID`, `computerName`, `computerMACAddress`, `computerIPAddress`, `computerUser`) VALUES
(1, 'reginaPC', 'f0:bf:97:45:41:1a ', '192.168.1.111', 'regina'),
(2, 'scalaberch', '00:21:85:B3:D8:D1', '192.168.1.134', 'kieth'),
(3, 'encube', '00:16:B4:4A:62:85', '192.168.1.112', 'Novo');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employeeID` int(11) NOT NULL,
  `employeeName` varchar(45) NOT NULL,
  `employeeAdress` varchar(45) NOT NULL,
  `employeePosition` varchar(45) NOT NULL,
  `employeePassword` varchar(45) NOT NULL,
  PRIMARY KEY (`employeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employeeID`, `employeeName`, `employeeAdress`, `employeePosition`, `employeePassword`) VALUES
(90414, 'Natsu Dragneel', 'Iligan City', 'Supervisor', 'drag'),
(90521, 'Lucy Heartfilia', 'Iligan City', 'Cashier', 'heart'),
(90617, 'Gray Fullbuster', 'Davao City', 'Attendant', 'full'),
(91201, 'Erza Scarlet', 'Lanao del Sur', 'Financial Manager', 'Scar');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `invoiceID` int(11) NOT NULL AUTO_INCREMENT,
  `supplierID` int(11) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `itemID` int(11) NOT NULL,
  `quantityID` int(11) NOT NULL,
  PRIMARY KEY (`invoiceID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `itemID` int(11) NOT NULL AUTO_INCREMENT,
  `itemDescription` varchar(2552) NOT NULL,
  `itemName` varchar(45) NOT NULL,
  `supplierID` int(11) NOT NULL,
  `itemCategory` varchar(255) NOT NULL,
  `itemQuantity` int(11) NOT NULL,
  `itemDateLastAdded` varchar(25) NOT NULL,
  `itemStatus` varchar(25) NOT NULL,
  `itemPrice` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`itemID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=99922 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemID`, `itemDescription`, `itemName`, `supplierID`, `itemCategory`, `itemQuantity`, `itemDateLastAdded`, `itemStatus`, `itemPrice`) VALUES
(11234, 'Hanabishi HRC-10SS 21 inch Rice Cooker with Steamer', 'Hanabishi HRC-10SS Rice Cooker', 2323, 'Appliances', 129, '02/03/2012', '', 300),
(11344, 'Samsung iPhone5S Universe SmartTablet', 'Samsung iPone5S Universe', 10883, 'Cell Phones', 1000, '03/11/2012', '', 0),
(11653, 'Nokia 3210X Clamshell Smartphone with 24GB Card', 'Nokia 3210X Smartphone', 666, 'Cell Phones\n', 900, '03/10/2012', 'GOOD', 0),
(33109, 'Neo Vivid 3120 Notebook Computer', 'Neo Vivid 3120', 22102, 'Computers', 30, '02/29/2012', '', 28000),
(33234, 'Electrical Bicycle 888HP', 'Xtra Strong Electrical Bicycle', 88834, 'Appliances', 80, '09/12/2011', '', 0),
(33988, 'Samsung RV510 T3500 Celeron(R) Dual-Core CPU Laptop', 'Samsung RV510 T3500', 88839, 'Computers', 50, '09/22/2011', 'DEACTIVATED', 0),
(55526, 'HY 3D USB Optical Mouse PnP ', 'HY TM-8010 3D Optical Mouse', 88821, 'Computer Parts', 100, '01//19/2012', '', 0),
(60635, 'Sony VGP-UMS20 USB Mouse PnP', 'Sony VGP-UMS20 USB Mouse ', 88872, 'Computer Parts', 700, '03/12/2012', 'GOOD', 0),
(66738, 'HP 7780 Extra Strong Laptop', 'HP 7780 Extra Strong', 99909, 'Computers', 40, '08/22/2003', 'DEACTIVATED', 0),
(88987, 'MX-3 ChinaPhone XtraSlim (5mm thickness)', 'ChinaPhone MX-3 XtraSlim', 99923, 'Cell Phones', 3, '08/12/2011', 'DEACTIVATED', 0),
(99921, 'Hanabishi Turbolite D232 12'''' Table Fan', 'Hanabishi D232 Turbolite', 1123, 'Appliances', 320, '01/12/2012', 'GOOD', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ledger`
--

CREATE TABLE IF NOT EXISTS `ledger` (
  `ledgerID` int(11) NOT NULL AUTO_INCREMENT,
  `receiptID` varchar(45) NOT NULL,
  `InvoiceID` varchar(45) NOT NULL,
  PRIMARY KEY (`ledgerID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE IF NOT EXISTS `receipt` (
  `receiptID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `employeeID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `quantity` varchar(45) NOT NULL,
  PRIMARY KEY (`receiptID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
  `SupplierName` varchar(255) NOT NULL,
  `SupplierAddress` varchar(255) NOT NULL,
  PRIMARY KEY (`SupplierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88840 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `SupplierAddress`) VALUES
(88834, 'Ching Long Electrical Supply Ltd.', 'Guanzhou, People Republic of China'),
(88839, 'Intex Digital Supplies Inc.', 'Pasig City, Metro Manila');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
