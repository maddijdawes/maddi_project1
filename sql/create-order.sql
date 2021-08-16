create table IF NOT exists rder
(
    order_id INTEGER NOT NULL
    primary key autoincrement,
    product_id TEXT,
    username  TEXT,
    user_id TEXT,
    Date TEXT,
    Time TEXT
);
