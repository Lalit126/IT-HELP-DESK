DROP TABLE IF EXISTS HELPDESK_RESPONDERS;
CREATE TABLE HELPDESK_RESPONDERS (TICKET_ID INTEGER NOT NULL,
                                  RESPONDER_ID INTEGER NOT NULL,
                                  PRIMARY KEY (TICKET_ID, RESPONDER_ID));
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '123');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '321');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '456');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '654');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '789');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '987');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '234');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '432');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '567');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '765');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '890');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('1', '098');
INSERT INTO HELPDESK_RESPONDERS (TICKET_ID, RESPONDER_ID)
VALUES ('3', '123');