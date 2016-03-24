# PHPcom

[![The MIT License](https://img.shields.io/badge/license-MIT-orange.svg)](http://opensource.org/licenses/MIT)
[![Build Status](https://scrutinizer-ci.com/g/Jacajack/PHPcom/badges/build.png?b=master)](https://scrutinizer-ci.com/g/Jacajack/PHPcom/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jacajack/PHPcom/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jacajack/PHPcom/?branch=master)

PHPcom is PHP library for using serial communication for linux. It's very lightweight, pretty fast, object oriented and very simple to use.

# Usage
```php
<?php
#Include PHPcom library
include "PHPcom/PHPcom.php";

#Create new PHPcom object
$com = new PHPcom( "/dev/ttyUSB0", 9600, 8, 1 );

#Setup serial port for usage
$com->Setup( );

#Open device file
$com->Open( );

#Send data
$com->Write( "Hello world!" );

#Receive data
echo( $com->Read( ) );

#Close device file
$com->Close( );
?>
```

As You can see code is really simple and easy to understand. You can set up, open, write, read, and close serial port with just few functions.

**Note1:** To use `/dev/tty` devices You have to give PHP permission to use them. You can accomplish that by adding user `www-data` *(Note2)* to `dialout` *(Note3)* group.

**Note2:** To check what user PHP is running as use `echo exec( "whoami" );`.

**Note3:** To check what group is permitted to use `tty` run for example `ls -l /dev/ttyUSB0`

# Features
 - Objective
 - Intuitive
 - Simple in use
 - Function overloading
 - Setting basic parameters *(baud rate, data bits, stop bits)*
 - Works great with AJAX
 - *More coming soon*

# More info
Tested with:
 - Ubuntu 14.04 LTS
 - Apache 2.4.7
 - PHP 5.5.9
 - USB-UART converter
