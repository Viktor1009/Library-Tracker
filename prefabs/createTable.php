<?php

$sql = "CREATE TABLE IF NOT EXISTS Books (
    book_id INT AUTO_INCREMENT PRIMARY KEY,
    book_name VARCHAR(100),
    book_description VARCHAR(500),
    book_tot_rating float
)";
makeTabel($conn, $sql, "Books");

$sql = "CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(20),
    user_password VARCHAR(100),
    user_pfp VARCHAR(500)
)";
makeTabel($conn, $sql, "Users");

$sql = "CREATE TABLE IF NOT EXISTS Library (
    user_id INT,
    book_id INT,
    book_page INT,
    book_status INT,
    book_your_rating float,
    book_notes VARCHAR(200),

    FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE,

    FOREIGN KEY (book_id) REFERENCES Books(book_id)
    ON DELETE CASCADE
)";
makeTabel($conn, $sql, "Library");

$sql = "CREATE TABLE IF NOT EXISTS Activity (
    user_id INT,
    edited_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE
)";
makeTabel($conn, $sql, "Activity");
?>