<?php

    /* Setup */
    include('database_connection.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);

    /* Setting up user table */
    $db->query("drop table if exists user");
    $db->query("create table user (
        uid int not null auto_increment,
        name text not null,
        email text not null,
        password text not null,
        primary key (uid));");

    /* Setting up location table */
    $db->query("drop table if exists location");
    $db->query("create table location (
        lid int not null auto_increment,
        name text not null,
        address text not null,
        uid int not null,
        inout varchar(255) default "out",
        time varchar(255) default "night",
        money varch(255) default "$$$",
        activity varchar(255) default "other",
        primary key (lid));");

    /* Setting up picture table */
    $db->query("drop table if exists picture");
    $db->query("create table picture (
        pid int not null auto_increment,
        uid int not null,
        name text not null,
        description text not null);");

    /* Setting up preference table */
    $db->query("drop table if exists preference");
    $db->query("create table preference (
        uid int not null,
        inout varchar(255) default "out",
        time varchar(255) default "night",
        money varch(255) default "$$$",
        activity varchar(255) default "other");")