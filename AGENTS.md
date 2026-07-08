# Project context

This is an educational web application for students learning server-side web development with PHP.

The project is a classic Multi-Page Application built with PHP 8.3, HTML, Bootstrap and PDO.

The main goal is not to produce the most abstract or scalable architecture, but to help students understand how server-side web applications work.

# Pedagogical constraints

- Do not use MVC.
- Do not use frameworks.
- Do not use repositories, services or dependency injection containers.
- Do not introduce advanced architecture patterns unless explicitly requested.
- Prefer simple, explicit and readable PHP code.
- Keep the structure close to a traditional PHP web application.
- Each page may process its own form when appropriate.
- Avoid excessive abstraction.
- Prioritise learning value over architectural purity.

# Technologies

- PHP 8.3
- PDO for database access
- SQLite
- Bootstrap 5
- HTML5
- CSS
- JavaScript only when necessary
- Composer only for clearly justified dependencies

# Coding style

- Follow PSR-12 where reasonable.
- Use strict comparisons.
- Validate input explicitly.
- Escape output with `htmlspecialchars`.
- Use prepared statements with PDO.
- Keep functions short and understandable.
- Prefer descriptive variable and function names.
- Comments should explain educationally relevant decisions, not obvious code.

# Security rules

Always consider:

- SQL injection prevention with prepared statements.
- XSS prevention by escaping output.
- CSRF protection in forms that modify data.
- Password hashing with `password_hash`.
- Password verification with `password_verify`.
- Session regeneration after login.
- Authorisation checks before protected actions.
- Safe file includes.
- Basic error handling without exposing sensitive information.

# Project structure

Use a simple structure similar to:

/public
  index.php
  login.php
  logout.php
  users.php
  user-create.php
  user-edit.php
  user-delete.php

/includes
  db.php
  auth.php
  functions.php
  csrf.php
  flash.php
  header.php
  footer.php

/config
  config.php

/sql
  schema.sql
  seed.sql

/docs
  notes.md

# Application features

The application should include:

- User login and logout.
- Session-based authentication.
- User listing.
- User creation.
- User editing.
- User deletion.
- Role-based access control if needed.
- Form validation.
- Flash messages.
- Basic database seed data.
- Clear separation between public pages, shared includes and configuration files.
- Security should be optional. Ask for its implementation.

# Teaching approach

When generating code:

- Explain the intention briefly.
- Do not hide important logic behind abstractions.
- Prefer code that students can trace line by line.
- Avoid “magic”.
- Make database access visible and understandable.
- When possible, show the request → validation → database operation → response flow.
- Keep examples realistic but not enterprise-level.
- Process forms by using only a page or using two pages. Decide freely. 

# What to avoid

- Laravel, Symfony or any other framework.
- ORM tools.
- Complex routing systems.
- Controllers.
- Models.
- Services.
- Middleware abstractions.
- Frontend build tools.
- SPA architecture.
- Excessive Composer dependencies.
- Over-engineered folder structures.

# Response preferences

When suggesting changes:

- Show the affected files.
- Explain why each change is needed.
- Keep diffs small.
- Prefer incremental improvements.
- Ask before introducing a new dependency.
- If several solutions are possible, choose the simplest one suitable for students.

# Language

Use English for:

- Code identifiers.
- File names.
- Comments in code.
- Commit messages.

Use Valencian/Catalan for:

- Explanations to the teacher.
- Teaching notes.
- Documentation aimed at students, unless otherwise requested.

# Important restriction

Do not refactor the application into MVC unless explicitly instructed. If a task seems to benefit from MVC, explain the trade-off but keep the implementation within the current MPA structure.