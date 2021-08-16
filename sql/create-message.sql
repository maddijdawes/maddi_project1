create table IF NOT exists Message
(
    message_id INTEGER NOT NULL
        primary key autoincrement,
                 username  TEXT,
    user_id TEXT,
    name TEXT,
    accesslevel INTEGER
);