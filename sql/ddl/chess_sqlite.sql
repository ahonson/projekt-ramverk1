--
-- Table User
--
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "email" TEXT NOT NULL UNIQUE,
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

-- hashed passwords for: Joe123, Jane123, Jack123, Hate123
INSERT INTO User (email, password, name, gravatar, rating) VALUES ("joe@joe.joe", "23be5d5d9d25a6e279f86520f2bf5ad4", "Joe Doe", "https://www.gravatar.com/avatar/8dead64cd2fd27abeabcb20fb9f67930?s=32&d=identicon&r=PG", 18);
INSERT INTO User (email, password, name, gravatar, rating) VALUES ("jane@jane.jane", "f83c2fd428d240f5297142c5ca984f62", "Jane Doe", "https://www.gravatar.com/avatar/42cde8637248112a6e210f053603b600?s=32&d=identicon&r=PG", 15);
INSERT INTO User (email, password, name, gravatar, rating) VALUES ("jack@jack.jack", "ea2dfb9ca92706e1c03b2c7baaf69f91", "Jack Doe", "https://www.gravatar.com/avatar/322e96010531f4692922fc2b22482ed1?s=32&d=identicon&r=PG", 24);
INSERT INTO User (email, password, name, gravatar, rating) VALUES ("hate@hate.hate", "3295b8aa77f92122c4664f7fd06bba9b", "Hate Doe", "https://www.gravatar.com/avatar/bf3ad5e9ebf719bda30b3d500dde1ea7?s=32&d=identicon&r=PG", 6);
INSERT INTO Question (userid, title, textbody) VALUES (1, "Hur blir jag stormästare?", "**Jag vill bli stormästare**, kanske världsmästare inom 10-15 år. Jag har alltså väldigt stora ambitioner men vet inte hur jag ska komma igång. Jag har memorerat en massa öppningar, men till ingen nytta. Kan ni tipsa mig med något? Hjälp mig!");
INSERT INTO Question (userid, title, textbody) VALUES (2, "Damgambit", "Som svart har jag länge valt att *avböja boendeoffret*, men på sistone har jag börjat experimentera med **antagen damgambit**. Det verkar funka bra, men främst mot svaga spelare.

Vad tycker ni?");
INSERT INTO Question (userid, title, textbody) VALUES (3, "Till salu", "Jag **vill sälja** mina *schackböcker* om

* öppningar
* slutspel
* reglerna
* spelets historia

Ngn som är intresserad?");
INSERT INTO Question (userid, title, textbody) VALUES (1, "En passant", "Jag är nybörjare och behöver lite hjälp. Är det ngn som kan förklara för mig vad en passant är för ngt?. Jag vet att det har ngt med bönderna att göra men har aldrig riktigt förstått vad det hela går ut på.");
INSERT INTO Answer (userid, questionid, textbody) VALUES (2, 1, "Man ska träna slutspel och analysera positionella partier. Att bara plugga öppningar leder ingenstans.");
INSERT INTO Answer (userid, questionid, textbody) VALUES (3, 1, "Ett annat bra sätt är att spela igenom klassiska partier och analysera dragen med hjälp av en dator.");
INSERT INTO Answer (userid, questionid, textbody) VALUES (1, 3, "Jag vill gärna köpa en öppningsbok till en billig peng.");
INSERT INTO Answer (userid, questionid, textbody) VALUES (3, 2, "Antagen damgambit är bäst utan tvekan.");
INSERT INTO Answer (userid, questionid, textbody) VALUES (2, 4, "[Här](https://www.google.com) kan du hitta mycket bra information om spelreglerna och mycket mer.");
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
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (1, 3);
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (2, 3);
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (5, 3);
--INSERT INTO QuestionHasTag (tagid, questionid) VALUES (3, 4);
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (5, 4);
INSERT INTO QuestionHasTag (tagid, questionid) VALUES (6, 4);
-- INSERT INTO UserRatesQuestion (userid, questionid) VALUES (3, 1);
-- INSERT INTO UserRatesQuestion (userid, questionid, up) VALUES (4, 1, -1);
-- INSERT INTO UserRatesAnswer (userid, answerid) VALUES (3, 1);
-- INSERT INTO UserRatesAnswer (userid, answerid, up) VALUES (4, 1, -1);
-- INSERT INTO UserRatesAComment (userid, commentid) VALUES (2, 1);
-- INSERT INTO UserRatesAComment (userid, commentid, up) VALUES (4, 1, -1);
-- INSERT INTO UserRatesQComment (userid, commentid) VALUES (1, 1);
-- INSERT INTO UserRatesQComment (userid, commentid, up) VALUES (4, 1, -1);
