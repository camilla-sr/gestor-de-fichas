create database if not exists arquivoFichas;
use arquivoFichas;

# TABELAS SEM FK
create table RACAS(
	id_raca				int unsigned auto_increment,
    raca				varchar(50) not null unique,		# incluindo sub-raças
    deslocamento		decimal(4,1) not null,				# em Metros
    primary key(id_raca)
);

create table TENDENCIAS(
	id_tend				int unsigned auto_increment,
    tendencia			varchar(25) not null unique,
    primary key(id_tend)
);

create table ANTECEDENTES(
	id_antec			int unsigned auto_increment,
    antecedente			varchar(30) not null unique,
    primary key(id_antec)
);

create table TALENTOS(
	id_talento			int unsigned auto_increment,
    talento				varchar(50) not null unique,
    descricao			text not null,
    requisito			varchar(30) default 'Não necessário',
    primary key(id_talento)
);

create table DADOS(
	id_dado				int unsigned auto_increment,
    descricao			varchar(3),
    primary key(id_dado)
);

create table T_DANO(
	id_dano				int unsigned auto_increment,
    descricao			varchar(30) unique,
    primary key(id_dano)
);


create table ARMADURAS(
	id_armor			int unsigned auto_increment,
    tipo				varchar(30) not null unique,
    preco				int(4) not null,
    moeda				char(2) not null,
    ca					int(2) not null,				#Somado com valor do modificador abaixo	|	CÁLCULO FEITO
    modificador			varchar(35) default '----',		#Incrementa no valor de cima			|	MANUALMENTE
    requisito			varchar(8) default '----',
    desvantagem			varchar(11) default '----',
    peso				decimal(4,2) default 0.0,		# Botão para adicionar armadura personalizada
    primary key(id_armor)
);

create table EQUIPAMENTOS(
	id_item				int unsigned auto_increment,
    item				varchar(50) not null unique,
    preco				int(3) not null,
    moeda				char(2) not null,
    peso				decimal(4,2) not null,
    primary key(id_item)
);

create table FERRAMENTAS(
	id_ferram			int unsigned auto_increment,
    ferramenta			varchar(55) not null,
    descricao			varchar(150) default '',
    preco				int(2) not null,
    moeda				char(2) not null,
    peso				decimal(4,2) not null,
    primary key(id_ferram)
);

create table BUGIGANGAS(
	id_bugig			int unsigned auto_increment,
    descricao			varchar(250) not null,
    primary key(id_bugig)
);

create table IDIOMAS(
	id_idioma			int unsigned auto_increment,
    descricao			varchar(30) not null,
    alfabeto			varchar(45) default '',
    primary key(id_idioma)
);

create table HAB_MAGIA(
	id_hab				int unsigned auto_increment,
    hab_chave			varchar(30) not null,
    primary key(id_hab)
);

# TABELAS COM FK
create table CLASSES(
	id_classe			int unsigned auto_increment,
	classe				varchar(30) not null unique,
    descricao			varchar(200) not null,
    hab_primaria		varchar(30) not null,
    dvida				int unsigned not null,
    p_armas_armad		varchar(200) not null,
    pt_Resistencia		varchar(30) not null,		#Proficiência em Teste de Resistência
    primary key(id_classe),
    constraint foreign key (Dvida) references DADOS(id_dado)
);

create table HABILIDADES_C(
	id_habC				int unsigned auto_increment,
    i_classe			int unsigned not null,
    nome				varchar(55) not null unique,
    descricao			text not null,
    primary key(id_habC),
    constraint foreign key (i_classe) references CLASSES (id_classe)
);

create table TRACO_PERSONALIDADE(
	id_traco			int unsigned auto_increment,
    i_antec				int unsigned not null,
    descricao			varchar(200) not null,
    primary key(id_traco),
    constraint foreign key (i_antec) references ANTECEDENTES(id_antec)
);

create table IDEAIS(
	id_ideal			int unsigned auto_increment,
    i_antec				int unsigned not null,
    descricao			varchar(300) not null,
    primary key(id_ideal),
    constraint foreign key (i_antec) references ANTECEDENTES(id_antec)
);

