# Online bookstore

This is a project from a course called COMP3322 Modern Technologies in World Wide Web.  
This project is a simple online bookstore website for customers to purchase books, simulating a real world bookstore.  Register, login and payment interface are implmented.  

## Technologies used

HTML, CSS, JavaScript, jQuery, MySQL, AJAX, and PHP are used as the client and server side technologies.

## Usage

clone the project and change the username and password to your own sophia php server username and password in each php file.
```bash
$conn=mysqli_connect('sophia.cs.hku.hk', 'username', 'password', 'username') 
```
all project details can be found inside "Project_3322.pdf"

## Asusmptions

1. In the database, there is a table called "cartNotLoggedIn", it is just simply used to save cart data for those who haven't logged in.  Once they have logged in, those related data 
will be removed from the table.
assumption: 
2. Checkout is still available even the total cost is 0
3. No matter where the user register, the user will not login directly
