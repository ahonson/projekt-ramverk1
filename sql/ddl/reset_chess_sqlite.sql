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
