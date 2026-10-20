USE `ebenta`;

-- Clear any dummy seller business names and descriptions
UPDATE `ebenta`.`users`
SET
    `business_name` = NULL,
    `business_description` = NULL;
