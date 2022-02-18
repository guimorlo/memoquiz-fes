# memoquiz-fes

- Projeto criado para o Trabalho final do 1º Semestre da matéria de Fundamentos da Engenharia de Software
- Autores: Guilherme e João Pedro


- Abaixo Scripts de criação do banco e das tabelas (PostgreSQL 12.9)

-- SCHEMA: memoquiz

-- DROP SCHEMA IF EXISTS memoquiz ;

CREATE SCHEMA IF NOT EXISTS memoquiz
    AUTHORIZATION memoquiz;
    
-- Table: memoquiz.user

-- DROP TABLE IF EXISTS memoquiz."user";

CREATE TABLE IF NOT EXISTS memoquiz."user"
(
    name text COLLATE pg_catalog."default" NOT NULL,
    session text COLLATE pg_catalog."default" NOT NULL,
    expire timestamp without time zone,
    CONSTRAINT user_pkey PRIMARY KEY (name),
    CONSTRAINT "UQ_user_session" UNIQUE (session)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS memoquiz."user"
    OWNER to postgres;
    
-- Table: memoquiz.session

-- DROP TABLE IF EXISTS memoquiz.session;

CREATE TABLE IF NOT EXISTS memoquiz.session
(
    hostname text COLLATE pg_catalog."default" NOT NULL,
    playername text COLLATE pg_catalog."default",
    name text COLLATE pg_catalog."default" NOT NULL,
    pass text COLLATE pg_catalog."default",
    connid text COLLATE pg_catalog."default",
    CONSTRAINT session_pkey PRIMARY KEY (hostname)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS memoquiz.session
    OWNER to memoquiz;
    
-- Table: memoquiz.question

-- DROP TABLE IF EXISTS memoquiz.question;

CREATE TABLE IF NOT EXISTS memoquiz.question
(
    codigo bigint NOT NULL DEFAULT nextval('memoquiz.question_codigo_seq'::regclass),
    pergunta text COLLATE pg_catalog."default" NOT NULL,
    alta text COLLATE pg_catalog."default" NOT NULL,
    altb text COLLATE pg_catalog."default" NOT NULL,
    altc text COLLATE pg_catalog."default" NOT NULL,
    altd text COLLATE pg_catalog."default" NOT NULL,
    correta character(1) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT question_pkey PRIMARY KEY (codigo)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS memoquiz.question
    OWNER to memoquiz;
