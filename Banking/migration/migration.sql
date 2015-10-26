CREATE TABLE IF NOT EXISTS account
(
    accountid_id VARCHAR(36) PRIMARY KEY,
    clientid_id  VARCHAR(36),
    money_amount INTEGER,
    transfers JSONB,
    active boolean,
    version INTEGER
);