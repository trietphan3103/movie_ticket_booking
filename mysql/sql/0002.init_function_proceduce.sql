use BANANA_CINEMA;

DROP FUNCTION IF EXISTS _validate_film_session;
DROP PROCEDURE IF EXISTS _get_all_session_by_film_from_current_time;
DROP PROCEDURE IF EXISTS _get_user_ticket_from_current_time;
DROP PROCEDURE IF EXISTS _get_empty_seat_in_specific_session;

DELIMITER $$
CREATE FUNCTION _validate_film_session (p_phong_chieu_id INT, p_time_start DATETIME, p_time_end DATETIME) 
RETURNS BOOLEAN
BEGIN
	RETURN (Select count(*) 
			from BANANA_CINEMA.LICH_CHIEU lc 
			where lc.phong_chieu_id = p_phong_chieu_id
			and ((lc.gio_bat_dau  <= p_time_start and lc.gio_ket_thuc >= p_time_start) or (lc.gio_bat_dau  >= p_time_start and lc.gio_bat_dau <= p_time_end))
			) = 0;
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE _get_all_session_by_film_from_current_time (p_phim_id INT)
BEGIN
	SELECT * FROM BANANA_CINEMA.LICH_CHIEU lc WHERE lc.phim_id = p_phim_id and DATE(lc.gio_bat_dau) >= DATE(SYSDATE());
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE _get_user_ticket_from_current_time (p_user_id INT)
BEGIN
	SELECT * 
	FROM BANANA_CINEMA.VE_PHIM vp  LEFT JOIN BANANA_CINEMA.LICH_CHIEU lc on vp.lich_chieu_id = lc.lich_chieu_id
	WHERE vp.bought_by = p_user_id and DATE(lc.gio_bat_dau) >= DATE(SYSDATE());
END $$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE _get_empty_seat_in_specific_session (p_lich_chieu_id INT)
BEGIN
	declare v_phong_chieu_id int;
	SELECT phong_chieu_id into v_phong_chieu_id FROM BANANA_CINEMA.LICH_CHIEU WHERE lich_chieu_id = p_lich_chieu_id;

	SELECT *
	FROM BANANA_CINEMA.GHE g
	WHERE g.ghe_id not in (SELECT vp.ghe_id FROM BANANA_CINEMA.VE_PHIM vp WHERE vp.lich_chieu_id = p_lich_chieu_id) 
		  and g.phong_chieu_id = v_phong_chieu_id;
END $$
DELIMITER ;
