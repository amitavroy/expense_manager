# Expense manager

This application is an Expense manager that I want to use to track my expenses. 

It should allow me to track my expenses, incomes. It should also allow me to keep a track of my bills.

## Technology used

Right now, this project uses Laravel + Inertiajs + React starter kit. 
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

# TODO

- [ ] Track my expenses through transactions
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

Cases for Transaction edit:
1. New amount can be less or more
2. If new amount is less, we add balance back to the account
3. If new amount is more, then we nedd to check the balance and then reduce from the account
4. If it is from a different account then 
   1. First check the balance of the new account
   2. Then add back the old amount to the old account
   3. Reduce the balance from the new account
