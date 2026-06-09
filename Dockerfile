FROM php:8.3-cli

WORKDIR /app

# Copy project files
COPY . .

# Use PORT env var from Render (default 8000)
EXPOSE 8000

# Start PHP built-in server on $PORT
CMD php -S 0.0.0.0:\${PORT:-8000} -t public
