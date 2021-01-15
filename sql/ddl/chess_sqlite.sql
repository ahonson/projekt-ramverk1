--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "email" TEXT NOT NULL,
    "password" TEXT NOT NULL,
    "name" TEXT NOT NULL,
    "gravatar" TEXT NOT NULL,
    "rating" INTEGER DEFAULT 0,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME
);

--
-- Table Question
--
DROP TABLE IF EXISTS Question;
CREATE TABLE Question (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "title" TEXT NOT NULL,
    "textbody" TEXT NOT NULL,
    "rating" INTEGER DEFAULT 0,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    FOREIGN KEY(userid) REFERENCES User(id)
);

--
-- Table Answer
--
DROP TABLE IF EXISTS Answer;
CREATE TABLE Answer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "questionid" INTEGER NOT NULL,
    "textbody" TEXT NOT NULL,
    "rating" INTEGER DEFAULT 0,
    "accepted" BOOLEAN DEFAULT false,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    FOREIGN KEY(userid) REFERENCES User(id),
    FOREIGN KEY(questionid) REFERENCES Question(id)
);

--
-- Table AComment stands for Answer Comment
--
DROP TABLE IF EXISTS AComment;
CREATE TABLE AComment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "answerid" INTEGER NOT NULL,
    "textbody" TEXT NOT NULL,
    "rating" INTEGER DEFAULT 0,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    FOREIGN KEY(userid) REFERENCES User(id),
    FOREIGN KEY(answerid) REFERENCES Answer(id)
);

--
-- Table QComment stands for Question Comment
--
DROP TABLE IF EXISTS QComment;
CREATE TABLE QComment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "questionid" INTEGER NOT NULL,
    "textbody" TEXT NOT NULL,
    "rating" INTEGER DEFAULT 0,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "updated" DATETIME,
    "deleted" DATETIME,
    FOREIGN KEY(userid) REFERENCES User(id),
    FOREIGN KEY(questionid) REFERENCES Question(id)
);

--
-- Table Tag
--
DROP TABLE IF EXISTS Tag;
CREATE TABLE Tag (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "name" TEXT NOT NULL
);

--
-- Table QuestionHasTag
--
DROP TABLE IF EXISTS QuestionHasTag;
CREATE TABLE QuestionHasTag (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "tagid" INTEGER NOT NULL,
    "questionid" INTEGER NOT NULL,
    FOREIGN KEY(tagid) REFERENCES Tag(id),
    FOREIGN KEY(questionid) REFERENCES Question(id)
);

--
-- Table UserRatesQuestion
--
DROP TABLE IF EXISTS UserRatesQuestion;
CREATE TABLE UserRatesQuestion (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "questionid" INTEGER NOT NULL,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "up" INTEGER DEFAULT 1,
    FOREIGN KEY(userid) REFERENCES User(id),
    FOREIGN KEY(questionid) REFERENCES Question(id)
);

--
-- Table UserRatesAnswer
--
DROP TABLE IF EXISTS UserRatesAnswer;
CREATE TABLE UserRatesAnswer (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "answerid" INTEGER NOT NULL,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "up" INTEGER DEFAULT 1,
    FOREIGN KEY(answerid) REFERENCES Answer(id),
    FOREIGN KEY(userid) REFERENCES User(id)
);

--
-- Table UserRatesAComment
--
DROP TABLE IF EXISTS UserRatesAComment;
CREATE TABLE UserRatesAComment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "commentid" INTEGER NOT NULL,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "up" INTEGER DEFAULT 1,
    FOREIGN KEY(commentid) REFERENCES AComment(id),
    FOREIGN KEY(userid) REFERENCES User(id)
);

--
-- Table UserRatesQComment
--
DROP TABLE IF EXISTS UserRatesQComment;
CREATE TABLE UserRatesQComment (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "userid" INTEGER NOT NULL,
    "commentid" INTEGER NOT NULL,
    "created" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    "up" INTEGER DEFAULT 1,
    FOREIGN KEY(commentid) REFERENCES QComment(id),
    FOREIGN KEY(userid) REFERENCES User(id)
);

