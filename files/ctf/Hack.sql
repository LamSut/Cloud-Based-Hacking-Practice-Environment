drop database hack;
create database hack character set 'utf8';
use hack;
GRANT FILE on *.* TO 'root'@'localhost';
-- drop table acc
create table acc(
	idacc varchar(15) primary key,
	pass varchar(100),
    name varchar(30),
    gender bool default true,
	email varchar(50) unique,
    avatar longblob,
	admin bool default false,
    darkmode bool default false
);
-- select * from acc
insert into acc values('B2111933','ee79976c9380d5e337fc1c095ece8c8f22f91f306ceeb161fa51fecede2c4ba1','Trương Đặng Trúc Lâm',true,'lamb2111933@student.ctu.edu.vn',LOAD_FILE("F:/XAMPP/htdocs/Project-Web-CT214H-B2111933/img/blank.png"),false,false);
insert into acc values('B3333333','ee79976c9380d5e337fc1c095ece8c8f22f91f306ceeb161fa51fecede2c4ba1','LS',true,'ls@gmail.com',LOAD_FILE("F:/XAMPP/htdocs/Project-Web-CT214H-B2111933/img/blank.png"),true,true);
insert into acc values('B4444444','ee79976c9380d5e337fc1c095ece8c8f22f91f306ceeb161fa51fecede2c4ba1','Yellow King',true,'kaiser@gmail.com',LOAD_FILE("F:/XAMPP/htdocs/Project-Web-CT214H-B2111933/img/blank.png"),false,false);
insert into acc values('B2111999','ee79976c9380d5e337fc1c095ece8c8f22f91f306ceeb161fa51fecede2c4ba1','Hưng Gay',false,'hung2111999@student.ctu.edu.vn',LOAD_FILE("F:/XAMPP/htdocs/Project-Web-CT214H-B2111933/img/blank.png"),false,false);

-- drop table ctf
CREATE TABLE ctf(
  idctf INT PRIMARY KEY auto_increment,
  title VARCHAR(50) UNIQUE NOT NULL,
  type VARCHAR(30) NOT NULL,
  des TEXT,
  hint TEXT,
  file VARCHAR(200),  -- Stores the filename of the downloadable file
  keyfile varchar(30),
  time varchar(30),
  author varchar(15),
  constraint fk_author foreign key (author) references acc(idacc)
);
-- select * from ctf
insert into ctf values(1,'mongki','Reverse Engineering','This is just for testing function download in Web.','Open the eye','monkey.jpg','thekey',sysdate(),'B3333333');
insert into ctf values(2,'dog','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(3,'cow','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(4,'sheep','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(5,'monkey','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(6,'mongki1','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(7,'dog1','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(8,'cow1','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(9,'sheep1','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(10,'monkey1','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(11,'mongki2','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(12,'dog2','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(13,'cow2','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(14,'sheep2','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(15,'monkey2','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(16,'mongki3','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(17,'dog3','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(18,'cow3','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(19,'sheep3','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(20,'monkey3','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(21,'mongki4','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(22,'dog4','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(23,'cow4','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(24,'sheep4','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(25,'monkey4','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(26,'mongki5','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(27,'dog5','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(28,'cow5','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(29,'sheep5','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(30,'monkey5','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(31,'mongki6','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(32,'dog6','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(33,'cow6','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(34,'sheep6','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(35,'monkey6','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(36,'mongki7','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(37,'dog7','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(38,'cow7','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(39,'sheep7','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(40,'monkey7','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(41,'mongki8','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(42,'dog8','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(43,'cow8','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(44,'sheep8','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(45,'monkey8','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(46,'mongki9','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(47,'dog9','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(48,'cow9','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(49,'sheep9','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(50,'monkey9','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(51,'mongki10','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(52,'dog10','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(53,'cow10','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(54,'sheep10','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(55,'monkey10','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(56,'mongki11','Web Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(57,'dog11','Binary Exploitation','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(58,'cow11','Cryptography','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(59,'sheep11','Forensics','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(60,'monkey11','Reverse Engineering','aaaaaa','bbbbbb','cccc','thekey',sysdate(),'B3333333');
insert into ctf values(61,'mongki22','Reverse Engineering','This is just for testing function download in Web.','Open the eye','monkey.jpg','thekey',sysdate(),'B3333333');

-- drop table ctfAttempt
create table ctfAttempt(
	idctfAttempt int primary key auto_increment,
    idacc varchar(15),
    idctf int,
    time varchar(30),
	constraint fk_attempt_acc foreign key (idacc) references acc(idacc),
	constraint fk_attempt_ctf foreign key (idctf) references ctf(idctf)
);
-- select * from ctfAttempt;
insert into ctfAttempt values (1,'B2111933',1,sysdate());

create table cmt(
	idcmt int primary key auto_increment,
    content text(500),
    time varchar(30),
    idacc varchar(15),
    constraint fk_idacc foreign key (idacc) references acc(idacc)
);
-- select * from cmt
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('chú bé đần',sysdate(),'B4444444');
insert into cmt(content,time,idacc) values('monkey',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('cow',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('sfdfgdvcbhjxfvccvxzhvxbjhgasbdhajnvb xccb zxnc cxbbxcbncxkcnxjkxnccj á á á vjdkvhkkuchvukjhi',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('chú bé đần',sysdate(),'B4444444');
insert into cmt(content,time,idacc) values('monkey',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('cow',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('chú bé đần',sysdate(),'B4444444');
insert into cmt(content,time,idacc) values('monkey',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('cow',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('sfdfgdvcbhjxfvccvxzhvxbjhgasbdhajnvb xccb zxnc cxbbxcbncxkcnxjkxnccj á á á vjdkvhkkuchvukjhi',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('chú bé đần',sysdate(),'B4444444');
insert into cmt(content,time,idacc) values('monkey',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('afcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('ergyrhgrfhsvdgvsvzafhtjhjtjytytdytrysvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('afytyuhthbhgfdxfhcasfcfvdgvsvzafcasfcfvdgddafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('cow',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('sfdfgdvcbhjxfvccvxzhvxbjhgasbdhajnvb xccb zxnc cxbbxcbncxkcnxjkxnccj á á á vjdkvhkkuchvukjhi',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('chú bé đần',sysdate(),'B4444444');
insert into cmt(content,time,idacc) values('monkey',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('afcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('ergyrhgrfhsvdgvsvzafhtjhjtjytytdytrysvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('afytyuhthbhgfdxfhcasfcfvdgvsvzafcasfcfvdgddafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('cow',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('sfdfgdvcbhjxfvccvxzhvxbjhgasbdhajnvb xccb zxnc cxbbxcbncxkcnxjkxnccj á á á vjdkvhkkuchvukjhi',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');
insert into cmt(content,time,idacc) values('afcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('ergyrhgrfhsvdgvsvzafhtjhjtjytytdytrysvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('afytyuhthbhgfdxfhcasfcfvdgvsvzafcasfcfvdgddafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvdgvsvzafcasfcfvd',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('dog',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('cow',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('sfdfgdvcbhjxfvccvxzhvxbjhgasbdhajnvb xccb zxnc cxbbxcbncxkcnxjkxnccj á á á vjdkvhkkuchvukjhi',sysdate(),'B3333333');
insert into cmt(content,time,idacc) values('mongki',sysdate(),'B2111933');

