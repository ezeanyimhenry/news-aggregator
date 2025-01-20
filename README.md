## News Aggregator Backend
A Laravel-based backend application that aggregates news from multiple sources including The Guardian, New York Times, and NewsAPI.

## Features

- Multi-source news aggregation
- Automated periodic news fetching
- RESTful API endpoints for news retrieval
- Configurable source management
- Advanced filtering and search capabilities
- Error handling and logging

## Requirements

- PHP 8.2 or higher
- Laravel 11.x
- MySQL 8.0 or higher
- Composer
- Valid API keys for news sources

## Installation

1. Clone the repository:

```bash
git clone https://github.com/ezeanyimhenry/news-aggregator.git
cd news-aggregator
```

2. Install dependencies:

```bash
composer install
```

3. Copy the environment file and configure your settings:

```bash
cp .env.example .env
```

4. Set up your database credentials in .env and add your API keys:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_aggregator
DB_USERNAME=root
DB_PASSWORD=

GUARDIAN_API_KEY=your_guardian_api_key
NYTIMES_API_KEY=your_nytimes_api_key
NEWSAPI_KEY=your_newsapi_key
```

5. Run database migrations:

```bash
php artisan key:generate
```

6. Generate application key:

```bash
php artisan migrate
```

## Usage

### Manual News Fetching
To fetch news manually, run:
```bash
php artisan news:fetch
```

### Scheduled Fetching
News fetching is scheduled to run hourly. Set up cron job on server or run schedule on local:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## API Endpoints

### Get All Articles

```bash
GET /api/articles
```

### Filter Articles

```bash
GET /api/articles?source=guardian&category=technology
```

### Query Parameters:
- search: Search in title and content
- source: Filter by news source
- category: Filter by category
- date_from: Filter from date
- date_to: Filter to date

## Project Structure

app/
├── Console/
│    └── Commands/
│        └── FetchNewsCommand.php
├── Http/
│    └── Controllers/
│        └── ArticleController.php
├── Interfaces/
│    └── NewsSourceInterface.php
├── Models/
│    └── Article.php
├── Providers/
│    └── NewsServiceProvider.php
├── Services/
│    ├── News/
│    │    ├── GuardianNewsService.php
│    │    ├── NYTimesNewsService.php
│    │    └── NewsAPIService.php
│    └── NewsAggregatorService.php

## Development

### Running Tests

```bash
php artisan test
```

## License

This project is licensed under the MIT License. - see the [LICENSE](LICENSE) file for details.

## Acknowledgments
- The Guardian API
- New York Times API
- NewsAPI
