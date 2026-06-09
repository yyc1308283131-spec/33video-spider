FROM php:8.3-cli

WORKDIR /app

# Copy project files
COPY . .

# Expose port
EXPOSE 8000

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
