# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Application Overview

This is an expense manager application built to track personal finances including expenses, income, accounts, and transactions. The application uses a modern Laravel + React stack with Inertia.js for server-driven reactive UIs.

## Technology Stack

- Backend: Laravel 12 with PHP 8.4
- Frontend: React 19 with TypeScript
- Data Flow: Inertia.js v2 (server-side routing with React components)
- Styling: Tailwind CSS v4 with Radix UI primitives
- Build Tool: Vite
- Testing: Pest v4
- Authentication: Laravel Fortify
- Database: SQLite (development), supports MySQL/PostgreSQL

## Development Commands

```bash
# Start development environment (runs PHP server, queue, logs, and Vite concurrently)
composer run dev

# Run individual services
php artisan serve        # Backend server only
npm run dev             # Frontend dev server only

# Testing
php artisan test                              # Run all tests
php artisan test --filter=testName           # Run specific test
php artisan test tests/Feature/ModelTest.php # Run specific file

# Code quality
vendor/bin/pint         # Format PHP code (run before commits)
npm run format          # Format TypeScript/React with Prettier
npm run lint            # Lint and fix with ESLint

# Database
php artisan migrate              # Run migrations
php artisan migrate:seed         # Run migrations with seeders
php artisan migrate:fresh --seed # Fresh database with seed data

# Production build
npm run build
```

## Application Architecture

### Action Pattern for Business Logic

This application uses **Action classes** to encapsulate business logic, separating it from controllers. Actions handle complex operations including database transactions and account balance updates.

**Pattern:**
- Controllers handle HTTP requests and validation
- Actions execute business logic
- Actions are injected via dependency injection

Example: `TransactionController::store()` uses `AddTransactionAction` to create transactions and update account balances atomically.

**Key Action Classes:**
- `AddAccountAction` - Creates accounts
- `AddCategoryAction` - Creates categories
- `AddTransactionAction` - Creates transactions and updates account balances
- `UpdateTransactionAction` - Updates transactions and reconciles balance changes

### Context API for Validation-to-Action Data Flow

The application uses Laravel's `Context` facade to pass data from Form Requests to Actions. This is used when validation needs to load models that should be reused in the action.

**Example Flow:**
1. `StoreTransactionRequest` validates data and loads `Account` and `Category` models
2. Request stores models in Context: `Context::add('account', $account)`
3. Controller pulls from Context: `$account = Context::pull('account')`
4. Controller passes models to Action for execution

See: `app/Http/Requests/StoreTransactionRequest.php:56-57` and `app/Http/Controllers/TransactionController.php:89-90`

### Database Relationships

```
User (1) ─── (many) Account
User (1) ─── (many) Transaction

Account (1) ─── (many) Transaction
Category (1) ─── (many) Transaction

Transaction belongs to: User, Account, Category
```

**Important:** When creating/updating/deleting transactions, you MUST update the associated account balance. Use database transactions to ensure atomicity.

### Account Balance Management

Account balances are automatically updated when transactions are created, updated, or deleted:

- **EXPENSE transaction:** decrements account balance
- **INCOME transaction:** increments account balance

Balance updates use Laravel's `increment()`/`decrement()` methods wrapped in database transactions. See `AddTransactionAction::execute()` for the pattern using `match()` expressions.

### Enum Usage

The application uses PHP 8 backed enums for type safety:

- `AccountTypeEnum` - BANK, CASH, CREDIT_CARD
- `TransactionTypeEnum` - EXPENSE, INCOME

Use these enums with `match()` expressions for type-safe conditional logic.

### Frontend Architecture

**Page Components:** Located in `resources/js/pages/` organized by feature (accounts, transactions, categories, auth, settings)

**Component Structure:**
- `pages/` - Inertia page components (server-rendered)
- `components/` - Reusable React components
  - UI primitives (buttons, dialogs, inputs) using Radix UI + Tailwind
  - Layout components (app-shell, header, sidebar)
  - Navigation components
