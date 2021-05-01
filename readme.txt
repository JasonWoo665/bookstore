readme:

in the database, there is a table called "cartNotLoggedIn", it is just simply used to save 
cart data for those who haven't logged in.  Once they have logged in, those relateddata 
will be removed from the table
assumption: 
1. checkout is still available even the total cost is 0
2. no matter where the user register, the user will not login directly
