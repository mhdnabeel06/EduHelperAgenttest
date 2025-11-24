# EduHelperAgent — Laravel

## Overview
Simple educational chat agent that supports only three topics:
- Solar System
- Fractions
- Water Cycle

Features:
- Replies capped to 60 words
- Session-based conversation memory
- No external AI package required (local rule-based)

## Run locally
1. composer install
2. cp .env.example .env
3. php artisan key:generate
4. php artisan serve
5. Open http://127.0.0.1:8000

## API
POST /chat { "message": "What is the solar system?" }
Response: { "reply": "Hi! ..." }