- `layouts/` - Layout wrappers
- `forms/` - Form components
- `hooks/` - Custom React hooks (appearance, mobile nav, clipboard)
- `types/` - TypeScript type definitions
- `lib/` - Utility functions

**Navigation:** Use Inertia's `<Link>` component or `router.visit()` for client-side navigation, NOT `<a>` tags.

**Forms:** Follow Inertia v2 patterns - prefer `<Form>` component or `useForm` hook. Check sibling components for existing patterns before creating new forms.

### Validation Patterns

All validation uses **Form Request classes** with array-based rules (not string-based). Form Requests include:

- `rules()` method with validation rules
- `withValidator()` hook for complex validation and Context population
- Custom error messages when needed

Check sibling Form Requests (e.g., `StoreAccountRequest`, `UpdateAccountRequest`) to match the project's validation style.

### Laravel 12 Structure Notes

This project uses Laravel 12's streamlined structure:

- No `app/Http/Middleware/` directory - middleware defined in `bootstrap/app.php`
- No `app/Console/Kernel.php` - commands auto-register from `app/Console/Commands/`
- Service providers in `bootstrap/providers.php`
- Model casts use `casts()` method, not `$casts` property

### Testing Requirements

**Every code change must have corresponding tests.** The application uses Pest v4.

**Test Organization:**
- `tests/Feature/` - Feature/integration tests (use `RefreshDatabase`)
- `tests/Unit/` - Unit tests for isolated logic
- `tests/Browser/` - Browser tests (Pest v4)

**Test Patterns:**
- Use model factories: `User::factory()->create()`, `Account::factory()->create()`
- Follow existing test structure in sibling test files
- Test happy paths, failure paths, and edge cases
- Use datasets for testing validation rules with multiple inputs

**After changes:** Run related tests with `php artisan test --filter=` before finalizing.

### UI Conventions

**Dark Mode:** All pages and components support dark mode using Tailwind's `dark:` prefix. New components must support dark mode.

**Spacing:** Use `gap` utilities for spacing lists, not margins.

**Component Reuse:** Always check for existing components before creating new ones. The application has extensive Radix UI primitives in `resources/js/components/`.

## Common Workflows

### Adding a New Transaction Feature

1. Create/update Action class in `app/Actions/`
2. Create Form Request for validation in `app/Http/Requests/`
3. Update Controller to use Action and Form Request
4. Create/update React page component in `resources/js/pages/transactions/`
5. Update route in `routes/web.php`
6. Write Pest tests in `tests/Feature/`
7. Run tests: `php artisan test --filter=Transaction`
8. Format code: `vendor/bin/pint` and `npm run format`

### Adding a New Model

1. Create model with factory and seeder: `php artisan make:model -mfs ModelName`
2. Define relationships with return type hints
3. Set up `casts()` method for type casting
4. Create CRUD controller if needed
5. Create Form Requests for validation
6. Create Action classes for complex business logic
7. Write comprehensive tests

## Important Patterns to Follow

1. **Always use Action classes** for business logic involving multiple steps or database transactions
2. **Never modify account balances** without wrapping in `DB::transaction()`
3. **Use Context API** to pass validated models from Form Requests to Controllers/Actions
4. **Check existing Form Requests** to match validation rule format (array vs string)
5. **Eager load relationships** to prevent N+1 queries (e.g., `->with(['account', 'category'])`)
6. **Use named routes** for URL generation with `route()` function
7. **Type hint everything** - parameters, return types, and properties

## Current Features & TODO

**Implemented:**
- Transaction management (CRUD) with automatic account balance updates
- Account management (BANK, CASH, CREDIT_CARD types)
- Category management with EXPENSE/INCOME types
- User authentication with 2FA support
- User settings (profile, password, appearance)

**TODO (from README):**
- Bills with repeat dates and reminders
- Income management improvements
- Account synchronization features