create table VINCULOS(
	id_vinculo			int unsigned auto_increment,
    i_antec				int unsigned not null,
    descricao			varchar(300) not null,
    primary key(id_vinculo),
    constraint foreign key (i_antec) references ANTECEDENTES(id_antec)
);

create table DEFEITOS(
	id_defeito			int unsigned auto_increment,
    i_antec				int unsigned not null,
    descricao			varchar(300) not null,
    primary key(id_defeito),
    constraint foreign key (i_antec) references ANTECEDENTES(id_antec)
);

create table ARQUETIPOS(
	id_arque			int unsigned auto_increment,
    i_classe			int unsigned not null,
    titulo				varchar(50) not null unique,
    descricao			text not null,
    primary key(id_arque),
    constraint foreign key (i_classe) references CLASSES(id_classe)
);

create table HABILIDADES_R(
	id_habR				int unsigned auto_increment,
    i_raca				int unsigned not null,
    nome				varchar(60) not null unique,
    descricao			text not null,
    primary key(id_habR),
    constraint foreign key (i_raca) references RACAS(id_raca)
);

create table GLOSSARIO_MAGIAS(
	id_magia			int unsigned auto_increment,
    i_usuario			int unsigned not null,
    magia				varchar(60) not null unique,
    nivel				int(1) not null,
    descricao			text not null,
    primary key(id_magia)
    # FK adicionada adiante
);

create table USUARIO_MAGICO(
	id_usuario			int unsigned auto_increment,
    i_magia				int unsigned not null,
    i_classe			int unsigned not null,
    primary key(id_usuario),
    constraint foreign key (i_magia) references GLOSSARIO_MAGIAS(id_magia),
    constraint foreign key (i_classe) references CLASSES(id_classe)
);

# adicionando a FK de usuário de magia na tabela GLOSSÁRIO
alter table GLOSSARIO_MAGIAS
add constraint foreign key (i_usuario) references USUARIO_MAGICO(id_usuario); 

create table DEPOSITO(				# Armazena apenas armaduras
	id_control			int unsigned auto_increment,
    i_armor				int unsigned not null,
    quantidade			int(2) default 0,
    primary key(id_control),
    constraint foreign key (i_armor) references ARMADURAS (id_armor)
);

create table ARMAS(
	id_weapon			int unsigned auto_increment,
    arma				varchar(50) not null unique,
    preco				int(2) not null,
    moeda				char(2) not null,
	quantidade_dado		int(2) default 1,
    i_dadoDano			int unsigned not null,
	i_dano				int unsigned not null,
    peso				decimal(4,2) not null,
    propriedades		varchar(65) default '----',
    primary key(id_weapon),
    constraint foreign key (i_dadoDano) references DADOS(id_dado),
    constraint foreign key (i_dano) references T_DANO(id_dano)
);

create table ARSENAL(				# Armazena apenas armas
	id_arsenal			int unsigned auto_increment,
    i_arma				int unsigned not null,
    quantidade			int(3) default 0,
    primary key(id_arsenal),
    constraint foreign key (i_arma) references ARMAS(id_weapon)
);

create table MOCHILA(				# Armazena apenas itens da tabela de equipamentos
	id_tralhas			int unsigned auto_increment,
    i_item				int unsigned not null,
    quantidade			int(3) default 0,
    primary key(id_tralhas),
    constraint foreign key (i_item) references EQUIPAMENTOS(id_item)
);

create table UTILITARIOS(			# Armazena apenas itens da tebela de ferramentas
	id_utilit			int unsigned auto_increment,
    i_ferramenta		int unsigned not null,
    quantidade			int(3) default 0,
    primary key(id_utilit),
    constraint foreign key (i_ferramenta) references FERRAMENTAS(id_ferram)
);

create table TRANQUEIRAS(			# Armazena apenas itens da tabela de bugigangas
	id_tranq			int unsigned auto_increment,
    i_bugig				int unsigned not null,
    quantidade				int(3) default 0,
    primary key(id_tranq),
    constraint foreign key (i_bugig) references BUGIGANGAS(id_bugig)
);

create table TRUQUES (
    id_truque		 	int unsigned auto_increment,
    i_usuario		 	int unsigned not null,
    truque			 	varchar(50) not null unique,
    descricao 		 	text not null,
    primary key(id_truque),
    constraint foreign key (i_usuario) references USUARIO_MAGICO (id_usuario)
);

