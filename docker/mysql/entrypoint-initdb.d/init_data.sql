CREATE SCHEMA IF NOT EXISTS schedule COLLATE utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS task
(
    guid        varchar(40)  not null primary key,
    title       varchar(256) not null,
    description text         not null,
    assigneeId  varchar(40)  not null,
    status      varchar(40)  not null,
    dueDate     date         not null
)
    collate = utf8_unicode_ci;
