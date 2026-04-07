# Blog

A blog application built with Laravel 12, Filament v5, and Tailwind CSS v4. Features post management with a Filament admin panel.

## Summary

This project implements a complete blog system with the following features:

### Implemented Features

**Post Management:**
- Create, edit, and delete posts with title, slug, author, lead (excerpt), and content
- Post image upload with drag & drop support
- Draft/Publish toggle (is_published status)
- Auto-slug generation from title
- WYSIWYG editor (Trix) for rich text content

**Categories & Tags:**
- Dynamic categories with many-to-many relationship
- Tags with comma-separated input
- Category filtering and search on posts index

**Comments System:**
- User comments on posts
- Author name, content, and timestamp
- Comments displayed on post detail page

**Search:**
- Full-text search across post titles and content
- Category filtering

**User Interface:**
- Modern "Canva-style" design with Tailwind CSS v4
- Dark mode toggle with persistence
- Sticky navigation with backdrop blur
- Responsive grid layout
- Hover effects and smooth transitions
- Custom styled Trix editor with dark mode support

### File Structure

- **Models:** Post, Comment, Category, Tag
- **Controllers:** PostController (index, show, create, store, edit, update, destroy)
- **Views:** Blade templates for posts (index, show, create, edit) with partials (navigation, footer)
- **Database:** SQLite with migrations for posts, comments, categories, tags, and pivot tables

## Tech Stack

- **PHP** 8.4
- **Laravel** 12
- **Filament** 5
- **Tailwind CSS** 4
- **SQLite** (default)
- **Pest** 4 (testing)

## Installation

```bash
git clone https://github.com/zstio-pt/blog-2
cd blog-2
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan boost:install
npm run build
```

## Running the Application

```bash
composer run dev
```

This starts the Laravel dev server, queue worker, log viewer, and Vite simultaneously.

## Testing

```bash
php artisan test
```

## Code Formatting

```bash
vendor/bin/pint
```