create table JOGADOR(				# TELA 1
	nome				varchar(35) not null,
	usuario				varchar(15) not null unique,
    senha				varchar(15) not null,
	id_player			int unsigned auto_increment,
    
    xp					int(10) default 0,			# Incrementa nível, porém opcional
    nivel				int(2) default 0,
    i_raca				int unsigned,
    i_classe			int unsigned,
    i_tend				int unsigned,
    i_antec				int unsigned,
    pv					int(5) default 10,		# Pontos de vida totais
    pv_atual			int(5) default 0,
	pv_temp				int(5) default 0,			# Pontos de vida temporários/não aparece, mas soma o pv
    proficiencia		int(2) default 0,
    ca					int(2) default 0,			# Somado CA da armadura com atributos e o bonus
	ca_bonus			int(2) default 0,
    iniciativa			int(2) default 0,			# Puxa Mod. Destreza
    iniciativa_bonus	int(2) default 0,			# Incrementa Iniciativa acima
	desl				decimal(4,2) default 9.0,
    desl_bonus			decimal(4,2) default 0.0,	# Incrementa o de cima
    desl_agua			decimal(4,2) default 0.0,
    desl_escalada		decimal(4,2) default 0.0,
    desl_voo			decimal(4,2) default 0.0,
    percepcao_pass		int(2) default 0,			# 10 + proeficiência percepção + mod. sabedoria
    
    # ATRIBUTOS
    forca				int(2) default 0,
    mod_for				int(2) default 0,
    destreza			int(2) default 0,
    mod_des				int(2) default 0,
    constituicao		int(2) default 0,
    mod_con				int(2) default 0,
    inteligencia		int(2) default 0,
    mod_int				int(2) default 0,
    sabedoria			int(2) default 0,
    mod_sab				int(2) default 0,
    carisma				int(2) default 0,
    mod_car				int(2) default 0,
    
    # PERÍCIAS
    atletismo			int(1) default 0,			#FORÇA
    atle_valor			int(2) default 0,	# Mod. atributo + bônus
    acrobacia			int(1) default 0,			#DESTREZA
    acro_valor			int(2) default 0,
    furtividade			int(1) default 0,
    furt_valor			int(2) default 0,
    prestidigitacao		int(1) default 0,
    prest_valor			int(2) default 0,
    arcanismo			int(1) default 0,			#INTELIGÊNCIA
    arca_valor			int(2) default 0,
    historia			int(1) default 0,
    histo_valor			int(2) default 0,
    investigacao		int(1) default 0,
    inves_valor			int(2) default 0,
    natureza			int(1) default 0,
    natu_valor			int(2) default 0,
    religiao			int(1) default 0,
    reli_valor			int(2) default 0,
    intuicao			int(1) default 0,			#SABEDORIA
    intui_valor			int(2) default 0,
    lidar_Animais		int(1) default 0,
    lidar_valor			int(2) default 0,
    medicina			int(1) default 0,
    medi_valor			int(2) default 0,
    percepcao			int(1) default 0,
    perc_valor			int(2) default 0,
    sobrevivencia		int(1) default 0,
    sobre_valor			int(2) default 0,
    atuacao				int(1) default 0,			#CARISMA
    atua_valor			int(2) default 0,
    enganacao			int(1) default 0,
    enga_valor			int(2) default 0,
    intimidacao			int(1) default 0,
    inti_valor			int(2) default 0,
    persuasao			int(1) default 0,
    persu_valor			int(2) default 0,
    
    primary key(id_player),
    constraint foreign key (i_raca) references RACAS(id_raca),
    constraint foreign key (i_classe) references CLASSES(id_classe),
    constraint foreign key (i_tend) references TENDENCIAS(id_tend),
    constraint foreign key (i_antec) references	ANTECEDENTES(id_antec)
);

