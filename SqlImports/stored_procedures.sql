# Stored procedures


DELIMITER //

create procedure sp_search(in keyword varchar(250), in user_type varchar(10), in pindex int)
begin
	if user_type = 'guest' then
		select PartName, PartNumber, Suppliers, Category, Description01 from carparts where 
			PartName like concat(concat('%', keyword), '%') or  PartNumber like concat(concat('%', keyword), '%') 
			or Suppliers like concat(concat('%', keyword), '%') or Category like concat(concat('%', keyword), '%')
			or Description01 like concat(concat('%', keyword), '%') order by PartName limit pindex, 10;
	elseif user_type = 'user' then
		select * from carparts where 
			PartName like concat(concat('%', keyword), '%') or  PartNumber like concat(concat('%', keyword), '%') 
			or Suppliers like concat(concat('%', keyword), '%') or Category like concat(concat('%', keyword), '%')
			or Description01 like concat(concat('%', keyword), '%') order by PartName limit pindex, 10;
	elseif user_type = 'admin' then
		select * from carparts where 
			PartName like concat(concat('%', keyword), '%') or  PartNumber like concat(concat('%', keyword), '%') 
			or Suppliers like concat(concat('%', keyword), '%') or Category like concat(concat('%', keyword), '%')
			or Description01 like concat(concat('%', keyword), '%') order by PartName limit pindex, 10;
	else
		select 'Invalid user type';
	end if;
end
//


create procedure sp_search_item_count(in keyword varchar(250))
begin
	select count(PartID) from carparts where 
		PartName like concat(concat('%', keyword), '%') or  PartNumber like concat(concat('%', keyword), '%') 
		or Suppliers like concat(concat('%', keyword), '%') or Category like concat(concat('%', keyword), '%')
		or Description01 like concat(concat('%', keyword), '%');
end
//

create procedure sp_authenticate(in username varchar(100), in pass varchar(256))
begin
	select count(ID) from tusers where Username = username and UPassword = pass;
end
//


create procedure sp_get_user_type(in usr varchar(100))
begin
	select @usertype := utype from tusers where Username = usr;
	if @usertype is null then
		select 'guest';
	else 
		select @usertype;
	end if;
end
//

create procedure sp_get_part(in part_id int)
begin
	select * from carparts where PartID = part_id;
end
//

