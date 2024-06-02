CREATE SCHEMA IF NOT EXISTS schedule COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS task
(
    guid        varchar(40) NOT NULL PRIMARY KEY,
    title       varchar(40) NOT NULL,
    description text        NOT NULL,
    assigneeId  varchar(40) NOT NULL,
    status      varchar(40) NOT NULL,
    dueDate     date        NOT NULL
) ENGINE = InnoDB
  COLLATE = utf8mb4_unicode_ci;

INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
VALUES ('19265534-5218-492f-9cfc-d051a0d2e8d0', 'title one', 'description one', '5966c003-b09b-40a3-abc7-cfcb6c31a954', 'new', '2024-05-21');

INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
VALUES ('e6752afc-dd94-4128-aa48-4c13e032e9c4', 'title two', 'description two', 'ef5e8615-7b8a-4c25-9e85-b1e8241686c8', 'done', '2024-05-21');

INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
VALUES ('4653997f-13db-4a7a-a2db-736f75b00185', 'title three', 'description three', 'ef5e8615-7b8a-4c25-9e85-b1e8241686c8', 'in_progress', '2024-05-22');

INSERT INTO task (guid, title, description, assigneeId, status, dueDate)
VALUES ('78cdd473-5ed7-451e-b0bf-546bd72e3b3c', 'title four', 'description four', '05fe9fbd-273b-4878-8d4b-349e50318c2d', 'new', '2024-05-27');
