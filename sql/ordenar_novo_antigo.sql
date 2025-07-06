use Crud;

delimiter $$
create procedure ordenar_novo_antigo()
begin
	select * from produtos
    order by data_criacao
    desc;
end $$

delimiter ;


call ordenar_novo_antigo();


