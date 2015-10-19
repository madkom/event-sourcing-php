DROP TABLE IF EXISTS account;

CREATE TABLE IF NOT EXISTS account
(
    accountid_id VARCHAR(32) PRIMARY KEY,
    clientid_id  VARCHAR(32),
    money JSONB,
    transfers JSONB,
    active boolean,
    version INTEGER
);