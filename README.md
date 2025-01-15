# Complete API and Commands Documentation

## Table of Contents
- [Overview](#overview)
- [Authentication](#authentication)
  - [Login](#login)
  - [Register](#register)
  - [Logout](#logout)
  - [Check Token](#check-token)
- [Articles (Artikel)](#articles-artikel)
- [Discussions (Diskusi)](#discussions-diskusi)
- [Farmers (Petani)](#farmers-petani)
- [Chat](#chat)
- [AI Integration](#ai-integration)
- [Calculation (Kalkulasi)](#calculation-kalkulasi)
- [Authentication Requirements](#authentication-requirements)
- [Laravel Commands](#laravel-commands)
  - [Available Commands](#available-commands)
    - [Post Artikel Command](#post-artikel-command)
    - [Post Diskusi Command](#post-diskusi-command)
  - [Usage with Migration](#usage-with-migration)
  - [File Requirements](#file-requirements)
    - [Article JSON Structure](#article-json-structure)
    - [Discussion JSON Structure](#discussion-json-structure)
  - [Error Handling](#error-handling)
  - [Command Return Values](#command-return-values)
  - [Notes](#notes)

## Overview
This API provides endpoints for managing articles, discussions, user authentication, farmer profiles, chat functionality, and AI-powered features.

## Authentication

### Login
- **Endpoint:** `POST /api/login`
- **Access:** Public
- **Description:** Authenticate user and receive access token

### Register
- **Endpoint:** `POST /api/register`
- **Access:** Public
- **Description:** Register new user account

### Logout
- **Endpoint:** `POST /api/logout`
- **Access:** Authenticated users
- **Description:** Invalidate user token and logout

### Check Token
- **Endpoint:** `GET /api/check-token`
- **Access:** Public
- **Description:** Verify if current token is valid and not expired

## Articles (Artikel)
- **List Articles**
  - `GET /api/artikel`
  - Retrieve all articles

- **Create Article**
  - `POST /api/artikel`
  - Create new article

- **Get Single Article**
  - `GET /api/artikel/{id}`
  - Retrieve specific article by ID

- **Update Article**
  - `PUT /api/artikel/{id}`
  - Update existing article

- **Delete Article**
  - `DELETE /api/artikel/{id}`
  - Remove article

- **List Articles with Exclusion**
  - `GET /api/artikel/exclude`
  - Retrieve articles with certain exclusions

## Discussions (Diskusi)
- **List Discussions**
  - `GET /api/diskusi`
  - Retrieve all discussions

- **Create Discussion**
  - `POST /api/diskusi`
  - Create new discussion

- **Get Single Discussion**
  - `GET /api/diskusi/{id}`
  - Retrieve specific discussion by ID

- **Update Discussion**
  - `PUT /api/diskusi/{id}`
  - Update existing discussion

- **Delete Discussion**
  - `DELETE /api/diskusi/{id}`
  - Remove discussion

## Farmers (Petani)
- **Update Profile**
  - `PATCH /api/petani/update`
  - Update farmer profile
  - Requires authentication

- **Get Profile**
  - `GET /api/petani/profil`
  - Retrieve farmer profile
  - Requires authentication

## Chat
- **Store Chat Message**
  - `POST /api/chat`
  - Save new chat message
  - Requires authentication

- **Get Discussion Chat**
  - `POST /api/chat/{id_diskusi}`
  - Retrieve chat messages for specific discussion
  - Requires authentication

## AI Integration
- **Generate AI Content**
  - `POST /api/gemini/generate`
  - Generate content using Gemini AI
  - Requires authentication

## Calculation (Kalkulasi)
- **View History**
  - `GET /api/riwayat/user`
  - Retrieve calculation history
  - Requires authentication

- **Save Crop Calculation**
  - `POST /api/save-crop`
  - Store crop calculation
  - Requires authentication

- **Delete Crop Calculation**
  - `DELETE /api/delete-crop/{id}`
  - Remove specific crop calculation
  - Requires authentication

## Authentication Requirements
- All endpoints under the `auth:sanctum` middleware require a valid authentication token
- Include token in request header: `Authorization: Bearer {your_token}`

## Laravel Commands

### Available Commands

#### Post Artikel Command
```bash
php artisan post:artikel
```
- **Purpose**: Reads article data from JSON file and inserts it into the database
- **Source File**: `public/js/data/artikel.json`
- **Controller**: `ArtikelController@store`
- **Description**: Automatically populates the articles table with predefined content

#### Post Diskusi Command
```bash
php artisan post:diskusi
```
- **Purpose**: Reads discussion data from JSON file and inserts it into the database
- **Source File**: `public/js/data/diskusi.json`
- **Controller**: `DiskusiController@store`
- **Description**: Automatically populates the discussions table with predefined content

### Usage with Migration
These commands are designed to run automatically after migrations. To enable this, add the following to your `DatabaseSeeder.php`:

```php
public function run()
{
    $this->call([
        // Other seeders...
        \Database\Seeders\ArtikelSeeder::class,
        \Database\Seeders\DiskusiSeeder::class,
    ]);
}
```

To run the entire migration and seeding process:
```bash
php artisan migrate:fresh --seed
```

### File Requirements

#### Article JSON Structure
File location: `public/js/data/artikel.json`
```json
{
  "data": [
    {
      "judul": "Article Title",
      "gambar": "image-filename.jpg",
      "isi": "<p>Article content with HTML formatting</p>",
      "tanggal": "YYYY-MM-DD"
    }
  ]
}
```

#### Discussion JSON Structure
File location: `public/js/data/diskusi.json`
```json
[
    { "topik": "topic_1" },
    { "topik": "topic_2" },
    { "topik": "topic_3" },
    { "topik": "topic_4" },
    { "topik": "topic_5" }
]
```

### Error Handling
Both commands include error handling for common issues:

1. **Missing JSON File**
   - Error message: "File tidak ditemukan: {filePath}"
   - Resolution: Ensure JSON file exists in the correct location

2. **Invalid JSON Format**
   - Error message: "Gagal membaca file JSON. Pastikan formatnya valid."
   - Resolution: Validate JSON file format

3. **Successful Execution**
   - Success message: "Data berhasil dikirim ke function store di {Controller}"
   - Response data will be displayed in console

### Command Return Values
- `Command::SUCCESS`: Operation completed successfully
- `Command::FAILURE`: Operation failed (missing file or invalid JSON)

### Notes
- Ensure JSON files are properly formatted before running migrations
- Commands can also be run independently using `php artisan` if needed
- Check controller validation rules to ensure JSON data meets required format
- Both commands will display detailed response information in the console