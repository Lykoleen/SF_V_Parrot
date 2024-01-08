create table if not exists garage
(
    id_garage int primary key auto_increment not null,
    name varchar(50) not null,
    mail varchar(50) not null,
    adress varchar(255) not null,
    tel int not null
);

create table if not exists garage_users
(
    garage_id int,
    foreign key (garage_id) reference garage(id_garage),
    users_id int,
    foreign key (users_id) reference users(id_users)
);

create table if not exists users
(
    id_users int primary key auto_increment not null
    firstname varchar(50) not null,
    lastname varchar(50) not null,
    mail varchar(50) not null,
    password varchar(255) not null,
    role_id int,
    foreign key (role_id) reference role(id_role)
);

create table if not exists role
(
    id_role int primary key auto_increment not null,
    role varchar(255) not null
);

create table if not exists testimonials
(
    id_testimonials int primary key auto_increment not null,
    name varchar(50) not null,
    surname varchar(50) not null,
    message varchar(255) not null,
    score int not null,
    is_actif boolean default 0,
    garage_id int,
    foreign key (garage_id) reference garage(id_garage)
);

create table if not exists schedules
(
    id_schedules int primary key auto_increment not null,
    day varchar(50) not null,
    slot varchar(50) not null,
    opening time,
    closing time,
    close boolean,
    garage_id int,
    foreign key (garage_id) reference garage(id_garage)
);

create table if not exists products
(
    id_products int primary key auto_increment not null,
    category varchar(50) not null,
    type varchar(50) not null,
    title varchar(50) not null,
    price int not null,
    quantity int not null,
    availability boolean,
    garage_id int,
    foreign key (garage_id) reference garage(id_garage)
);

create table if not exists garage_services
(
    garage_id int
    foreign key (garage_id) reference garage(id_garage)
);

create table if not exists services
(
    id_services int primary key auto_increment not null,
    title varchar(50) not null,
    description varchar(255) not null
);

create table if not exists pictures
(
    id_pictures int primary key auto_increment not null,
    name varchar(255) not null,
    path varchar(255) not null,
    vehicles_id int,
    foreign key (vehicles_id) reference vehicles(id_vehicles),
    services_id int,
    foreign key (services_id) reference services(id_services)
);

create table if not exists vehicles
(
    id_vehicles int primary key auto_increment not null,
    model varchar(50) not null,
    years int not null,
    mileage int not null,
    description text(20000) not null,
    brand_id int,
    foreign key (brand_id) reference brand(id_brand),
    gearbox_id int,
    foreign key (gearbox_id) reference gearbox(id_gearbox)
);

create table if not exists brand
(
    id_brand int primary key auto_increment not null,
    name varchar(255) not null
);

create table if not exists gearbox
(
    id_gearbox int primary key auto_increment not null,
    name varchar(255) not null
);