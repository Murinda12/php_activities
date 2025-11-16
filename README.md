RegNo: 24RP01530
Names: MURINDA KAYITESI Noella

PHP Assignment

Insert Document:
 
I have created both insert form and table that is used to display inserted data in the database at the same time so that my file can do both insert and retrieve of the data in the database I have also inserted connection first as I have to first make connection so that the files can be able to communicate with the database I have also inserted some css so that I have well designed page

Delete
 
In delete I have used a grobal variable $_GET so that I can use it to monitor the phone number as unique identifier in my table so that I can use it to delete specific data when variable phone_number isset 

Update
 
Here in update I have used also grobal variable $_GET so that also I can update specified data record 



Assignment 6

CRUD System Security Documentation

How Sessions Were Used
- Sessions store user information (user_id, username) after login
- `session_start()` is called on every protected page
- Sessions are destroyed on logout using `session_destroy()`
- Session fixation is prevented using `session_regenerate_id(true)`

How Cookies Were Used
- Cookies implement "Remember Me" functionality
- Cookies store user_id and username for 30 days
- Cookies are deleted on logout

How Authentication is Secured
- **Passwords**: Hashed using `password_hash()` and verified with `password_verify()`
- **SQL Injection**: Prevented using prepared statements
- **Input Validation**: All inputs are sanitized and validated
- **Page Protection**: All CRUD pages require active session
- **Session Security**: Session IDs are regenerated after login
