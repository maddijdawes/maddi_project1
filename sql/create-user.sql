create table IF NOT exists user
(
    user_id INTEGER NOT NULL
primary key autoincrement,
username  TEXT,
password TEXT,
name TEXT,
profilePic TEXT,
accesslevel TEXT,
email TEXT,
address TEXT,
phone TEXT
);
