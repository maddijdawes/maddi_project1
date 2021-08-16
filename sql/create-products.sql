create table IF NOT exists products
(
    product_id INTEGER NOT NULL
        primary key autoincrement,
    cost TEXT,
    productName TEXT,
    category TEXT,
    quantity INTEGER,
    price INTEGER,
    image TEXT,
    code INTEGER
);