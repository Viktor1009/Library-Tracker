<?php

$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO Users(user_name, user_password, user_pfp) VALUES(?,?,?)");

$pfp = "default.png";

$stmt->bind_param("sss", $_POST["admin"], $password, $pfp);
$stmt->execute();
$stmt->close();



/* =========================
   BOOKS
========================= */

$conn->query("INSERT INTO Books (book_name, book_description, book_tot_rating) VALUES
    ('The Pragmatic Programmer', 'A classic book about practical software development.', 4.8),
    ('Clean Code', 'A handbook of agile software craftsmanship.', 4.7),
    ('Atomic Habits', 'A guide to building good habits and breaking bad ones.', 4.9),
    ('The Hobbit', 'A fantasy novel about Bilbo Baggins adventure.', 4.6),
    ('1984', 'A dystopian novel about totalitarian society.', 4.7),
    ('Dune', 'An epic science fiction novel set on the desert planet Arrakis.', 4.8),
    ('Deep Work', 'A productivity book about focused success in a distracted world.', 4.5),
    ('Harry Potter and the Prisoner of Azkaban', 'The third book in the Harry Potter series.', 4.9);");



/* =========================
   LIBRARY
========================= */

$conn->query("INSERT INTO Library 
(user_id, book_id, book_page, book_status, book_rating, book_review, book_notes) 
VALUES

-- COMPLETE
(1, 1, 352, 'Complete', 5,
'Fantastic programming book with lots of useful advice.',
'Finished during spring break.'),

(1, 3, 320, 'Complete', 5,
'Very motivating and easy to apply in daily life.',
'Used the habit tracker ideas immediately.'),

(1, 5, 328, 'Complete', 4,
'Dark and thought provoking.',
'Orwell really nailed the atmosphere.'),

-- READING
(1, 2, 210, 'Reading', NULL,
NULL,
'Currently reading about naming conventions and functions.'),

(1, 4, 140, 'Reading', NULL,
NULL,
'Really enjoying the adventure and world building.'),

(1, 6, 480, 'Reading', NULL,
NULL,
'Complex politics but very interesting story.'),

-- ON HOLD
(1, 7, 95, 'On Hold', NULL,
NULL,
'Will continue after exams.'),

-- PLAN TO READ
(1, 8, 0, 'Plan to Read', NULL,
NULL,
'Want to reread this during summer.');");



/* =========================
   ACTIVITY - SPRING 2026
========================= */

$conn->query("INSERT INTO Activity (user_id, book_id, edited_at) VALUES
    (1, 1, '2026-01-14 18:22:00'),
    (1, 2, '2026-01-20 20:15:00'),
    (1, 3, '2026-02-02 16:40:00'),
    (1, 4, '2026-02-10 19:05:00'),
    (1, 5, '2026-02-28 21:12:00'),
    (1, 6, '2026-03-12 17:50:00'),
    (1, 2, '2026-03-25 14:18:00'),
    (1, 7, '2026-04-03 22:10:00'),
    (1, 3, '2026-04-18 13:45:00'),
    (1, 1, '2026-05-02 15:30:00'),
    (1, 4, '2026-05-11 20:05:00'),
    (1, 6, '2026-05-16 18:55:00')");
    
?>