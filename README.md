# Web Order Project

**In order to run this project clone this repo and run locally on your computer. You will have to have Postman as well to test the routes.**

* I started the project by creating an _Order model_ and an _Item model_. It didn't make sense not to have a model first that forms the basis of what is stored in the database.

* I connected to the database and made sure I had the correct information (username, password, port, host, connection, database name) to connect to the database in my .env file.

* Once connected to the database I ran the SQL query CREATE DATABASE WebOrder; to create the database that the orders table and items table would be stored in.

* I then created the migrations to create the orders table and the items table in the WebOrder database. 
* I looked through the receiving an order part of the instructions on the tech task and made sure I included the correct restrictions where needed.

**Commands that will be helpful:**
Php artisan migrate
Php artisan migrate:rollback

**Always make sure you migrate before seeding!**

I then worked on creating the factories and seeders. I could’ve just used seeders but I didn’t want to repeat myself and wanted the data to be easy to maintain so I created the factories to create fake data to put in the database and the seeders use the factories and not manually enter data into the database.

**Commands that will be helpful:**
Php artisan db:seed

* I created the OrderControllerTest to test the methods within the OrderController. These can be run using the terminal command: php artisan test —filter OrderControllerTest

#### I then created the OrderController to handle the logic that was requested.
* Index method is to return a list of orders
* Show method is to show a specific order
* Update method is to update a specific method
* Destroy method is to delete a specific order

#### I then edited the API file to include routes:

`

    // POST route to create a new order
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');

    // GET route to list all orders
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');

    // GET route to show a specific order by reference
    Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');

    // PUT/PATCH route to update a specific order by reference
    Route::match(['put', 'patch'], '/{order}', [OrderController::class, 'update'])->name('orders.update');

    // DELETE route to delete a specific order by ID
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');});`

#### I tested these routes using Postman. The URL’s used in this order:

http://127.0.0.1:8000/api/orders
http://127.0.0.1:8000/api/orders/{reference}
http://127.0.0.1:8000/api/orders/{id}

#### In Postman make sure you have added these headers:
* Content-Type: application/json
* Accept: application/json
