DROP TABLE IF EXISTS HELPDESK_LOGS;
CREATE TABLE HELPDESK_LOGS (LOG_ID INTEGER PRIMARY KEY AUTOINCREMENT,
                            TICKET_ID INTEGER NOT NULL,
                            TYPE varchar(75) NOT NULL,
                            ENTRY varchar(4000),
                            ATTACHMENT BLOB,
                            ATTACHMENT_TYPE varchar(75),
                            ENTERED_BY INTEGER,
                            ENTERED_ON DATE,
                            UPDATED_BY INTEGER,
                            UPDATED_ON DATE);