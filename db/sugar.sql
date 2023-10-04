-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2020 at 07:32 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sugar`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `billingid` int(10) NOT NULL AUTO_INCREMENT,
  `sellerid` int(10) NOT NULL,
  `customerid` int(10) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`billingid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billingid`, `sellerid`, `customerid`, `date`, `status`) VALUES
(1, 0, 1, '2020-02-17', 'Active'),
(2, 0, 2, '2020-02-17', 'Active'),
(3, 0, 1, '2020-02-18', 'Active'),
(4, 0, 2, '2020-02-18', 'Active'),
(5, 0, 1, '2020-02-19', 'Active'),
(6, 0, 1, '2020-02-19', 'Active'),
(7, 0, 2, '2020-02-19', 'Active'),
(8, 1, 0, '2020-02-19', 'Active'),
(9, 3, 0, '2020-02-19', 'Active'),
(10, 2, 0, '2020-02-19', 'Active'),
(11, 0, 3, '2020-02-19', 'Active'),
(12, 0, 3, '2020-02-19', 'Active'),
(13, 0, 1, '2020-02-19', 'Active'),
(14, 0, 2, '2020-02-24', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customerid` int(10) NOT NULL AUTO_INCREMENT,
  `companyname` varchar(25) NOT NULL,
  `customername` varchar(25) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`customerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerid`, `companyname`, `customername`, `address`, `phone_no`, `mobile_no`, `email_id`, `status`) VALUES
(1, 'Sony sugar', 'lopez', '100-kakakmega', '0701390463', '0701390463', 'lopez@gmail.com', 'Active'),
(2, 'rongo university', 'jane waitara', '102-104104', '0701390463', '0796773698', 'jane@gmail.com', 'Active'),
(3, 'kanga high school', 'vincent kirui', '100 kanga', '0722618118', '0724126885', 'vincent@gmail.com', 'Active'),
(4, 'kercho sugar', 'hilary rob', 'kericho', '0722618118', '0724126885', 'hilary@gmail.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `empid` int(10) NOT NULL AUTO_INCREMENT,
  `emptype` varchar(20) NOT NULL,
  `empname` varchar(25) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `loginid` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `designation` varchar(25) NOT NULL,
  `emailid` varchar(30) NOT NULL,
  `salarytype` varchar(15) NOT NULL,
  `empsalary` float(10,2) NOT NULL,
  `address` varchar(250) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`empid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`empid`, `emptype`, `empname`, `gender`, `loginid`, `password`, `designation`, `emailid`, `salarytype`, `empsalary`, `address`, `contact_no`, `status`) VALUES
(1, 'Admin', 'ABDI', 'male', 'abdi123', 'abdi123', 'Manager', 'abdi4@gmail.com', 'Monthly', 20000.00, '103-40404 Rongo', '0724126885', 'Active'),
(2, 'Employee', 'wekesa', 'male', 'wekesa123', 'wekesa', 'marketting', 'wekesa@gmail.com', 'Monthly', 2000.00, '123-40404', '0796773698', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `expenseid` int(10) NOT NULL AUTO_INCREMENT,
  `expensedetails` varchar(50) NOT NULL,
  `expenseamt` float(10,2) NOT NULL,
  `bill_no` varchar(15) NOT NULL,
  `expenseimage` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `note` text NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`expenseid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expenseid`, `expensedetails`, `expenseamt`, `bill_no`, `expenseimage`, `date`, `note`, `status`) VALUES
(1, 'renovation', 5000.00, '20', '17883images (26).jpeg', '2020-02-11', 'we renovated the company buildings', 'Paid'),
(2, 'transport', 1000.00, '30', '3032', '2020-02-19', 'ksh 1000 was used for transport to field work', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `productid` int(10) NOT NULL AUTO_INCREMENT,
  `productname` varchar(25) NOT NULL,
  `productcode` varchar(10) NOT NULL,
  `productimage` varchar(100) NOT NULL,
  `productprice` float(10,2) NOT NULL,
  `taxamt` float(10,2) NOT NULL,
  `qtytype` varchar(100) NOT NULL,
  `productdiscription` text NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `productname`, `productcode`, `productimage`, `productprice`, `taxamt`, `qtytype`, `productdiscription`, `status`) VALUES
(1, 'white', 'W1', '23370', 180.00, 8.00, '5kg', 'This type of sugar is white in color', 'Active'),
(2, 'Yellow ', 'Y1', '2245', 100.00, 10.00, '5kg', 'This kind of sugar is yellow in color\r\n', 'Active'),
(3, 'Golden', 'G1', '3308', 175.00, 9.00, '25Kg', 'This type of sugar is goldish in color ', 'Active'),
(4, 'Brown', 'B1', '29500', 150.00, 5.00, '1Kg', 'Pack of 1 Kg', 'Active'),
(5, 'jaggery', 'J1', '18208', 100.00, 12.00, '1kg', 'jaggery ni sugari nguru', 'Active'),
(6, 'somalia ', 'S1', '6922misbah.png', 200.00, 10.00, '1kg', 'this is sugar that is white in color', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE IF NOT EXISTS `production` (
  `productionid` int(10) NOT NULL AUTO_INCREMENT,
  `godownstkkg` float(10,2) NOT NULL,
  `godownstkno` float(10,2) NOT NULL,
  `wasteinno` float(10,2) NOT NULL,
  `drypcno` float(10,2) NOT NULL,
  `netprocessingno` float(10,2) NOT NULL,
  `brokenpiecekg` float(10,2) NOT NULL,
  `netprocessingkg` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`productionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`productionid`, `godownstkkg`, `godownstkno`, `wasteinno`, `drypcno`, `netprocessingno`, `brokenpiecekg`, `netprocessingkg`, `date`, `status`) VALUES
