<?php

    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO Users(user_name, user_password) VALUES(?,?)");
    $stmt->bind_param("ss", $_POST["admin"], $password);
    $stmt->execute();
    $stmt->close();

    $conn->query("INSERT INTO Books (book_name, book_description, book_tot_rating) VALUES
        ('The Pragmatic Programmer', 'A classic book about practical software development.', 4.8),
        ('Clean Code', 'A handbook of agile software craftsmanship.', 4.7),
        ('Atomic Habits', 'A guide to building good habits and breaking bad ones.', 4.6),
        ('The Hobbit', 'A fantasy novel about Bilbo Baggins adventure.', 4.5),
        ('1984', 'A dystopian novel about totalitarian society.', 4.4);");

    $conn->query("INSERT INTO Library (user_id, book_id, book_page, book_status, book_your_rating, book_notes) VALUES
        (1, 1, 120, 1, 4.5, 'Very practical so far.'),
        (1, 2, 350, 2, 5.0, 'One of the best programming books.'),
        (1, 4, 50, 1, 4.0, 'Interesting world building.'),
        (1, 5, 328, 2, 4.2, 'Creepy but good.'),
        (1, 3, 200, 1, 4.8, 'Super motivating.');");
?>