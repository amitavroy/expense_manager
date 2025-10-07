# Expense manager

- [ ] Track my expenses through transactions
- [x] I should be able to make expense from an account
- [x] Expenses should have category
- [ ] Should be able to add bills with their repeat date 
- [ ] Should get reminders for my bills
- [ ] Once paid, they should show up in my transactions
- [ ] Should be able to add incomes to accounts so that I have a live balance
- [ ] Might need entries to sync up accounts


- user_id
- account_id
- type (income / expense)
- amount
- date
- description
  
On save ->
- we need to add / subtract the amount from account 
  - should happen in a DB transaction
  - should check for negative balance -> we will not allow it right now


```
select t.*, u.name, c.name, c.type
from transactions as t
join users as u on u.id = t.user_id
join categories as c on c.id = t.category_id
where c.type = 'expense'
```
