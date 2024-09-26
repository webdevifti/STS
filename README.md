# Welcome to Supprt Ticket System
# About Project
>> Supprt Ticket System where customer get suppport ticket to discuss their prblem with system admin. This system has two type of user 1. Admin and 2. Customer

>> ### Admin Capabilities:
>> - #### Manage Tickets: Admins can View, Update Status, delete tickets.
>> - #### Dashboard: Admins has a dashboard where they can view statistices .
>> - #### Admin can show customers
>> #### Admin can manage categories
>> #### Admin can manage labels
>> #### Admin get email notification after submit a ticket by customer

>> ### Customer Capabilities:
>> - #### Customer Submit their ticket: 
>> - #### Discuss about the ticket:
>> - #### Get Email Notification after closed the ticket:

## ER-Diagram
[![ER-Diagram](https://drive.google.com/file/d/1ZZM9axoURjUkRMsoWJs2DcHjdXrId6Yk/view?usp=sharing)](https://drive.google.com/file/d/1ZZM9axoURjUkRMsoWJs2DcHjdXrId6Yk/view?usp=sharing)

## Flow Chart
[![Flow Chart](https://drive.google.com/file/d/1PuQr5mgB4dIQoFIE-E08wAIYfYxuB6iC/view?usp=sharing)](https://drive.google.com/file/d/1PuQr5mgB4dIQoFIE-E08wAIYfYxuB6iC/view?usp=sharing)


## Installation commands , open project directory cmd or powershell
``composer update``

 ``copy .env.example .env ``
 
``php artisan key:generate``
#### go to .env file and put your database information
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

#### go to .env file and put your mail configuration
```
MAIL_MAILER=log
MAIL_MAILER=smtp
MAIL_HOST=mail_host
MAIL_PORT=mail_port
MAIL_USERNAME=mail_username
MAIL_PASSWORD=mail_password
MAIL_ADMIN_ADDRESS=admin@example.com
```

## After mail configure go to /config/mail file and set this one line
```
 'admin_address' => env('MAIL_ADMIN_ADDRESS', 'admin@example.com'),
```
## database migrate and generate new data: 
``php artisan migrate:refresh --seed``
## after this commad you get some customer and admin as demo
## Then start the server
``php artisan serve``

``npm install && npm run dev``
>> you can see the server running url and go to the url to see the application interface
>> ### Now you can login as Admin and Customer
>> #### check the database who is admin and customer, you can login with email and password, default password is ``1234567890`` 