# Hospital-Management-System

# README - Import SQL File into phpMyAdmin

## Prerequisites

- Ensure you have **XAMPP, WAMP, or any other local server** installed with MySQL and phpMyAdmin.
- Have access to **phpMyAdmin** (usually at `http://localhost/phpmyadmin/`).
- The SQL file (e.g., `database.sql`) should be present in your repository.

## Steps to Import the SQL File into phpMyAdmin

### Method 1: Using phpMyAdmin UI

1. **Open phpMyAdmin** in your web browser:
   - Go to `http://localhost/phpmyadmin/`.
2. **Create a new database** (if not already created):
   - Click on `Databases`.
   - Enter a database name (e.g., `my_database`).
   - Click `Create`.
3. **Import the SQL file:**
   - Select the database you just created from the left panel.
   - Click on the `Import` tab.
   - Click `Choose File` and select the `database.sql` file from your repository.
   - Click `Go` to start the import process.
4. **Verify the import:**
   - Once completed, you should see a success message.
   - Check the tables in your database to ensure the import was successful.

### Method 2: Using MySQL Command Line (Optional)

If you prefer using the command line, follow these steps:

1. **Open Command Prompt or Terminal.**
2. **Login to MySQL:**
   ```sh
   mysql -u root -p
   ```
   (Enter your MySQL root password when prompted.)
3. **Create a new database (if not exists):**
   ```sh
   CREATE DATABASE my_database;
   ```
4. **Use the created database:**
   ```sh
   USE my_database;
   ```
5. **Import the SQL file:**
   ```sh
   SOURCE /path/to/database.sql;
   ```
   Replace `/path/to/database.sql` with the actual path of your SQL file.
6. **Verify the import:**
   ```sh
   SHOW TABLES;
   ```

## Troubleshooting

- If you encounter an **import size limit**, increase the `upload_max_filesize` and `post_max_size` values in `php.ini`.
- If you get a **syntax error**, ensure the SQL file is not corrupted.
- If MySQL gives a **permission error**, check user privileges.

## Conclusion

Following these steps, you should be able to successfully import your SQL file into phpMyAdmin and use the database in your application.