(1, 31.00, 10.00, 1.00, 10.00, -1.00, 2.00, 2.00, '2020-02-11', 'Active'),
(2, 10.00, 5.00, 6.00, 1.00, -2.00, 2.00, 2.00, '2020-02-11', 'Active'),
(3, 69.00, 10.00, 0.00, 100.00, -90.00, 120.00, 2.00, '2020-02-18', 'Active'),
(4, 100.00, 20.00, 1.00, 100.00, -81.00, 3.00, 2.00, '2020-02-18', 'Active'),
(5, 320.00, 45.00, 4.00, 45.00, -4.00, 5.00, 2.00, '2020-02-19', 'Active'),
(6, 500.00, 45.00, 4.00, 5.00, 36.00, 6.00, 2.00, '2020-02-19', 'Active'),
(7, 500.00, 1000.00, 300.00, 5.00, 695.00, 5.00, 2.00, '2020-02-19', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `purchaseid` int(10) NOT NULL AUTO_INCREMENT,
  `sugarcane_typeid` int(10) NOT NULL,
  `billingid` int(10) NOT NULL,
  `qty` float(10,2) NOT NULL,
  `price` float(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`purchaseid`),
  KEY `sugartypeid` (`sugarcane_typeid`),
  KEY `billingid` (`billingid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchaseid`, `sugarcane_typeid`, `billingid`, `qty`, `price`, `status`) VALUES
(1, 4, 1, 10.00, 100.00, 'Active'),
(2, 4, 2, 5.00, 120.00, 'Active'),
(3, 3, 3, 5.00, 100.00, 'Active'),
(4, 8, 4, 700.00, 200.00, 'Active'),
(5, 3, 5, 700.00, 100.00, 'Active'),
(6, 5, 19, 90.00, 100.00, 'Active'),
(7, 2, 20, 10.00, 100.00, 'Active'),
(9, 1, 21, 10.00, 24.00, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `salaryid` int(10) NOT NULL AUTO_INCREMENT,
  `empid` int(10) NOT NULL,
  `salarymonth` varchar(25) NOT NULL,
  `noworkingdays` int(10) NOT NULL,
  `daysworked` int(10) NOT NULL,
  `salary` float(10,2) NOT NULL,
  `deduction` float(10,2) NOT NULL,
  `bonus` float(10,2) NOT NULL,
  `ot` float(10,2) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`salaryid`),
  KEY `empid` (`empid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `salary`
--

INSERT INTO `salary` (`salaryid`, `empid`, `salarymonth`, `noworkingdays`, `daysworked`, `salary`, `deduction`, `bonus`, `ot`, `date`, `status`) VALUES
(1, 2, 'febuary', 31, 20, 2000.00, 0.00, 0.00, 0.00, '2020-02-11', 'Pending'),
(2, 1, 'febuary', 30, 30, 20000.00, 0.00, 0.00, 0.00, '2020-02-12', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `salesid` int(10) NOT NULL AUTO_INCREMENT,
  `billingid` int(10) NOT NULL,
  `productid` int(10) NOT NULL,
  `qty` float(10,2) NOT NULL,
  `totalamt` float(10,2) NOT NULL,
  `taxamt` float(10,2) NOT NULL,
  `discount` float(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`salesid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`salesid`, `billingid`, `productid`, `qty`, `totalamt`, `taxamt`, `discount`, `status`) VALUES
(1, 1, 3, 20.00, 175.00, 9.00, 0.00, 'Active'),
(2, 2, 1, 2.00, 30.00, 8.00, 0.00, 'Active'),
(3, 3, 3, 1.00, 175.00, 9.00, 0.00, 'Active'),
(4, 4, 3, 2.00, 175.00, 9.00, 0.00, 'Active'),
(5, 5, 1, 2.00, 30.00, 8.00, 0.00, 'Active'),
(6, 6, 6, 3.00, 200.00, 10.00, 0.00, 'Active'),
(7, 7, 1, 3.00, 30.00, 8.00, 0.00, 'Active'),
(8, 8, 6, 5.00, 200.00, 10.00, 0.00, 'Active'),
(9, 9, 3, 67.00, 175.00, 9.00, 0.00, 'Active'),
(10, 10, 6, 95.00, 200.00, 10.00, 0.00, 'Active'),
(11, 11, 3, 100.00, 175.00, 9.00, 0.00, 'Active'),
(12, 12, 6, 100.00, 200.00, 10.00, 0.00, 'Active'),
(13, 13, 6, 20.00, 200.00, 10.00, 100.00, 'Active'),
(14, 14, 6, 23.00, 200.00, 10.00, 4.00, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE IF NOT EXISTS `seller` (
  `sellerid` int(10) NOT NULL AUTO_INCREMENT,
  `sellername` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`sellerid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`sellerid`, `sellername`, `address`, `phone_no`, `mobile_no`, `email_id`, `status`) VALUES
(1, 'Abdifatah Abdi', '103-404 Rongo', '0724126885', '0724126885', 'haji@gmail.com', 'Active'),
(2, 'wekesa', '104-104104', '0701390463', '0796773698', 'moses@gmail.com', 'Active'),
(3, 'john', 'kitere', '0701390463', '0701390463', 'john@gmail.com', 'Active'),
(4, 'mahat', 'rongo', '0724126885', '0724126885', 'mahat@gmail.com', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE IF NOT EXISTS `stock` (
  `stockid` int(10) NOT NULL AUTO_INCREMENT,
  `productionid` int(10) NOT NULL,
  `productid` int(10) NOT NULL,
  `qty` float(10,2) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`stockid`),
  KEY `productionid` (`productionid`),
  KEY `productid` (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stockid`, `productionid`, `productid`, `qty`, `status`) VALUES
(1, 1, 1, 100.00, 'Active'),
(2, 1, 2, 100.00, 'Active'),
(3, 1, 3, 100.00, 'Active'),
(4, 1, 4, 100.00, 'Active'),
(5, 2, 1, 50.00, 'Active'),
(6, 2, 3, 60.00, 'Active'),
(7, 2, 4, 40.00, 'Active'),
(8, 3, 3, 30.00, 'Active'),
(9, 3, 1, 25.00, 'Active'),
(10, 3, 4, 30.00, 'Active'),
(11, 4, 1, 5.00, 'Active'),
(12, 5, 6, 3.00, 'Active'),
(13, 3, 1, 10.00, 'Active'),
(14, 4, 6, 100.00, 'Active'),
(15, 5, 6, 700.00, 'Active'),
(16, 6, 3, 1000.00, 'Active'),
(17, 7, 5, 1000.00, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `sugarcanetype`
--

CREATE TABLE IF NOT EXISTS `sugarcanetype` (
  `sugarcane_typeid` int(10) NOT NULL AUTO_INCREMENT,
  `sugarcane_type` varchar(25) NOT NULL,
  `sugarcaneprice` float(10,2) NOT NULL,
  `sugarcanedescription` text NOT NULL,
  `sugarcaneimage` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`sugarcane_typeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sugarcanetype`
--

INSERT INTO `sugarcanetype` (`sugarcane_typeid`, `sugarcane_type`, `sugarcaneprice`, `sugarcanedescription`, `sugarcaneimage`, `status`) VALUES
(1, 'White', 24.00, 'Type of sugar is White', '', 'Active'),
(2, 'Brown', 100.00, '1kg', '', 'Active'),
(7, 'migori', 100.00, 'migori breed', '1832', 'Active'),
(9, 'kisii type', 110.00, 'kisii brand', '18056', 'Active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
