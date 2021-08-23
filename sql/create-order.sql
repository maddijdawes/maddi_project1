create table IF NOT exists rder
(
    order_id INTEGER NOT NULL
    primary key autoincrement,
    orderCode INTEGER,
    customerID INTEGER,
    productCode INTEGER,
    orderDate INTEGER,
    quantity INTEGER,
    status TEXT,
);