create table DETALHES(				# TELA 2
	i_hab_classe	int unsigned default 0,
    i_hab_raca		int unsigned default 0,
    i_arque			int unsigned default 0,
    i_talento		int unsigned default 0,
    i_idioma		int unsigned default 0,
    i_P_weapon		int unsigned default 0,		# Proficiência em Armas
	i_P_armor		int unsigned default 0,		# Proficiência em Armadura
    i_P_ferram		int unsigned default 0,		# Proficiência em Ferramentas
    constraint foreign key (i_hab_classe) references HABILIDADES_C(id_habC),
    constraint foreign key (i_hab_raca) references HABILIDADES_R(id_habR),
    constraint foreign key (i_arque) references ARQUETIPOS(id_arque),
    constraint foreign key (i_talento) references TALENTOS(id_talento),
    constraint foreign key (i_idioma) references IDIOMAS(id_idioma),
    constraint foreign key (i_P_weapon) references ARMAS(id_weapon),
    constraint foreign key (i_P_armor) references ARMADURAS(id_armor),
    constraint foreign key (i_P_ferram) references FERRAMENTAS (id_ferram)
);

create table CARACTERISTICAS(		# TELA 3
	foto			mediumblob, # 16 MB
    idade			int(3) default 0,
    peso			decimal(5,2) default 0.0,
    cabelos			varchar(40) default '----',
    olhos			varchar(40) default '----',
    pele			varchar(40) default '----',
	personalizado	varchar(500) default '',
    i_traco_pers	int unsigned,
    i_ideal			int unsigned,
    i_vinculo		int unsigned,
    i_defeito		int unsigned,
    historia		text default '',
    aliados_org		text default '',
    tesouro			text default '',
    constraint foreign key (i_traco_pers) references TRACO_PERSONALIDADE(id_traco),
    constraint foreign key (i_ideal) references IDEAIS(id_ideal),
    constraint foreign key (i_vinculo) references VINCULOS(id_vinculo),
    constraint foreign key (i_defeito) references DEFEITOS(id_defeito)
);

create table INVENTARIO(
	# RIQUEZA
    cobre			int(5) default 0,
    prata			int(5) default 0,
    electro			int(5) default 0,
    ouro			int(5) default 0,
    platina			int(5) default 0,
    i_deposito		int unsigned,		# Armazena armaduras
    i_arsenal		int unsigned,		# Armazena armas
    i_mochila		int unsigned,		# Armazena equipamentos
    i_utilitario	int unsigned,		# Armazena ferramentas
    i_tranqueiras	int unsigned,		# Armazena bugigangas
    constraint foreign key (i_deposito) references DEPOSITO(id_control),
    constraint foreign key (i_arsenal) references ARSENAL(id_arsenal),
    constraint foreign key (i_mochila) references MOCHILA(id_tralhas),
    constraint foreign key (i_utilitario) references UTILITARIOS(id_utilit),
    constraint foreign key (i_tranqueiras) references TRANQUEIRAS(id_tranq)
);

create table GRIMORIO(		# TELA 5
	i_hab_chave		int unsigned,			# ATRIBUTO CHAVE USADO NA MAGIA
    i_truque		int unsigned,
    i_magia			int unsigned,
    uso1_max		int(2) default 0,		#SLOT MAGIA LVL 1
    uso1_atual		int(2) default 0,
    uso2_max		int(2) default 0,		#SLOT MAGIA LVL 2
    uso2_atual		int(2) default 0,
    uso3_max		int(2) default 0,		#SLOT MAGIA LVL 3
    uso3_atual		int(2) default 0,
	uso4_max		int(2) default 0,		#SLOT MAGIA LVL 4
    uso4_atual		int(2) default 0,
    uso5_max		int(2) default 0,		#SLOT MAGICA LVL 5
    uso5_atual		int(2) default 0,
    uso6_max		int(2) default 0,		#SLOT MAGIA LVL 6
    uso6_atual		int(2) default 0,
    uso7_max		int(2) default 0,		#SLOT MAGIA LVL 7
    uso7_atual		int(2) default 0,
    uso8_max		int(2) default 0,		#SLOT MAGIA LVL 8
    uso8_atual		int(2) default 0,
    uso9_max		int(2) default 0,		#SLOT LVL 9
    uso9_atual		int(2) default 0,
    constraint foreign key (i_hab_chave) references HAB_MAGIA(id_hab),
    constraint foreign key (i_truque) references TRUQUES (id_truque),
    constraint foreign key (i_magia) references GLOSSARIO_MAGIAS (id_magia)
);