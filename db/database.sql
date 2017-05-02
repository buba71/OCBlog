create database if not exists OCBlog character set utf8 collate utf8_unicode_ci;
use OCBlog;

grant all privileges on OCBlog.* to 'ocblog_user'@'localhost' identified by 'david';