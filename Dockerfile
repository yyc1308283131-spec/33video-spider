FROM php:8.3-cli

WORKDIR /app

# Copy project files
COPY . .

# Create .env from example if not present
RUN if [ ! -f .env ] && [ -f .env.example ]; then cp .env.example .env; fi

# Use PORT env var from Render (default 8000)
EXPOSE 8000

# Start PHP built-in server on $PORT
CMD php -S 0.0.0.0:${PORT:-8000} -t public