INSERT INTO User (email, password, name, gravatar) VALUES ("joe@joe.joe", "joe123", "Joe Doe", "https://www.gravatar.com/avatar/8dead64cd2fd27abeabcb20fb9f67930?s=32&d=identicon&r=PG");
INSERT INTO User (email, password, name, gravatar) VALUES ("jane@jane.jane", "jane123", "Jane Doe", "https://www.gravatar.com/avatar/42cde8637248112a6e210f053603b600?s=32&d=identicon&r=PG");
INSERT INTO User (email, password, name, gravatar) VALUES ("jack@jack.jack", "jack123", "Jack Doe", "https://www.gravatar.com/avatar/322e96010531f4692922fc2b22482ed1?s=32&d=identicon&r=PG");
INSERT INTO User (email, password, name, gravatar) VALUES ("hate@hate.hate", "hate123", "Hate Doe", "https://www.gravatar.com/avatar/bf3ad5e9ebf719bda30b3d500dde1ea7?s=32&d=identicon&r=PG");
INSERT INTO Question (userid, title, textbody) VALUES (1, "Hur blir jag stormästare?", "Jag vill bli stormästare, kanske världsmästare inom 10-15 år. Jag har alltså väldigt stora ambitioner men vet inte hur jag ska komma igång. Jag har memorerat en massa öppningar, men till ingen nytta. Kan ni tipsa mig med något? Hjälp mig!");
INSERT INTO Question (userid, title, textbody) VALUES (2, "Damgambit", "Som svart har jag länge valt att avböja boendeoffret, men på sistone har jag börjat experimentera med antagen damgambit. Det verkar funka bra, men främst mot svaga spelare. Vad tycker ni?");
INSERT INTO Answer (userid, questionid, textbody) VALUES (2, 1, "Man ska träna slutspel och analysera positionella partier. Att bara plugga öppningar leder ingenstans.");
INSERT INTO Answer (userid, questionid, textbody) VALUES (3, 1, "Ett annat bra sätt är att spela igenom klassiska partier och analysera dragen med hjälp av en dator.");
INSERT INTO Tag (name) VALUES ("slutspel");
INSERT INTO Tag (name) VALUES ("öppning");
INSERT INTO Tag (name) VALUES ("spelstyrka");
INSERT INTO Tag (name) VALUES ("världsmästare");
INSERT INTO Tag (name) VALUES ("spelregler");
INSERT INTO Tag (name) VALUES ("pjäser");
INSERT INTO Tag (name) VALUES ("schackklubbar");
INSERT INTO Tag (name) VALUES ("filmer");
INSERT INTO Tag (name) VALUES ("böcker");
INSERT INTO QComment (userid, questionid, textbody) VALUES (3, 1, "Intressant fråga!");
INSERT INTO QComment (userid, questionid, textbody) VALUES (3, 2, "Bra fråga!");
INSERT INTO QComment (userid, questionid, textbody) VALUES (4, 1, "Glöm det, du kommer aldrig att bli nåt!");
INSERT INTO AComment (userid, answerid, textbody) VALUES (3, 1, "Mycket bra svar!");
INSERT INTO AComment (userid, answerid, textbody) VALUES (1, 1, "Tack för tipset!");
INSERT INTO AComment (userid, answerid, textbody) VALUES (4, 1, "Dumheter!");
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (3, 1);
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (4, 1);
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (2, 2);
INSERT INTO UserRatesAnswer (userid, answerid) VALUES (3, 1);
INSERT INTO UserRatesQuestion (userid, questionid) VALUES (3, 1);
INSERT INTO UserRatesAComment (userid, commentid) VALUES (2, 1);
INSERT INTO UserRatesQComment (userid, commentid) VALUES (1, 1);
INSERT INTO UserRatesAnswer (userid, answerid, up) VALUES (4, 1, -1);
INSERT INTO UserRatesQuestion (userid, questionid, up) VALUES (4, 1, -1);
INSERT INTO UserRatesAComment (userid, commentid, up) VALUES (4, 1, -1);
INSERT INTO UserRatesQComment (userid, commentid, up) VALUES (4, 1, -1);
