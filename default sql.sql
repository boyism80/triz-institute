CREATE SCHEMA `triz-institute` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `triz-institute`;

CREATE TABLE boardopt(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(32) NOT NULL,
id VARCHAR(32) NOT NULL,
rauth SMALLINT NOT NULL DEFAULT 1,
wauth SMALLINT NOT NULL DEFAULT 1,
private TINYINT NOT NULL DEFAULT 0,
deleted TINYINT NOT NULL DEFAULT 0);

CREATE TABLE boards(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
btype INT NOT NULL,
title VARCHAR(64) NOT NULL,
content TEXT NOT NULL,
user INT NOT NULL,
date DATETIME NOT NULL,
thumbnail TEXT DEFAULT NULL,
fix TINYINT(1) NOT NULL DEFAULT 0,
hit INT NOT NULL DEFAULT 0,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (btype) REFERENCES boardopt (idx));

CREATE TABLE comment(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
bindex INT NOT NULL,
user INT NOT NULL,
content TEXT NOT NULL,
parent INT DEFAULT NULL,
date DATETIME NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (bindex) REFERENCES boardopt (idx));

CREATE TABLE eclass(
name VARCHAR(64) NOT NULL PRIMARY KEY,
title VARCHAR(64) NOT NULL,
pw VARCHAR(256) NOT NULL,
date DATETIME NOT NULL,
notice INT NOT NULL,
reference INT NOT NULL,
lecture INT NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (notice) REFERENCES boardopt (idx),
FOREIGN KEY (reference) REFERENCES boardopt (idx),
FOREIGN KEY (lecture) REFERENCES boardopt (idx));

CREATE TABLE files(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
title VARCHAR(128) NOT NULL,
path VARCHAR(256) NOT NULL,
ident VARCHAR(32) NOT NULL,
bindex INT NOT NULL,
FOREIGN KEY (bindex) REFERENCES boardopt (idx));

CREATE TABLE fqa(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
question VARCHAR(128) NOT NULL,
answer TEXT NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0);

CREATE TABLE user(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(32) NOT NULL,
id VARCHAR(32) NOT NULL,
password VARCHAR(256) NOT NULL,
job VARCHAR(64) NOT NULL,
level VARCHAR(32) NOT NULL,
email VARCHAR(32) NOT NULL,
recvmail TINYINT NOT NULL DEFAULT 0,
tel VARCHAR(16) NOT NULL,
hp VARCHAR(16) NOT NULL,
register DATETIME NOT NULL,
last_login DATETIME NOT NULL,
mileage INT NOT NULL DEFAULT 0,
privilege SMALLINT NOT NULL DEFAULT 1,
admin TINYINT NOT NULL DEFAULT 0,
deleted TINYINT NOT NULL DEFAULT 0);

CREATE TABLE `leave`(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
uidx INT NOT NULL,
reason VARCHAR(64) NOT NULL,
detail TEXT NOT NULL,
date DATETIME NOT NULL,
FOREIGN KEY (uidx) REFERENCES user (idx) );

CREATE TABLE lecture_info(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
submit_date DATETIME NOT NULL,
limit_date DATETIME DEFAULT NULL,
score INT NOT NULL,
bindex INT NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (bindex) REFERENCES boardopt (idx) );

CREATE TABLE lecture_submit(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
lindex INT NOT NULL,
user INT NOT NULL,
score INT DEFAULT NULL,
content TEXT NOT NULL,
date DATETIME NOT NULL,
comment TEXT DEFAULT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (lindex) REFERENCES lecture_info (idx),
FOREIGN KEY (user) REFERENCES user (idx));

CREATE TABLE lecture_files(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
lindex INT NOT NULL,
user INT NOT NULL,
title VARCHAR(128) NOT NULL,
path VARCHAR(256) NOT NULL,
FOREIGN KEY (lindex) REFERENCES lecture_info (idx),
FOREIGN KEY (user) REFERENCES user (idx) );

INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'공지사항', 'notice', 0, -1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'Q&A', 'qna', 0, 1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'갤러리', 'gallery', 0, 1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'e-learning', 'e-learning', 0, 1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'이야기방', 'community-room', 0, 1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'자료실', 'reference', 0, -1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'Level 1', 'e_level1', 1, -1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'Level 2', 'e_level2', 1, -1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'Level 3', 'e_level3', 1, -1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'TRIZ 강의', 'e_triz', 1, -1, 0);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'상담', 'advice', 1, 1, 1);
INSERT INTO boardopt (name, id, rauth, wauth, private) VALUES (
'강의 자료실', 'e_reference', 1, -1, 0);

INSERT INTO fqa (question, answer) VALUES (
'회원가입은 누구나 가능한가요?', '트리즈에 관심이 있으신 분들은 모두 회원가입이 가능합니다.<br>메인의 로그인을 하시면 회원가입절차가 안내되어 있습니다.');

CREATE TABLE manufacturer (
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(64) NOT NULL);

CREATE TABLE software_product (
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(64) NOT NULL,
manuf INT NOT NULL,
lease7d INT NOT NULL,
lease30d INT NOT NULL,
url VARCHAR(512) NOT NULL,
content TEXT NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (manuf) REFERENCES manufacturer (idx)
);

CREATE TABLE software_thumb (
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
product INT NOT NULL,
path VARCHAR(256) NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (product) REFERENCES software_product (idx)
);

CREATE TABLE publication(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(128) NOT NULL,
subtitle VARCHAR(128) NOT NULL,
writer VARCHAR(128) NOT NULL,
publisher VARCHAR(64) NOT NULL,
price INT NOT NULL,
pubdate DATETIME NOT NULL,
page INT NOT NULL,
ISBN INT NOT NULL,
url VARCHAR(512) NOT NULL,
toc TEXT NOT NULL,
intro TEXT NOT NULL,
pubreview TEXT NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0);

CREATE TABLE publication_thumb(
idx INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
pidx INT NOT NULL,
path VARCHAR(256) NOT NULL,
deleted TINYINT NOT NULL DEFAULT 0,
FOREIGN KEY (pidx) REFERENCES publication (idx));

INSERT INTO boards (btype, title, content, user, date) VALUES (
1, 'ㅇㅇ', 'ㅇㅇㅋ<div><img src="http://210.93.55.71/triz-institute/renewal/assets/uploads/image-files/f78f2318df443a5008fa53ccd4d30e8c.png"></div>', 1, '2016-12-27 16:06:36');