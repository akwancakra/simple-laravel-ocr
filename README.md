# Laravel OCR Image Scanner

A web-based OCR (Optical Character Recognition) application built with Laravel, Inertia.js, Vue.js, and Shadcn UI. This application allows users to extract text from images using Tesseract OCR engine.

![OCR Scanner Demo]('asd')

## 🚀 Features

-   Image text extraction using Tesseract OCR
-   Support for both image upload and clipboard paste
-   Modern and responsive UI using Shadcn components
-   Real-time text detection and display
-   Support for multiple image formats (PNG, JPG, JPEG)

## 🛠️ Tech Stack

-   **Backend:**
    -   Laravel 10.x
    -   PHP 8.1+
    -   Tesseract OCR
-   **Frontend:**
    -   Vue.js 3
    -   Inertia.js
    -   Shadcn UI
    -   TailwindCSS

## 📋 Prerequisites

Before you begin, ensure you have met the following requirements:

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   Tesseract OCR installed on your system
-   MySQL or PostgreSQL

## 💻 Installation

1. Clone the repository:

```bash
git clone https://github.com/akwancakra/simple-laravel-ocr
cd simple-laravel-ocr
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
```

4. Create and configure your environment file:

```bash
cp .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

6. Configure your database in `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:

```bash
php artisan migrate
```

8. Build frontend assets:

```bash
npm run dev
```

9. Start the development server:

```bash
php artisan serve
```

## 🔧 Tesseract OCR Installation

### Ubuntu/Debian

```bash
sudo apt-get update
sudo apt-get install tesseract-ocr
sudo apt-get install libtesseract-dev
```

### macOS

```bash
brew install tesseract
```

### Windows

1. Download the installer from [GitHub](https://github.com/UB-Mannheim/tesseract/wiki)
2. Add Tesseract to your system PATH

## 🚀 Usage

1. Navigate to the application in your web browser
2. Choose between uploading an image file or pasting from clipboard
3. Click "Scan Image" to process the image
4. The extracted text will be displayed below the image

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👏 Acknowledgments

-   [Laravel](https://laravel.com)
-   [Inertia.js](https://inertiajs.com)
-   [Vue.js](https://vuejs.org)
-   [Shadcn UI](https://ui.shadcn.com)
-   [Tesseract OCR](https://github.com/tesseract-ocr/tesseract)

## 📧 Contact

Akwan Cakra - [@wanarkc](https://twitter.com/wanarkc) - wanprojects20@gmail.com
