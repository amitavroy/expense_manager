# Expense manager

This application is an Expense manager that I want to use to track my expenses. 

It should allow me to track my expenses, incomes. It should also allow me to keep a track of my bills.

## Technology used

Right now, this project uses 
- Laravel 
- Inertiajs 
- React with Typescript

This is based on the React starter kit of Laravel.
Database used for development has been SQLite. However, it should run easily on MySQL and even PGSql

## Installation

```
# Step 1
git clone https://github.com/amitavroy/expense_manager.git

# Step 2
cp .env.example .env

# Step 3
composer install && npm i

# Step 4
php artisan key:generate

# Step 5 (assuming you have configured your database connection in .env)
php artisan migrate --seed
```

# Modules 

## Transactions 

The transaction module will allow you to add expenses. Every expense is linked to a bank account. When you add an expense transaction, you need to select the account. And, the same amount is deducted from your account.
When you edit a transaction, we are also handling the scenarios like user changing the category and even account. The account balances are also updated based on the new edited transaction.

# TODO

- [x] Track my expenses through transactions
- [x] I should be able to make expense from an account
- [x] Expenses should have category
- [ ] Should be able to add bills with their repeat date 
- [ ] Should get reminders for my bills
- [ ] Once paid, they should show up in my transactions
- [ ] Should be able to add incomes to accounts so that I have a live balance
- [ ] Might need entries to sync up accounts


```
select t.*, u.name, c.name, c.type
from transactions as t
join users as u on u.id = t.user_id
join categories as c on c.id = t.category_id
where c.type = 'expense'
```

Need to evaluate:
https://github.com/moneyphp/money
https://github.com/brick/money
