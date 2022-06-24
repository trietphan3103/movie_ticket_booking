create database if not exists BANANA_CINEMA default character set utf8 collate utf8_unicode_ci;
use BANANA_CINEMA;

create table USERS (
	user_id int auto_increment,
	user_name varchar(20) UNIQUE NOT NULL,
	password varchar(255) NOT NULL,
	ho_ten varchar(255),
	gioi_tinh varchar(3) check(gioi_tinh in (N'Nam', N'Nữ')),
	ngay_sinh date,
	sdt varchar(10),
	dia_chi varchar(2550),
	cmnd varchar(12),
	active boolean default true,
	primary key(user_id)
);

create table ROLES (
	role_id int auto_increment,
	mo_ta varchar(2550),
	primary key(role_id)
);

create table USER_ROLE (
	user_id int,
	role_id int,
	primary key(user_id, role_id),
	constraint fk_USER_ROLE_user_id foreign key(user_id) references USERS(user_id),
	constraint fk_USER_ROLE_role_id foreign key(role_id) references ROLES(role_id)
);

create table PHONG_CHIEU(
	phong_chieu_id int auto_increment,
	ten_phong varchar(255) UNIQUE,
	primary key (phong_chieu_id)
);

create table GHE 
(
	ghe_id int auto_increment,
	phong_chieu_id int,
	ma_ghe varchar(10),
	primary key (ghe_id, phong_chieu_id),
	constraint fk_GHE_phong_chieu_id foreign key (phong_chieu_id) references PHONG_CHIEU(phong_chieu_id) ON DELETE CASCADE
);

create table PHIM
(
	phim_id int auto_increment,
	created_by int NOT NULL,
	ten_phim varchar(2550),
	nha_san_xuat varchar(255),
	quoc_gia varchar(255),
	dien_vien varchar(2550),
	dao_dien varchar(2550),
	the_loai varchar(2550),
	ngay_phat_hanh date,
	mo_ta TEXT,
	thoi_luong int default 0,
	primary key(phim_id),
	constraint fk_PHIM_created_by foreign key(created_by) references USERS(user_id)
);

create table IMAGES (
	image_id int auto_increment,
	image_content varchar(2550),
	phim_id int,
	status int,
	the_loai int, 
	primary key(image_id),
	constraint fk_IMAGES_phim_id foreign key(phim_id) references PHIM(phim_id)
);

create table LICH_CHIEU
(
	lich_chieu_id int auto_increment,
	created_by int NOT NULL,
	phong_chieu_id int NOT NULL, 
	phim_id int NOT NULL, 
	gio_bat_dau datetime,
	gio_ket_thuc datetime,
	primary key(lich_chieu_id),
	gia int NOT NULL,
	constraint fk_LICH_CHIEU_phim_id foreign key (phim_id) references PHIM(phim_id),
	constraint fk_LICH_CHIEU_phong_chieu_id foreign key (phong_chieu_id) references PHONG_CHIEU(phong_chieu_id) ON DELETE CASCADE,
	constraint fk_LICH_CHIEU_created_by foreign key(created_by) references USERS(user_id)
);

create table VE_PHIM (
	ve_id int auto_increment,
	ghe_id int,
	lich_chieu_id int NOT NULL,
	created_by int NOT NULL, 
	owner int,
	primary key(ve_id),
	constraint fk_VE_PHIM_lich_chieu_id foreign key(lich_chieu_id) references LICH_CHIEU(lich_chieu_id) ON DELETE CASCADE,
	constraint fk_VE_PHIM_ghe_id foreign key(ghe_id) references GHE(ghe_id),
	constraint fk_VE_PHIM_created_by foreign key(created_by) references USERS(user_id),
	constraint fk_VE_PHIM_owner foreign key(owner) references USERS(user_id)
);

alter table USERS
add constraint chk_USER_sdt check (sdt like '[0-9][0-9][0-9][0-9][0-9][0-9][0-9]');

alter table PHIM
add	constraint chk_PHIM_thoi_luong check (thoi_luong >= 0);

alter table IMAGES
add	constraint chk_IMAGES_the_loai check (the_loai in (0, 1));

alter table VE_PHIM
add constraint chk_VE_PHIM_ghe check (
(select phong_chieu_id from GHE where PHONG_CHIEU.phong_chieu_id = GHE.phong_chieu_id) = (select phong_chieu_id from LICH_CHIEU where LICH_CHIEU.phong_chieu_id = PHONG_CHIEU_phong_chieu_id)
);