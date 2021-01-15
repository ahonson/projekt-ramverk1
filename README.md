[![Build Status](https://travis-ci.com/ahonson/projekt-ramverk1.svg?branch=main)](https://travis-ci.com/ahonson/projekt-ramverk1)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/?branch=main)
[![Build Status](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/badges/build.png?b=main)](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/build-status/main)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)
[![Code Coverage](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/ahonson/projekt-ramverk1/?branch=main)

README for project in ramverk1-v2 at BTH fall 2021
************************************************

## About the project

This is my repo for the chess project (kmom10) in ramverk1-v2. This website was built using the [Anax framework](https://github.com/canax) and was inspired by [Stack Overflow](https://stackoverflow.com/). It offers Q&A-functionality with user activity, questions, answers and comments saved to an SQLITE database.

## Installation

Follow these steps to get a working copy of the website. Start a PHP(7) webserver and enter these commands in your terminal:

`git clone https://github.com/ahonson/projekt-ramverk1.git`

`cd projekt-ramverk1/`

`make install`

You can reset the database with:
`sqlite3 data.db.sqlite < sql/ddl/chess_sqlite.sql`
